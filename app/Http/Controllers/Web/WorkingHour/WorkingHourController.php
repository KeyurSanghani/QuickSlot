<?php

namespace App\Http\Controllers\Web\WorkingHour;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class WorkingHourController extends Controller
{
    /**
     * Display the working hours management page
     */
    public function index(): Response
    {
        return Inertia::render('WorkingHour/Index', [
            'title' => __('message.manage_working_hours'),
        ]);
    }
}
