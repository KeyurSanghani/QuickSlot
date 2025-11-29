<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkingHour>
 */
class WorkingHourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dayOfWeek = fake()->numberBetween(0, 6);

        return [
            'day_of_week' => $dayOfWeek,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
        ];
    }

    /**
     * Indicate morning shift (9 AM - 12 PM).
     */
    public function morningShift(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => '09:00:00',
            'end_time' => '12:00:00',
        ]);
    }

    /**
     * Indicate afternoon shift (2 PM - 6 PM).
     */
    public function afternoonShift(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => '14:00:00',
            'end_time' => '18:00:00',
        ]);
    }

    /**
     * Indicate weekend hours (10 AM - 2 PM).
     */
    public function weekendHours(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => '10:00:00',
            'end_time' => '14:00:00',
        ]);
    }
}
