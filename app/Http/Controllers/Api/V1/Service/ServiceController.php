<?php

namespace App\Http\Controllers\Api\V1\Service;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\Service\StoreServiceRequest;
use App\Http\Requests\Api\Service\UpdateServiceRequest;
use App\Http\Resources\Service\ServiceCollection;
use App\Http\Resources\Service\ServiceResource;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends ApiController
{
    /**
     * ServiceController constructor
     */
    public function __construct(
        protected ServiceRepositoryInterface $service,
        protected ServiceService $serviceService
    ) {}

    /**
     * Get all services
     *
     * @group Service Management
     *
     * @authenticated
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = (int) ($request->per_page ?? config('constant.DEFAULT_PER_PAGE'));
        $services = $this->service->getModel()->paginate($perPage);

        return $this->sendResponse(
            true,
            new ServiceCollection($services),
            __('response.services_retrieved_successfully')
        );
    }

    /**
     * Get all active services
     *
     * @group Service Management
     */
    public function getActiveServices(): JsonResponse
    {
        $services = $this->service->getAllActive(['id', 'name', 'description', 'duration', 'price']);

        return $this->sendResponse(
            true,
            ServiceResource::collection($services),
            __('response.active_services_retrieved_successfully')
        );
    }

    /**
     * Get service by ID
     *
     * @group Service Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted service ID
     */
    public function show(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $service = $this->service->find($id, true);

        if (! $service) {
            return $this->sendResponse(
                false,
                null,
                __('response.service_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        return $this->sendResponse(
            true,
            new ServiceResource($service),
            __('response.service_retrieved_successfully')
        );
    }

    /**
     * Create a new service
     *
     * @group Service Management
     *
     * @authenticated
     */
    public function store(StoreServiceRequest $request): JsonResponse
    {
        $data = $request->validated();
        $service = $this->service->create($data);

        return $this->sendResponse(
            true,
            new ServiceResource($service),
            __('response.service_created_successfully'),
            Response::HTTP_CREATED
        );
    }

    /**
     * Update an existing service
     *
     * @group Service Management
     *
     * @authenticated
     */
    public function update(UpdateServiceRequest $request): JsonResponse
    {
        $service = $this->service->find($request->id);

        if (! $service) {
            return $this->sendResponse(
                false,
                null,
                __('response.service_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->service->update($request->id, $request->except('id'));

        return $this->sendResponse(
            true,
            new ServiceResource($service->fresh()),
            __('response.service_updated_successfully')
        );
    }

    /**
     * Delete a service
     *
     * @group Service Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted service ID
     */
    public function destroy(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $service = $this->service->find($id);

        if (! $service) {
            return $this->sendResponse(
                false,
                null,
                __('response.service_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->service->delete($id);

        return $this->sendResponse(
            true,
            null,
            __('response.service_deleted_successfully')
        );
    }

    /**
     * Toggle service active status
     *
     * @group Service Management
     *
     * @authenticated
     *
     * @urlParam id required The encrypted service ID
     */
    public function toggleStatus(Request $request): JsonResponse
    {
        $id = decryption($request->id);
        $service = $this->service->find($id);

        if (! $service) {
            return $this->sendResponse(
                false,
                null,
                __('response.service_not_found'),
                Response::HTTP_NOT_FOUND
            );
        }

        $this->serviceService->toggleServiceStatus($id, $service);

        return $this->sendResponse(
            true,
            new ServiceResource($service->fresh()),
            __('response.service_status_updated_successfully')
        );
    }
}
