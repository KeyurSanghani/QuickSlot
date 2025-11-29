<?php

use App\Enums\Booking\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Service;
use App\Services\Booking\BookingService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->bookingService = app(BookingService::class);

    $this->service = Service::factory()->active()->create([
        'duration' => 60,
    ]);
});

test('can create a booking successfully', function () {
    $tomorrow = Carbon::tomorrow();

    $data = [
        'service_id' => $this->service->id,
        'client_name' => 'John Doe',
        'client_email' => 'john@example.com',
        'client_phone' => '1234567890',
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
    ];

    $booking = $this->bookingService->createBooking($data);

    expect($booking)->toBeInstanceOf(Booking::class);
    expect($booking->client_email)->toBe('john@example.com');
    expect($booking->status)->toBe(BookingStatusEnum::PENDING);
});

test('returns null when time slot is not available', function () {
    $tomorrow = Carbon::tomorrow();

    // Create existing booking
    Booking::factory()->create([
        'service_id' => $this->service->id,
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    // Try to book the same slot
    $data = [
        'service_id' => $this->service->id,
        'client_name' => 'Jane Doe',
        'client_email' => 'jane@example.com',
        'client_phone' => '0987654321',
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
    ];

    $booking = $this->bookingService->createBooking($data);

    expect($booking)->toBeNull();
});

test('can update booking successfully', function () {
    $booking = Booking::factory()->create([
        'client_name' => 'Original Name',
    ]);

    $updatedBooking = $this->bookingService->updateBooking($booking->id, [
        'client_name' => 'Updated Name',
    ]);

    expect($updatedBooking->client_name)->toBe('Updated Name');
});

test('throws exception when updating to unavailable time slot', function () {
    $tomorrow = Carbon::tomorrow();

    // Create first booking
    $booking1 = Booking::factory()->create([
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
    ]);

    // Create second booking
    $booking2 = Booking::factory()->create([
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '14:00:00',
        'end_time' => '15:00:00',
    ]);

    // Try to update booking2 to conflict with booking1
    expect(fn () => $this->bookingService->updateBooking($booking2->id, [
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
    ]))->toThrow(Exception::class);
});

test('can cancel a booking', function () {
    $booking = Booking::factory()->confirmed()->create();

    $result = $this->bookingService->cancelBooking($booking->id, 'Client requested');

    expect($result)->toBeTrue();

    $booking->refresh();
    expect($booking->status)->toBe(BookingStatusEnum::CANCELLED);
    expect($booking->cancellation_reason)->toBe('Client requested');
    expect($booking->cancelled_at)->not->toBeNull();
});

test('can confirm a booking', function () {
    $booking = Booking::factory()->pending()->create();

    $result = $this->bookingService->confirmBooking($booking->id);

    expect($result)->toBeTrue();

    $booking->refresh();
    expect($booking->status)->toBe(BookingStatusEnum::CONFIRMED);
});

test('can complete a booking', function () {
    $booking = Booking::factory()->confirmed()->create();

    $result = $this->bookingService->completeBooking($booking->id);

    expect($result)->toBeTrue();

    $booking->refresh();
    expect($booking->status)->toBe(BookingStatusEnum::COMPLETED);
});

test('can mark booking as no show', function () {
    $booking = Booking::factory()->confirmed()->create();

    $result = $this->bookingService->markAsNoShow($booking->id);

    expect($result)->toBeTrue();

    $booking->refresh();
    expect($booking->status)->toBe(BookingStatusEnum::NO_SHOW);
});

test('can book consecutive time slots without conflict', function () {
    $tomorrow = Carbon::tomorrow();

    // Create a 30-minute service
    $shortService = Service::factory()->active()->create([
        'duration' => 30,
    ]);

    // Book first slot: 09:00-09:30
    $firstBooking = $this->bookingService->createBooking([
        'service_id' => $shortService->id,
        'client_name' => 'First Client',
        'client_email' => 'first@example.com',
        'client_phone' => '1111111111',
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '09:30:00',
    ]);

    expect($firstBooking)->toBeInstanceOf(Booking::class);

    // Book consecutive slot: 09:30-10:00 (should succeed)
    $secondBooking = $this->bookingService->createBooking([
        'service_id' => $shortService->id,
        'client_name' => 'Second Client',
        'client_email' => 'second@example.com',
        'client_phone' => '2222222222',
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '09:30:00',
        'end_time' => '10:00:00',
    ]);

    expect($secondBooking)->toBeInstanceOf(Booking::class);
    expect($secondBooking->start_time)->toBe('09:30:00');
});

test('detects overlapping time slots correctly', function () {
    $tomorrow = Carbon::tomorrow();

    // Book slot: 09:00-10:00
    Booking::factory()->create([
        'service_id' => $this->service->id,
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    // Try to book overlapping slot: 09:30-10:30 (should fail)
    $overlappingBooking = $this->bookingService->createBooking([
        'service_id' => $this->service->id,
        'client_name' => 'Overlapping Client',
        'client_email' => 'overlap@example.com',
        'client_phone' => '3333333333',
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '09:30:00',
        'end_time' => '10:30:00',
    ]);

    expect($overlappingBooking)->toBeNull();
});
