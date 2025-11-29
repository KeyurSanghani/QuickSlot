<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Haircut',
                'description' => 'Professional haircut service with styling. Includes consultation, wash, cut, and blow dry.',
                'duration' => 30,
                'price' => 50.00,
                'is_active' => true,
            ],
            [
                'name' => 'Hair Coloring',
                'description' => 'Full hair coloring service with premium products. Includes color consultation and treatment.',
                'duration' => 90,
                'price' => 120.00,
                'is_active' => true,
            ],
            [
                'name' => 'Pedicure',
                'description' => 'Comprehensive foot care service with exfoliation, massage, and nail treatment.',
                'duration' => 60,
                'price' => 45.00,
                'is_active' => true,
            ],
            [
                'name' => 'Facial Treatment',
                'description' => 'Rejuvenating facial treatment tailored to your skin type. Includes cleansing, exfoliation, and mask.',
                'duration' => 75,
                'price' => 95.00,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
