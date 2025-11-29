<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

trait InertiaResponseHelper
{
    /**
     * Redirect back with success message.
     *
     * @param  string|null  $message
     * @param  array  $data
     */
    public function redirectWithSuccess($message = null, $data = []): RedirectResponse
    {
        $message = $message ?? __('response.default_success_message');

        return redirect()->back()->with([
            'success' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Redirect back with error message.
     *
     * @param  string|null  $message
     * @param  array  $errors
     */
    public function redirectWithError($message = null, $errors = []): RedirectResponse
    {
        $message = $message ?? __('response.default_error_message');

        return redirect()->back()->with([
            'error' => $message,
            'errors' => $errors,
        ]);
    }

    /**
     * Redirect to specific route with success message.
     *
     * @param  string  $route
     * @param  string|null  $message
     * @param  array  $data
     * @param  array  $routeParams
     */
    public function redirectToRouteWithSuccess($route, $message = null, $data = [], $routeParams = []): RedirectResponse
    {
        $message = $message ?? __('response.default_success_message');

        return redirect()->route($route, $routeParams)->with([
            'success' => $message,
            'data' => $data,
        ]);
    }

    /**
     * Redirect to specific route with error message.
     *
     * @param  string  $route
     * @param  string|null  $message
     * @param  array  $errors
     * @param  array  $routeParams
     */
    public function redirectToRouteWithError($route, $message = null, $errors = [], $routeParams = []): RedirectResponse
    {
        $message = $message ?? __('response.default_error_message');

        return redirect()->route($route, $routeParams)->with([
            'error' => $message,
            'errors' => $errors,
        ]);
    }

    /**
     * Redirect with unauthorized error.
     *
     * @param  string|null  $message
     */
    public function unauthorizedRedirect($message = null): RedirectResponse
    {
        $message = $message ?? __('response.not_authorized');

        return redirect()->back()->with([
            'error' => $message,
        ])->setStatusCode(403);
    }

    /**
     * Redirect with internal server error.
     *
     * @param  string|null  $message
     */
    public function internalServerRedirect($message = null): RedirectResponse
    {
        $message = $message ?? __('response.default_error_message');

        return redirect()->back()->with([
            'error' => $message,
        ])->setStatusCode(500);
    }

    /**
     * Render Inertia page with success message.
     *
     * @param  string  $component
     * @param  array  $props
     * @param  string|null  $message
     */
    public function renderWithSuccess($component, $props = [], $message = null): InertiaResponse
    {
        $message = $message ?? __('response.default_success_message');

        return Inertia::render($component, array_merge($props, [
            'flash' => [
                'success' => $message,
            ],
        ]));
    }

    /**
     * Render Inertia page with error message.
     *
     * @param  string  $component
     * @param  array  $props
     * @param  string|null  $message
     * @param  array  $errors
     */
    public function renderWithError($component, $props = [], $message = null, $errors = []): InertiaResponse
    {
        $message = $message ?? __('response.default_error_message');

        return Inertia::render($component, array_merge($props, [
            'flash' => [
                'error' => $message,
                'errors' => $errors,
            ],
        ]));
    }

    /**
     * Redirect with validation errors.
     *
     * @param  array  $errors
     * @param  string|null  $message
     */
    public function redirectWithValidationErrors($errors, $message = null): RedirectResponse
    {
        $message = $message ?? __('validation.validation_failed');

        return redirect()->back()
            ->withErrors($errors)
            ->withInput()
            ->with('error', $message);
    }
}
