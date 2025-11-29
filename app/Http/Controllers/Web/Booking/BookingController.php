<?php

namespace App\Http\Controllers\Web\Booking;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    /**
     * Display the booking calendar page
     */
    public function index(): Response
    {
        return Inertia::render('Booking/Index', [
            'title' => __('message.booking_calendar'),
        ]);
    }

    /**
     * Display the admin booking management page
     */
    public function manage(): Response
    {
        return Inertia::render('Booking/Manage', [
            'title' => __('message.manage_bookings'),
        ]);
    }
}
