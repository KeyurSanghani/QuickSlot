<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule booking reminder emails to be sent 24 hours before the appointment
// TODO: Create the bookings:send-reminders command first
// Schedule::command('bookings:send-reminders --hours=24')
//     ->hourly()
//     ->description('Send reminder emails for bookings scheduled in 24 hours');
