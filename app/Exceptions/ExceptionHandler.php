<?php

namespace App\Exceptions;

use App\Traits\InertiaResponseHelper;
use App\Traits\JsonResponseHelper;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Throwable;

class ExceptionHandler
{
    use InertiaResponseHelper, JsonResponseHelper;

    /**
     * Handle the given exceptions configuration.
     * If the request is an API request, return JSON responses.
     * If the request is a web request, return redirects or views.
     *
     *
     * @return void
     */
    public function handle(Exceptions $exceptions)
    {
        // Handle UnauthorizedException
        $exceptions->render(function (UnauthorizedException $e, Request $request) {
            $isApiRequest = $this->isApiRequest($request);

            if ($isApiRequest) {
                return $this->UnauthorizedActionError($e->getMessage());
            }

            return $this->unauthorizedRedirect($e->getMessage());
        });

        // Handle AuthenticationException
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            $isApiRequest = $this->isApiRequest($request);

            if ($isApiRequest) {
                return $this->sendResponse(false, null, $e->getMessage(), Response::HTTP_UNAUTHORIZED);
            }

            // For web requests, redirect to login or show error
            if ($request->routeIs('login') || $request->is('login')) {
                return $this->redirectWithError($e->getMessage() ?: 'Authentication required');
            }

            // Redirect to login page for unauthenticated web requests
            return redirect()->route('login')->with('error', $e->getMessage() ?: 'Please login to continue');
        });

        // Handle general exceptions
        $exceptions->render(function (Throwable $e, Request $request) {
            $isApiRequest = $this->isApiRequest($request);

            if ($isApiRequest) {
                return $this->internalServerError($e->getMessage());
            }

            return $this->internalServerRedirect($e->getMessage());
        });

        //  We can use the Sentry integration for error tracking here
        // if (prodEnv() || devEnv()) {
        //     Integration::handles($exceptions);
        // }
    }

    /**
     * Determine if the request is an API request.
     */
    private function isApiRequest(Request $request): bool
    {
        return ($request->expectsJson() || $request->is('api/*'))
            && ! $request->header('X-Inertia');
    }
}
