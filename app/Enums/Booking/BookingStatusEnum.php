<?php

declare(strict_types=1);

namespace App\Enums\Booking;

use App\Enums\Enum;

class BookingStatusEnum extends Enum
{
    public const PENDING = 'pending';

    public const CONFIRMED = 'confirmed';

    public const CANCELLED = 'cancelled';

    public const COMPLETED = 'completed';

    public const NO_SHOW = 'no_show';
}
