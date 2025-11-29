<?php

namespace App\Jobs;

use App\Models\Booking;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendBookingConfirmationEmail implements ShouldQueue
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

            $emailData = [
                'client_name' => $this->booking->client_name,
                'service_name' => $this->booking->service->name,
                'booking_date' => $this->booking->booking_date->format(config('constant.DEFAULT_DATE_FORMAT')),
                'start_time' => $this->booking->start_time,
                'end_time' => $this->booking->end_time,
                'client_phone' => $this->booking->client_phone,
                'notes' => $this->booking->notes,
            ];

            // TODO: Replace with actual Mailable class when email templates are created
            // Mail::to($this->booking->client_email)->send(new BookingConfirmation($this->booking));

            Log::info(__('response.booking_confirmation_email_sent'), [
                'booking_id' => $this->booking->id,
                'client_email' => $this->booking->client_email,
                'client_name' => $this->booking->client_name,
                'data' => $emailData,
            ]);
        } catch (\Exception $e) {
            Log::error(__('response.booking_confirmation_email_failed'), [
                'booking_id' => $this->booking->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
