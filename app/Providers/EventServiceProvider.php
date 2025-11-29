<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingHour;
use App\Observers\BookingObserver;
use App\Observers\ServiceObserver;
use App\Observers\UserObserver;
use App\Observers\WorkingHourObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Service::observe(ServiceObserver::class);
        WorkingHour::observe(WorkingHourObserver::class);
        Booking::observe(BookingObserver::class);
    }
}
