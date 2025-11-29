<?php

namespace App\Http\Controllers\Api\V1\WorkingHour;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\WorkingHour\StoreWorkingHourRequest;
use App\Http\Requests\Api\WorkingHour\UpdateWorkingHourRequest;
use App\Http\Resources\WorkingHour\WorkingHourCollection;
use App\Http\Resources\WorkingHour\WorkingHourResource;
use App\Repositories\Interfaces\WorkingHourRepositoryInterface;
use App\Services\WorkingHourService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkingHourController extends ApiController
{
    /**
     * WorkingHourController constructor
     */
    public function __construct(
        protected WorkingHourRepositoryInterface $workingHour,
        protected WorkingHourService $workingHourService
    ) {}

    /**
     * Get all working hours
     *
     * @group Working Hour Management
     *
     * @authenticated
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) ($request->per_page ?? config('constant.DEFAULT_PER_PAGE'));
        $workingHours = $this->workingHour->getModel()->paginate($perPage);

        return $this->sendResponse(
            true,
            new WorkingHourCollection($workingHours),
            __('response.working_hours_retrieved_successfully')
        );
    }

    /**
     * Get working hours grouped by day
     *
     * @group Working Hour Management
     *
     * @authenticated
     */
    public function getGroupedByDay(): JsonResponse
    {
        $workingHours = $this->workingHourService->getWorkingHoursGroupedByDay();

        return $this->sendResponse(
            true,
            $workingHours,
            __('response.working_hours_retrieved_successfully')
        );
    }

    /**
     * Get working hour by ID
     *
     * @group Working Hour Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted working hour ID
     */
    public function show(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $workingHour = $this->workingHour->find($id);

        if (! $workingHour) {
            return $this->sendResponse(
                false,
                null,
                __('response.working_hour_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->sendResponse(
            true,
            new WorkingHourResource($workingHour),
            __('response.working_hour_retrieved_successfully')
        );
    }

    /**
     * Create a new working hour
     *
     * @group Working Hour Management
     *
     * @authenticated
     */
    public function store(StoreWorkingHourRequest $request): JsonResponse
    {
        $data = $request->validated();
        $workingHour = $this->workingHour->create($data);

        return $this->sendResponse(
            true,
            new WorkingHourResource($workingHour),
            __('response.working_hour_created_successfully'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update an existing working hour
     *
     * @group Working Hour Management
     *
     * @authenticated
     */
    public function update(UpdateWorkingHourRequest $request): JsonResponse
    {
        $workingHour = $this->workingHour->find($request->id);

        if (! $workingHour) {
            return $this->sendResponse(
                false,
                null,
                __('response.working_hour_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->workingHour->update($request->id, $request->except('id'));

        return $this->sendResponse(
            true,
            new WorkingHourResource($workingHour->fresh()),
            __('response.working_hour_updated_successfully')
        );
    }

    /**
     * Delete a working hour
     *
     * @group Working Hour Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted working hour ID
     */
    public function destroy(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $workingHour = $this->workingHour->find($id);

        if (! $workingHour) {
            return $this->sendResponse(
                false,
                null,
                __('response.working_hour_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->workingHour->delete($id);

        return $this->sendResponse(
            true,
            null,
            __('response.working_hour_deleted_successfully')
        );
    }

    /**
     * Toggle working hour active status
     *
     * @group Working Hour Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted working hour ID
     */
    public function toggleStatus(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $workingHour = $this->workingHour->find($id);

        if (! $workingHour) {
            return $this->sendResponse(
                false,
                null,
                __('response.working_hour_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->workingHourService->toggleWorkingHourStatus($id, $workingHour);

        return $this->sendResponse(
            true,
            new WorkingHourResource($workingHour->fresh()),
            __('response.working_hour_status_updated_successfully')
        );
    }
}
