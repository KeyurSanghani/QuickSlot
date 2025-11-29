<?php

use App\Enums\Booking\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Service;
use App\Models\WorkingHour;
use App\Services\Booking\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->availabilityService = app(AvailabilityService::class);

    $this->service = Service::factory()->active()->create([
        'duration' => 30,
    ]);

    // Create working hours for Monday (day 1)
    WorkingHour::factory()->create([
        'day_of_week' => 1,
        'start_time' => '09:00:00',
        'end_time' => '12:00:00',
        'is_active' => true,
    ]);
});

test('generates time slots for a date with working hours', function () {
    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $nextMonday->toDateString(),
        $this->service->id
    );

    expect($slots)->toBeArray();
    expect($slots)->not->toBeEmpty();

    // With 3 hours and 30-minute slots, should have 6 slots
    expect(count($slots))->toBeGreaterThan(0);
});

test('returns empty array for date with no working hours', function () {
    $nextSunday = Carbon::now()->next(Carbon::SUNDAY);

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $nextSunday->toDateString(),
        $this->service->id
    );

    expect($slots)->toBeArray()->toBeEmpty();
});

test('returns empty array for past dates', function () {
    $yesterday = Carbon::yesterday();

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $yesterday->toDateString(),
        $this->service->id
    );

    expect($slots)->toBeArray()->toBeEmpty();
});

test('excludes booked time slots', function () {
    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    // Create a booking at 10:00-10:30
    Booking::factory()->create([
        'service_id' => $this->service->id,
        'booking_date' => $nextMonday->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $nextMonday->toDateString(),
        $this->service->id
    );

    // Check that 10:00 slot is not available
    $hasBookedSlot = collect($slots)->contains(fn ($slot) => $slot['start_time'] === '10:00:00');

    expect($hasBookedSlot)->toBeFalse();
});

test('includes cancelled booking time slots', function () {
    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    // Create a cancelled booking
    Booking::factory()->cancelled()->create([
        'service_id' => $this->service->id,
        'booking_date' => $nextMonday->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '10:30:00',
    ]);

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $nextMonday->toDateString(),
        $this->service->id
    );

    // Check that 10:00 slot IS available
    $hasSlot = collect($slots)->contains(fn ($slot) => $slot['start_time'] === '10:00:00');

    expect($hasSlot)->toBeTrue();
});

test('generates slots based on service duration', function () {
    $longService = Service::factory()->active()->create([
        'duration' => 60, // 1 hour
    ]);

    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $nextMonday->toDateString(),
        $longService->id
    );

    // First slot should be 60 minutes long
    if (count($slots) > 0) {
        $firstSlot = $slots[0];
        $start = Carbon::parse($firstSlot['start_time']);
        $end = Carbon::parse($firstSlot['end_time']);

        expect($start->diffInMinutes($end))->toBe(60);
    }
});

test('handles multiple working hour blocks in same day', function () {
    // Add afternoon working hours
    WorkingHour::factory()->create([
        'day_of_week' => 1,
        'start_time' => '14:00:00',
        'end_time' => '17:00:00',
        'is_active' => true,
    ]);

    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $nextMonday->toDateString(),
        $this->service->id
    );

    // Should have slots from both morning and afternoon
    $hasMorningSlot = collect($slots)->contains(fn ($slot) => $slot['start_time'] === '09:00:00');
    $hasAfternoonSlot = collect($slots)->contains(fn ($slot) => $slot['start_time'] === '14:00:00');

    expect($hasMorningSlot)->toBeTrue();
    expect($hasAfternoonSlot)->toBeTrue();
});

test('can check if time slot is available', function () {
    $tomorrow = Carbon::tomorrow();

    $isAvailable = $this->availabilityService->isTimeSlotAvailable(
        $tomorrow->toDateString(),
        '10:00:00',
        '11:00:00'
    );

    expect($isAvailable)->toBeTrue();
});

test('detects unavailable time slot', function () {
    $tomorrow = Carbon::tomorrow();

    // Create a booking
    Booking::factory()->create([
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    $isAvailable = $this->availabilityService->isTimeSlotAvailable(
        $tomorrow->toDateString(),
        '10:00:00',
        '11:00:00'
    );

    expect($isAvailable)->toBeFalse();
});

test('can get available dates within range', function () {
    // Create working hours for weekdays
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

    $dates = $this->availabilityService->getAvailableDates(
        $this->service->id,
        $startDate->toDateString(),
        $endDate->toDateString()
    );

    expect($dates)->toBeArray();
    expect(count($dates))->toBeGreaterThan(0);
});

test('consecutive time slots are available after booking', function () {
    $nextMonday = Carbon::now()->next(Carbon::MONDAY);

    // Book 09:00-09:30 slot
    Booking::factory()->create([
        'service_id' => $this->service->id,
        'booking_date' => $nextMonday->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '09:30:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    $slots = $this->availabilityService->getAvailableTimeSlots(
        $nextMonday->toDateString(),
        $this->service->id
    );

    // The next consecutive slot (09:30-10:00) should be available
    $hasNextSlot = collect($slots)->contains(fn ($slot) => $slot['start_time'] === '09:30:00');
    expect($hasNextSlot)->toBeTrue();

    // The booked slot (09:00-09:30) should NOT be available
    $hasBookedSlot = collect($slots)->contains(fn ($slot) => $slot['start_time'] === '09:00:00');
    expect($hasBookedSlot)->toBeFalse();
});

test('time slot availability detects consecutive slots correctly', function () {
    $tomorrow = Carbon::tomorrow();

    // Book 09:00-09:30
    Booking::factory()->create([
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '09:30:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    // Check if 09:30-10:00 is available (should be true)
    $isAvailable = $this->availabilityService->isTimeSlotAvailable(
        $tomorrow->toDateString(),
        '09:30:00',
        '10:00:00'
    );
    expect($isAvailable)->toBeTrue();

    // Check if 09:00-09:30 is available (should be false - already booked)
    $isBookedSlotAvailable = $this->availabilityService->isTimeSlotAvailable(
        $tomorrow->toDateString(),
        '09:00:00',
        '09:30:00'
    );
    expect($isBookedSlotAvailable)->toBeFalse();

    // Check if 09:15-09:45 is available (should be false - overlaps with existing booking)
    $isOverlappingAvailable = $this->availabilityService->isTimeSlotAvailable(
        $tomorrow->toDateString(),
        '09:15:00',
        '09:45:00'
    );
    expect($isOverlappingAvailable)->toBeFalse();
});
