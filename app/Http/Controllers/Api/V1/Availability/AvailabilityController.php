<?php

namespace App\Http\Controllers\Api\V1\Availability;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\Availability\AvailabilityResource;
use App\Services\Booking\AvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AvailabilityController extends ApiController
{
    /**
     * AvailabilityController constructor
     */
    public function __construct(
        protected AvailabilityService $availabilityService
    ) {
        $this->availabilityService = $availabilityService;
    }

    /**
     * Get available time slots for a date and service
     *
     * @group Availability
     *
     * @queryParam date required The date to check availability
     * @queryParam service_id required The encrypted service ID
     */
    public function getAvailableSlots(Request $request): JsonResponse
    {
        $date = $request->get('date');
        $serviceId = $request->get('service_id');

        if (! $date || ! $serviceId) {
            return $this->sendResponse(
                false,
                null,
                'Date and service_id parameters are required',
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

        $serviceId = decryption($serviceId);
        $slots = $this->availabilityService->getAvailableTimeSlots($date, $serviceId);

        return $this->sendResponse(
            true,
            AvailabilityResource::collection($slots),
            __('response.available_slots_retrieved_successfully')
        );
    }

    /**
     * Get available dates for a service within a date range
     *
     * @group Availability
     *
     * @queryParam service_id required The encrypted service ID
     * @queryParam start_date required The start date
     * @queryParam end_date required The end date
     */
    public function getAvailableDates(Request $request): JsonResponse
    {
        $serviceId = $request->get('service_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        if (! $serviceId || ! $startDate || ! $endDate) {
            return $this->sendResponse(
                false,
                null,
                'service_id, start_date, and end_date parameters are required',
                Response::HTTP_BAD_REQUEST
            );
        }

        // Convert dates from user format to database format
        $startDate = formatDateForDatabase($startDate);
        $endDate = formatDateForDatabase($endDate);

        if (! $startDate || ! $endDate) {
            return $this->sendResponse(
                false,
                null,
                'Invalid date format. Expected format: '.config('constant.DEFAULT_DATE_FORMAT'),
                Response::HTTP_BAD_REQUEST
            );
        }

        $serviceId = decryption($serviceId);
        $dates = $this->availabilityService->getAvailableDates($serviceId, $startDate, $endDate);

        return $this->sendResponse(
            true,
            AvailabilityResource::collection($dates),
            __('response.available_dates_retrieved_successfully')
        );
    }
}
