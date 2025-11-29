<?php

namespace App\Http\Controllers\Api\V1\Booking;

use App\Enums\General\TrashStatusEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Booking\StoreBookingRequest;
use App\Http\Requests\Api\Booking\UpdateBookingRequest;
use App\Http\Resources\Booking\BookingCollection;
use App\Http\Resources\Booking\BookingResource;
use App\Mail\Booking\BookingCancellation;
use App\Mail\Booking\BookingConfirmation;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\Booking\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class BookingController extends ApiController
{
    /**
     * BookingController constructor
     */
    public function __construct(
        protected BookingRepositoryInterface $booking,
        protected BookingService $bookingService,
        protected ServiceRepositoryInterface $service
    ) {}

    /**
     * Get all bookings
     *
     * @group Booking Management
     *
     * @authenticated
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) ($request->per_page ?? config('constant.DEFAULT_PER_PAGE'));
        $status = $request->status ?? null;
        $serviceId = $request->service_id ? decryption($request->service_id) : null;
        $trashStatus = $request->trashed ?? null;

        $bookings = $this->booking->paginate($perPage, $status, $trashStatus, $serviceId);

        return $this->sendResponse(
            true,
            new BookingCollection($bookings),
            __('response.bookings_retrieved_successfully')
        );
    }

    /**
     * Get upcoming bookings
     *
     * @group Booking Management
     *
     * @authenticated
     */
    public function getUpcoming(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $bookings = $this->booking->getUpcoming()->take($limit);

        return $this->sendResponse(
            true,
            BookingResource::collection($bookings),
            __('response.bookings_retrieved_successfully')
        );
    }

    /**
     * Get bookings by date
     *
     * @group Booking Management
     *
     * @authenticated
     *
     * @queryParam date required The date to filter bookings
     */
    public function getByDate(Request $request): JsonResponse
    {
        $date = $request->get('date');

        if (! $date) {
            return $this->sendResponse(
                false,
                null,
                'Date parameter is required',
                Response::HTTP_BAD_REQUEST
            );
        }

        // Convert date from user format to database format
        $date = formatDateForDatabase($date);

        if (! $date) {
            return $this->sendResponse(
                false,
                null,
                'Invalid date format. Expected format: '.config('constant.DEFAULT_DATE_FORMAT'),
                Response::HTTP_BAD_REQUEST
            );
        }

        $bookings = $this->booking->getByDate($date);

        return $this->sendResponse(
            true,
            BookingResource::collection($bookings),
            __('response.bookings_retrieved_successfully')
        );
    }

    /**
     * Get booking by ID
     *
     * @group Booking Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted booking ID
     */
    public function show(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $booking = $this->booking->find($id);

        if (! $booking) {
            return $this->sendResponse(
                false,
                null,
                __('response.booking_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->sendResponse(
            true,
            new BookingResource($booking),
            __('response.booking_retrieved_successfully')
        );
    }

    /**
     * Create a new booking
     *
     * @group Booking Management
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Calculate end_time based on service duration
        $service = $this->service->find($data['service_id']);
        $startTime = \Carbon\Carbon::createFromFormat('H:i', $data['start_time']);
        $endTime = $startTime->copy()->addMinutes($service->duration);
        $data['end_time'] = $endTime->format('H:i');

        $booking = $this->bookingService->createBooking($data);

        if (! $booking) {
            return $this->sendResponse(
                false,
                null,
                __('response.time_slot_not_available'),
                Response::HTTP_CONFLICT
            );
        }

        // Dispatch email notification
        Mail::to($booking->client_email)->queue(new BookingConfirmation($booking));

        return $this->sendResponse(
            true,
            new BookingResource($booking),
            __('response.booking_created_successfully'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update an existing booking
     *
     * @group Booking Management
     *
     * @authenticated
     */
    public function update(UpdateBookingRequest $request): JsonResponse
    {
        $booking = $this->booking->find($request->id, null, TrashStatusEnum::WITH_TRASHED);

        if (! $booking) {
            return $this->sendResponse(
                false,
                null,
                __('response.booking_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $data = $request->except('id');
        $updatedBooking = $this->bookingService->updateBooking($request->id, $data);

        return $this->sendResponse(
            true,
            new BookingResource($updatedBooking),
            __('response.booking_updated_successfully')
        );
    }

    /**
     * Cancel a booking
     *
     * @group Booking Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted booking ID
     */
    public function cancel(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $booking = $this->booking->find($id);

        if (! $booking) {
            return $this->sendResponse(
                false,
                null,
                __('response.booking_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $cancellationReason = $request->get('cancellation_reason');
        $this->bookingService->cancelBooking($id, $cancellationReason);

        // Fetch the updated booking with service relationship
        $booking = $this->booking->find($id);

        // Dispatch cancellation email notification
        Mail::to($booking->client_email)->queue(new BookingCancellation($booking, $cancellationReason));

        return $this->sendResponse(
            true,
            new BookingResource($booking),
            __('response.booking_cancelled_successfully')
        );
    }

    /**
     * Confirm a booking
     *
     * @group Booking Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted booking ID
     */
    public function confirm(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $booking = $this->booking->find($id);

        if (! $booking) {
            return $this->sendResponse(
                false,
                null,
                __('response.booking_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->bookingService->confirmBooking($id);

        // Fetch the updated booking with service relationship
        $booking = $this->booking->find($id);

        // Dispatch confirmation email notification
        Mail::to($booking->client_email)->queue(new BookingConfirmation($booking));

        return $this->sendResponse(
            true,
            new BookingResource($booking),
            __('response.booking_confirmed_successfully')
        );
    }

    /**
     * Complete a booking
     *
     * @group Booking Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted booking ID
     */
    public function complete(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $booking = $this->booking->find($id);

        if (! $booking) {
            return $this->sendResponse(
                false,
                null,
                __('response.booking_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->bookingService->completeBooking($id);

        $booking = $this->booking->find($id);

        return $this->sendResponse(
            true,
            new BookingResource($booking),
            __('response.booking_completed_successfully')
        );
    }

    /**
     * Delete a booking
     *
     * @group Booking Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted booking ID
     */
    public function destroy(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $booking = $this->booking->find($id);

        if (! $booking) {
            return $this->sendResponse(
                false,
                null,
                __('response.booking_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->booking->delete($id);

        return $this->sendResponse(
            true,
            null,
            __('response.booking_deleted_successfully')
        );
    }
}
