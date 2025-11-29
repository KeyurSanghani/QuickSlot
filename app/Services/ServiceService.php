<?php

namespace App\Services;

use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;

class ServiceService
{
    public function __construct(
        protected ServiceRepositoryInterface $serviceRepository
    ) {}

    /**
     * Toggle service active status
     *
     * @param  int  $id
     * @return bool
     */
    public function toggleServiceStatus($id, Service $service)
    {
        return $this->serviceRepository->update($id, [
            'is_active' => ! $service->is_active,
        ]);
    }
}
