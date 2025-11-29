<?php

use App\Enums\Booking\BookingStatusEnum;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('booking belongs to a service', function () {
    $service = Service::factory()->create();
    $booking = Booking::factory()->create(['service_id' => $service->id]);

    expect($booking->service)->toBeInstanceOf(Service::class);
    expect($booking->service->id)->toBe($service->id);
});

test('booking has creator relationship', function () {
    $user = User::factory()->create();
    $booking = Booking::factory()->create(['created_by' => $user->id]);

    expect($booking->creator)->toBeInstanceOf(User::class);
    expect($booking->creator->id)->toBe($user->id);
});

test('pending scope filters pending bookings', function () {
    Booking::factory()->pending()->count(3)->create();
    Booking::factory()->confirmed()->count(2)->create();

    $pendingBookings = Booking::pending()->get();

    expect($pendingBookings)->toHaveCount(3);
    foreach ($pendingBookings as $booking) {
        expect($booking->status)->toBe(BookingStatusEnum::PENDING);
    }
});

test('confirmed scope filters confirmed bookings', function () {
    Booking::factory()->confirmed()->count(3)->create();
    Booking::factory()->pending()->count(2)->create();

    $confirmedBookings = Booking::confirmed()->get();

    expect($confirmedBookings)->toHaveCount(3);
    foreach ($confirmedBookings as $booking) {
        expect($booking->status)->toBe(BookingStatusEnum::CONFIRMED);
    }
});

test('cancelled scope filters cancelled bookings', function () {
    Booking::factory()->cancelled()->count(3)->create();
    Booking::factory()->confirmed()->count(2)->create();

    $cancelledBookings = Booking::cancelled()->get();

    expect($cancelledBookings)->toHaveCount(3);
    foreach ($cancelledBookings as $booking) {
        expect($booking->status)->toBe(BookingStatusEnum::CANCELLED);
    }
});

test('completed scope filters completed bookings', function () {
    Booking::factory()->completed()->count(3)->create();
    Booking::factory()->confirmed()->count(2)->create();

    $completedBookings = Booking::completed()->get();

    expect($completedBookings)->toHaveCount(3);
    foreach ($completedBookings as $booking) {
        expect($booking->status)->toBe(BookingStatusEnum::COMPLETED);
    }
});

test('for date scope filters bookings by date', function () {
    $targetDate = Carbon::tomorrow();

    Booking::factory()->count(3)->create([
        'booking_date' => $targetDate->toDateString(),
    ]);

    Booking::factory()->count(2)->create([
        'booking_date' => Carbon::now()->addDays(2)->toDateString(),
    ]);

    $bookings = Booking::forDate($targetDate->toDateString())->get();

    expect($bookings)->toHaveCount(3);
});

test('upcoming scope filters future bookings', function () {
    // Create past bookings
    Booking::factory()->count(2)->create([
        'booking_date' => Carbon::yesterday()->toDateString(),
    ]);

    // Create future bookings
    Booking::factory()->count(3)->create([
        'booking_date' => Carbon::tomorrow()->toDateString(),
        'status' => BookingStatusEnum::CONFIRMED,
    ]);

    // Create cancelled future booking (should not be included)
    Booking::factory()->cancelled()->create([
        'booking_date' => Carbon::tomorrow()->toDateString(),
    ]);

    $upcomingBookings = Booking::upcoming()->get();

    expect($upcomingBookings)->toHaveCount(3);
});

test('past scope filters past bookings', function () {
    Booking::factory()->count(3)->create([
        'booking_date' => Carbon::yesterday()->toDateString(),
    ]);

    Booking::factory()->count(2)->create([
        'booking_date' => Carbon::tomorrow()->toDateString(),
    ]);

    $pastBookings = Booking::past()->get();

    expect($pastBookings)->toHaveCount(3);
});

test('is cancelled method returns correct boolean', function () {
    $cancelledBooking = Booking::factory()->cancelled()->create();
    $confirmedBooking = Booking::factory()->confirmed()->create();

    expect($cancelledBooking->isCancelled())->toBeTrue();
    expect($confirmedBooking->isCancelled())->toBeFalse();
});

test('is confirmed method returns correct boolean', function () {
    $confirmedBooking = Booking::factory()->confirmed()->create();
    $pendingBooking = Booking::factory()->pending()->create();

    expect($confirmedBooking->isConfirmed())->toBeTrue();
    expect($pendingBooking->isConfirmed())->toBeFalse();
});

test('is pending method returns correct boolean', function () {
    $pendingBooking = Booking::factory()->pending()->create();
    $confirmedBooking = Booking::factory()->confirmed()->create();

    expect($pendingBooking->isPending())->toBeTrue();
    expect($confirmedBooking->isPending())->toBeFalse();
});

test('booking date is cast to carbon date', function () {
    $booking = Booking::factory()->create([
        'booking_date' => '2024-12-25',
    ]);

    expect($booking->booking_date)->toBeInstanceOf(Carbon::class);
});

test('cancelled at is cast to carbon datetime', function () {
    $booking = Booking::factory()->cancelled()->create();

    expect($booking->cancelled_at)->toBeInstanceOf(Carbon::class);
});
