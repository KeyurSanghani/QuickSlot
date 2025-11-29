<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    protected $currentUserId;

    public function __construct()
    {
        $this->currentUserId = auth()->id() ?? null;
    }

    /**
     * Handle the User "creating" event.
     */
    public function creating(User $user): void
    {
        $user->created_by = $this->currentUserId;
        $user->updated_by = $this->currentUserId;
    }

    /**
     * Handle the User "updating" event.
     */
    public function updating(User $user): void
    {
        $user->updated_by = $this->currentUserId;
    }

    /**
     * Handle the User "deleting" event.
     */
    public function deleting(User $user): void
    {
        $user->updated_by = $this->currentUserId;
        $user->saveQuietly();
    }

    /**
     * Handle the User "restoring" event.
     */
    public function restoring(User $user): void
    {
        $user->updated_by = $this->currentUserId;
    }
}
