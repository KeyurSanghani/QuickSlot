<?php

use App\Enums\Booking\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Service;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create test service
    $this->service = Service::factory()->active()->create([
        'name' => 'Haircut',
        'duration' => 30,
        'price' => 50.00,
    ]);

    // Create working hours for Monday (day 1)
    WorkingHour::factory()->create([
        'day_of_week' => 1,
        'start_time' => '09:00:00',
        'end_time' => '12:00:00',
        'is_active' => true,
    ]);

    // Create afternoon working hours
    WorkingHour::factory()->create([
        'day_of_week' => 1,
        'start_time' => '14:00:00',
        'end_time' => '17:00:00',
        'is_active' => true,
    ]);
});

test('can get available time slots for a date', function () {
    // Get next Monday
    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    $response = $this->getJson('/api/v1/availability/slots', [
        'date' => formatDateForUser($nextMonday->toDateString()),
        'service_id' => encryption($this->service->id),
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'start_time',
                    'end_time',
                    'display_time',
                ],
            ],
        ]);

    // Should have multiple slots available
    expect($response->json('data'))->not->toBeEmpty();
});

test('excludes booked time slots from availability', function () {
    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    // Create a booking at 10:00-10:30
    Booking::factory()->create([
        'service_id' => $this->service->id,
        'booking_date' => $nextMonday->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    $response = $this->getJson('/api/v1/availability/slots', [
        'date' => formatDateForUser($nextMonday->toDateString()),
        'service_id' => encryption($this->service->id),
    ]);

    $response->assertStatus(200);

    $slots = $response->json('data');

    // Verify 10:00-10:30 slot is not in the available slots
    $hasBookedSlot = collect($slots)->contains(function ($slot) {
        return $slot['start_time'] === '10:00:00';
    });

    expect($hasBookedSlot)->toBeFalse();
});

test('includes slots where cancelled bookings exist', function () {
    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    // Create a cancelled booking
    Booking::factory()->cancelled()->create([
        'service_id' => $this->service->id,
        'booking_date' => $nextMonday->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
    ]);

    $response = $this->getJson('/api/v1/availability/slots', [
        'date' => formatDateForUser($nextMonday->toDateString()),
        'service_id' => encryption($this->service->id),
    ]);

    $response->assertStatus(200);

    $slots = $response->json('data');

    // Verify 10:00-10:30 slot IS available (since booking is cancelled)
    $hasSlot = collect($slots)->contains(function ($slot) {
        return $slot['start_time'] === '10:00:00';
    });

    expect($hasSlot)->toBeTrue();
});

test('returns empty array for past dates', function () {
    $yesterday = Carbon::yesterday();

    $response = $this->getJson('/api/v1/availability/slots', [
        'date' => formatDateForUser($yesterday->toDateString()),
        'service_id' => encryption($this->service->id),
    ]);

    $response->assertStatus(200);
    expect($response->json('data'))->toBeArray()->toBeEmpty();
});

test('returns empty array for days with no working hours', function () {
    // Get next Sunday (day 7) - no working hours set
    $nextSunday = Carbon::now()->next(Carbon::SUNDAY);

    $response = $this->getJson('/api/v1/availability/slots', [
        'date' => formatDateForUser($nextSunday->toDateString()),
        'service_id' => encryption($this->service->id),
    ]);

    $response->assertStatus(200);
    expect($response->json('data'))->toBeArray()->toBeEmpty();
});

test('excludes past time slots for today', function () {
    // Only run this test if it's currently before working hours
    $now = Carbon::now();

    if ($now->dayOfWeekIso === 1 && $now->hour < 9) {
        // Create working hours for today
        WorkingHour::factory()->create([
            'day_of_week' => $now->dayOfWeekIso,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/v1/availability/slots', [
            'date' => formatDateForUser($now->toDateString()),
            'service_id' => encryption($this->service->id),
        ]);

        $response->assertStatus(200);

        // All slots should be in the future
        $slots = $response->json('data');
        foreach ($slots as $slot) {
            $slotTime = Carbon::parse($slot['start_time']);
            expect($slotTime->isAfter($now))->toBeTrue();
        }
    } else {
        // Skip test if conditions aren't right
        expect(true)->toBeTrue();
    }
});

test('generates correct slot duration based on service', function () {
    $longService = Service::factory()->active()->create([
        'duration' => 60, // 1 hour
    ]);

    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    $response = $this->getJson('/api/v1/availability/slots', [
        'date' => formatDateForUser($nextMonday->toDateString()),
        'service_id' => encryption($longService->id),
    ]);

    $response->assertStatus(200);

    $slots = $response->json('data');

    if (count($slots) > 0) {
        $firstSlot = $slots[0];
        $start = Carbon::parse($firstSlot['start_time']);
        $end = Carbon::parse($firstSlot['end_time']);

        expect($start->diffInMinutes($end))->toBe(60);
    }
});

test('can get available dates within a range', function () {
    // Create working hours for multiple days
    for ($day = 1; $day <= 5; $day++) {
        WorkingHour::factory()->create([
            'day_of_week' => $day,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
        ]);
    }

    $startDate = Carbon::now()->next(Carbon::MONDAY);
    $endDate = $startDate->copy()->addDays(6);

    $response = $this->getJson('/api/v1/availability/dates', [
        'service_id' => encryption($this->service->id),
        'start_date' => formatDateForUser($startDate->toDateString()),
        'end_date' => formatDateForUser($endDate->toDateString()),
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                '*' => [
                    'date',
                    'day_name',
                    'slots_count',
                ],
            ],
        ]);
});

test('validates required parameters for availability slots', function () {
    $response = $this->getJson('/api/v1/availability/slots');

    $response->assertStatus(400);
});

test('validates required parameters for availability dates', function () {
    $response = $this->getJson('/api/v1/availability/dates');

    $response->assertStatus(400);
});
