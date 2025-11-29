<?php

namespace App\Observers;

use App\Models\Service;

class ServiceObserver
{
    protected $currentUserId;

    public function __construct()
    {
        $this->currentUserId = auth()->id() ?? null;
    }

    /**
     * Handle the Service "creating" event.
     */
    public function creating(Service $service): void
    {
        $service->created_by = $this->currentUserId;
        $service->updated_by = $this->currentUserId;
    }

    /**
     * Handle the Service "updating" event.
     */
    public function updating(Service $service): void
    {
        $service->updated_by = $this->currentUserId;
    }

    /**
     * Handle the Service "deleting" event.
     */
    public function deleting(Service $service): void
    {
        $service->updated_by = $this->currentUserId;
        $service->saveQuietly();
    }

    /**
     * Handle the Service "restoring" event.
     */
    public function restoring(Service $service): void
    {
        $service->updated_by = $this->currentUserId;
    }
}
