<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBookingReminderEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     */
    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Booking $booking
    ) {
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Load the service relationship
            $this->booking->load('service');

            // Only send reminder for confirmed bookings
            if (! $this->booking->isConfirmed()) {
                Log::info(__('response.booking_reminder_skipped'), [
                    'booking_id' => $this->booking->id,
                    'status' => $this->booking->status,
                ]);

                return;
            }

            // Send the reminder email using the Mailable class
            Mail::to($this->booking->client_email)
                ->send(new \App\Mail\Booking\BookingReminder($this->booking));

            Log::info(__('response.booking_reminder_email_sent'), [
                'booking_id' => $this->booking->id,
                'client_email' => $this->booking->client_email,
                'client_name' => $this->booking->client_name,
                'service_name' => $this->booking->service->name,
                'booking_date' => $this->booking->booking_date->format(config('constant.DEFAULT_DATE_FORMAT')),
            ]);
        } catch (\Exception $e) {
            Log::error(__('response.booking_reminder_email_failed'), [
                'booking_id' => $this->booking->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}
