<?php

namespace App\Models;

use App\Enums\Booking\BookingStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'start_time' => 'string',
            'end_time' => 'string',
            'cancelled_at' => 'datetime',
        ];
    }

    /**
     * Get the service for this booking.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the user who created the booking.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the booking.
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', BookingStatusEnum::PENDING);
    }

    /**
     * Scope a query to only include confirmed bookings.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', BookingStatusEnum::CONFIRMED);
    }

    /**
     * Scope a query to only include cancelled bookings.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', BookingStatusEnum::CANCELLED);
    }

    /**
     * Scope a query to only include completed bookings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', BookingStatusEnum::COMPLETED);
    }

    /**
     * Scope a query to filter by date.
     */
    public function scopeForDate($query, string $date)
    {
        return $query->whereDate('booking_date', $date);
    }

    /**
     * Scope a query to only include upcoming bookings.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date', '>=', now()->toDateString())
            ->whereNotIn('status', [BookingStatusEnum::CANCELLED, BookingStatusEnum::COMPLETED]);
    }

    /**
     * Scope a query to only include past bookings.
     */
    public function scopePast($query)
    {
        return $query->where('booking_date', '<', now()->toDateString());
    }

    /**
     * Check if booking is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->status === BookingStatusEnum::CANCELLED;
    }

    /**
     * Check if booking is confirmed.
     */
    public function isConfirmed(): bool
    {
        return $this->status === BookingStatusEnum::CONFIRMED;
    }

    /**
     * Check if booking is pending.
     */
    public function isPending(): bool
    {
        return $this->status === BookingStatusEnum::PENDING;
    }
}
