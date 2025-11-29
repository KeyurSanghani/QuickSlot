<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Use existing services instead of creating new ones
        $service = \App\Models\Service::inRandomOrder()->first() ?? \App\Models\Service::factory()->create();
        $bookingDate = fake()->dateTimeBetween('now', '+30 days');
        $startTime = fake()->randomElement(['09:00:00', '10:00:00', '11:00:00', '14:00:00', '15:00:00', '16:00:00']);

        // Calculate end time based on service duration
        $startDateTime = \Carbon\Carbon::parse($startTime);
        $endDateTime = $startDateTime->copy()->addMinutes($service->duration);

        return [
            'service_id' => $service->id,
            'client_name' => fake()->name(),
            'client_email' => fake()->safeEmail(),
            'client_phone' => fake()->phoneNumber(),
            'booking_date' => $bookingDate->format('Y-m-d'),
            'start_time' => $startTime,
            'end_time' => $endDateTime->format('H:i:s'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the booking is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the booking is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'confirmed',
        ]);
    }

    /**
     * Indicate that the booking is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
            'cancellation_reason' => fake()->sentence(),
            'cancelled_at' => now(),
        ]);
    }

    /**
     * Indicate that the booking is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'booking_date' => fake()->dateTimeBetween('-30 days', '-1 day')->format('Y-m-d'),
        ]);
    }
}
