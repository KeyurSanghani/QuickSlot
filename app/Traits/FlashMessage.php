<?php

namespace App\Traits;

trait FlashMessage
{
    /**
     * Flash a success message to the session
     */
    protected function flashSuccess(string $message): void
    {
        session()->flash('success', $message);
    }

    /**
     * Flash an error message to the session
     */
    protected function flashError(string $message): void
    {
        session()->flash('error', $message);
    }

    /**
     * Flash a warning message to the session
     */
    protected function flashWarning(string $message): void
    {
        session()->flash('warning', $message);
    }

    /**
     * Flash an info message to the session
     */
    protected function flashInfo(string $message): void
    {
        session()->flash('info', $message);
    }
}
