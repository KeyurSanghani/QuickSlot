<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active services
        $services = Service::active()->get();

        if ($services->isEmpty()) {
            $this->command->warn('No active services found. Please run ServiceSeeder first.');

            return;
        }

        // Create some sample bookings
        foreach ($services->take(3) as $service) {
            // Create a pending booking for tomorrow
            Booking::create([
                'service_id' => $service->id,
                'client_name' => 'John Doe',
                'client_email' => 'john.doe@example.com',
                'client_phone' => '+1234567890',
                'booking_date' => now()->addDay()->format('Y-m-d'),
                'start_time' => '10:00:00',
                'end_time' => now()->parse('10:00:00')->addMinutes($service->duration)->format('H:i:s'),
                'status' => 'pending',
                'notes' => 'First time customer',
            ]);

            // Create a confirmed booking for next week
            Booking::create([
                'service_id' => $service->id,
                'client_name' => 'Jane Smith',
                'client_email' => 'jane.smith@example.com',
                'client_phone' => '+1234567891',
                'booking_date' => now()->addWeek()->format('Y-m-d'),
                'start_time' => '14:00:00',
                'end_time' => now()->parse('14:00:00')->addMinutes($service->duration)->format('H:i:s'),
                'status' => 'confirmed',
                'notes' => 'Regular customer',
            ]);
        }

        // Create some additional random bookings
        Booking::factory()->count(10)->create();
    }
}
