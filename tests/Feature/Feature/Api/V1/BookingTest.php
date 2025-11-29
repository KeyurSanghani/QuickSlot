<?php

use App\Enums\Booking\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\WorkingHour;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create a test user for authenticated routes
    $this->user = User::factory()->create();

    // Create test services
    $this->service = Service::factory()->active()->create([
        'name' => 'Test Service',
        'duration' => 60,
        'price' => 100.00,
    ]);

    // Create working hours for Monday-Friday
    for ($day = 1; $day <= 5; $day++) {
        WorkingHour::factory()->create([
            'day_of_week' => $day,
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_active' => true,
        ]);
    }
});

test('can create a booking with valid data', function () {
    $tomorrow = Carbon::tomorrow();

    $response = $this->postJson('/api/v1/bookings', [
        'service_id' => encryption($this->service->id),
        'client_name' => 'John Doe',
        'client_email' => 'john@example.com',
        'client_phone' => '1234567890',
        'booking_date' => formatDateForUser($tomorrow->toDateString()),
        'start_time' => '10:00',
        'notes' => 'Test booking',
    ]);

    $response->assertStatus(201)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'id',
                'service',
                'client_name',
                'client_email',
                'booking_date',
                'start_time',
                'end_time',
                'status',
            ],
        ]);

    $this->assertDatabaseHas('bookings', [
        'client_email' => 'john@example.com',
        'client_name' => 'John Doe',
    ]);
});

test('cannot create booking with past date', function () {
    $yesterday = Carbon::yesterday();

    $response = $this->postJson('/api/v1/bookings', [
        'service_id' => encryption($this->service->id),
        'client_name' => 'John Doe',
        'client_email' => 'john@example.com',
        'client_phone' => '1234567890',
        'booking_date' => formatDateForUser($yesterday->toDateString()),
        'start_time' => '10:00',
    ]);

    $response->assertStatus(422);
});

test('cannot create booking for inactive service', function () {
    $inactiveService = Service::factory()->inactive()->create();
    $tomorrow = Carbon::tomorrow();

    $response = $this->postJson('/api/v1/bookings', [
        'service_id' => encryption($inactiveService->id),
        'client_name' => 'John Doe',
        'client_email' => 'john@example.com',
        'client_phone' => '1234567890',
        'booking_date' => formatDateForUser($tomorrow->toDateString()),
        'start_time' => '10:00',
    ]);

    $response->assertStatus(422);
});

test('cannot double book the same time slot', function () {
    $tomorrow = Carbon::tomorrow();

    // Create first booking
    Booking::factory()->create([
        'service_id' => $this->service->id,
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    // Try to book the same slot
    $response = $this->postJson('/api/v1/bookings', [
        'service_id' => encryption($this->service->id),
        'client_name' => 'Jane Doe',
        'client_email' => 'jane@example.com',
        'client_phone' => '0987654321',
        'booking_date' => formatDateForUser($tomorrow->toDateString()),
        'start_time' => '10:00',
    ]);

    $response->assertStatus(409); // Conflict
});

test('can book adjacent time slots without conflict', function () {
    $tomorrow = Carbon::tomorrow();

    // Create first booking 10:00-11:00
    Booking::factory()->create([
        'service_id' => $this->service->id,
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    // Book adjacent slot 11:00-12:00
    $response = $this->postJson('/api/v1/bookings', [
        'service_id' => encryption($this->service->id),
        'client_name' => 'Jane Doe',
        'client_email' => 'jane@example.com',
        'client_phone' => '0987654321',
        'booking_date' => formatDateForUser($tomorrow->toDateString()),
        'start_time' => '11:00',
    ]);

    $response->assertStatus(201);
});

test('cancelled bookings do not block time slots', function () {
    $tomorrow = Carbon::tomorrow();

    // Create cancelled booking
    Booking::factory()->cancelled()->create([
        'service_id' => $this->service->id,
        'booking_date' => $tomorrow->toDateString(),
        'start_time' => '10:00:00',
        'end_time' => '11:00:00',
    ]);

    // Book the same slot (should succeed)
    $response = $this->postJson('/api/v1/bookings', [
        'service_id' => encryption($this->service->id),
        'client_name' => 'Jane Doe',
        'client_email' => 'jane@example.com',
        'client_phone' => '0987654321',
        'booking_date' => formatDateForUser($tomorrow->toDateString()),
        'start_time' => '10:00',
    ]);

    $response->assertStatus(201);
});

test('authenticated user can view all bookings', function () {
    Booking::factory()->count(5)->create();

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/bookings');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'data' => [
                'data' => [
                    '*' => ['id', 'client_name', 'booking_date', 'status'],
                ],
            ],
        ]);
});

test('authenticated user can view single booking', function () {
    $booking = Booking::factory()->create([
        'client_name' => 'Test Client',
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/bookings/'.encryption($booking->id));

    $response->assertStatus(200)
        ->assertJsonPath('data.client_name', 'Test Client');
});

test('can cancel a booking', function () {
    $booking = Booking::factory()->confirmed()->create();

    $response = $this->actingAs($this->user)
        ->patchJson('/api/v1/bookings/'.encryption($booking->id).'/cancel', [
            'cancellation_reason' => 'Client requested',
        ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => BookingStatusEnum::CANCELLED,
    ]);
});

test('can confirm a booking', function () {
    $booking = Booking::factory()->pending()->create();

    $response = $this->actingAs($this->user)
        ->patchJson('/api/v1/bookings/'.encryption($booking->id).'/confirm');

    $response->assertStatus(200);

    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => BookingStatusEnum::CONFIRMED,
    ]);
});

test('can complete a booking', function () {
    $booking = Booking::factory()->confirmed()->create();

    $response = $this->actingAs($this->user)
        ->patchJson('/api/v1/bookings/'.encryption($booking->id).'/complete');

    $response->assertStatus(200);

    $this->assertDatabaseHas('bookings', [
        'id' => $booking->id,
        'status' => BookingStatusEnum::COMPLETED,
    ]);
});

test('can get upcoming bookings', function () {
    // Create past booking
    Booking::factory()->create([
        'booking_date' => Carbon::yesterday()->toDateString(),
    ]);

    // Create future bookings
    Booking::factory()->count(3)->create([
        'booking_date' => Carbon::tomorrow()->toDateString(),
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/bookings/upcoming');

    $response->assertStatus(200);
    expect($response->json('data'))->toHaveCount(3);
});

test('can get bookings by date', function () {
    $targetDate = Carbon::tomorrow();

    // Create bookings on target date
    Booking::factory()->count(3)->create([
        'booking_date' => $targetDate->toDateString(),
    ]);

    // Create booking on different date
    Booking::factory()->create([
        'booking_date' => Carbon::now()->addDays(2)->toDateString(),
    ]);

    $response = $this->actingAs($this->user)
        ->getJson('/api/v1/bookings/by-date?date='.formatDateForUser($targetDate->toDateString()));

    $response->assertStatus(200);
    expect($response->json('data'))->toHaveCount(3);
});

test('validates required fields for booking creation', function () {
    $response = $this->postJson('/api/v1/bookings', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors([
            'service_id',
            'client_name',
            'client_email',
            'client_phone',
            'booking_date',
            'start_time',
        ]);
});

test('validates email format for booking creation', function () {
    $tomorrow = Carbon::tomorrow();

    $response = $this->postJson('/api/v1/bookings', [
        'service_id' => encryption($this->service->id),
        'client_name' => 'John Doe',
        'client_email' => 'invalid-email',
        'client_phone' => '1234567890',
        'booking_date' => formatDateForUser($tomorrow->toDateString()),
        'start_time' => '10:00',
    ]);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['client_email']);
});
