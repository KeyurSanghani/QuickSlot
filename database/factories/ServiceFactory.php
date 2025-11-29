<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $services = [
            ['name' => 'Haircut', 'duration' => 30, 'price' => 50],
            ['name' => 'Hair Coloring', 'duration' => 90, 'price' => 120],
            ['name' => 'Massage', 'duration' => 60, 'price' => 80],
            ['name' => 'Manicure', 'duration' => 45, 'price' => 35],
            ['name' => 'Pedicure', 'duration' => 60, 'price' => 45],
            ['name' => 'Facial Treatment', 'duration' => 75, 'price' => 95],
        ];

        $service = fake()->randomElement($services);

        return [
            'name' => $service['name'],
            'description' => fake()->paragraph(),
            'duration' => $service['duration'],
            'price' => $service['price'],
            'is_active' => fake()->boolean(90), // 90% active
        ];
    }

    /**
     * Indicate that the service is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the service is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
