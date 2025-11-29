<?php

namespace Database\Seeders;

use App\Models\WorkingHour;
use Illuminate\Database\Seeder;

class WorkingHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workingHours = [
            // Monday - Friday: 9 AM - 12 PM (Morning)
            ['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'is_active' => true],
            ['day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'is_active' => true],
            ['day_of_week' => 3, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'is_active' => true],
            ['day_of_week' => 4, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'is_active' => true],
            ['day_of_week' => 5, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'is_active' => true],
            ['day_of_week' => 6, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'is_active' => true],
            ['day_of_week' => 7, 'start_time' => '09:00:00', 'end_time' => '12:00:00', 'is_active' => true],

            // Monday - Friday: 2 PM - 6 PM (Afternoon) - Lunch break from 12-2 PM
            ['day_of_week' => 1, 'start_time' => '14:00:00', 'end_time' => '18:00:00', 'is_active' => true],
            ['day_of_week' => 2, 'start_time' => '14:00:00', 'end_time' => '18:00:00', 'is_active' => true],
            ['day_of_week' => 3, 'start_time' => '14:00:00', 'end_time' => '18:00:00', 'is_active' => true],
            ['day_of_week' => 4, 'start_time' => '14:00:00', 'end_time' => '18:00:00', 'is_active' => true],
            ['day_of_week' => 5, 'start_time' => '14:00:00', 'end_time' => '18:00:00', 'is_active' => true],
            ['day_of_week' => 6, 'start_time' => '14:00:00', 'end_time' => '18:00:00', 'is_active' => true],
            ['day_of_week' => 7, 'start_time' => '14:00:00', 'end_time' => '18:00:00', 'is_active' => true],
        ];

        foreach ($workingHours as $workingHour) {
            WorkingHour::create($workingHour);
        }
    }
}
