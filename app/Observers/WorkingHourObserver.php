<?php

namespace App\Observers;

use App\Models\WorkingHour;

class WorkingHourObserver
{
    protected $currentUserId;

    public function __construct()
    {
        $this->currentUserId = auth()->id() ?? null;
    }

    /**
     * Handle the WorkingHour "creating" event.
     */
    public function creating(WorkingHour $workingHour): void
    {
        $workingHour->created_by = $this->currentUserId;
        $workingHour->updated_by = $this->currentUserId;
    }

    /**
     * Handle the WorkingHour "updating" event.
     */
    public function updating(WorkingHour $workingHour): void
    {
        $workingHour->updated_by = $this->currentUserId;
    }

    /**
     * Handle the WorkingHour "deleting" event.
     */
    public function deleting(WorkingHour $workingHour): void
    {
        $workingHour->updated_by = $this->currentUserId;
        $workingHour->saveQuietly();
    }

    /**
     * Handle the WorkingHour "restoring" event.
     */
    public function restoring(WorkingHour $workingHour): void
    {
        $workingHour->updated_by = $this->currentUserId;
    }
}
