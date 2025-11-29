<?php

namespace App\Http\Controllers\Web\Service;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * Display the service management page
     */
    public function index(): Response
    {
        return Inertia::render('Service/Index', [
            'title' => __('message.manage_services'),
        ]);
    }
}
