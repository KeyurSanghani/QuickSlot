<?php

namespace App\Console\Commands\Booking;

use App\Jobs\SendBookingReminderEmail;
use App\Models\Booking;
use Illuminate\Console\Command;

class SendBookingReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bookings:send-reminders {--hours=24 : Hours before booking to send reminder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails for upcoming confirmed bookings';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $reminderTime = now()->addHours($hours);

        $this->info("Checking for bookings scheduled for {$reminderTime->format(config('constant.DEFAULT_DATE_TIME_FORMAT'))}...");

        // Get confirmed bookings that are coming up in the specified hours
        $bookings = Booking::confirmed()
            ->whereDate('booking_date', $reminderTime->toDateString())
            ->whereTime('start_time', '>=', $reminderTime->toTimeString())
            ->whereTime('start_time', '<=', $reminderTime->addHour()->toTimeString())
            ->with('service')
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No bookings found for reminder.');

            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($bookings as $booking) {
            // Dispatch the job to send the reminder email
            SendBookingReminderEmail::dispatch($booking);
            $this->info("Dispatched reminder job for booking #{$booking->id} - {$booking->client_name}");
            $count++;
        }

        $this->info("Successfully dispatched {$count} reminder email job(s).");

        return Command::SUCCESS;
    }
}
