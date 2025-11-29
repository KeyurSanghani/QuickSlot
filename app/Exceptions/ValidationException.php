<?php

namespace App\Exceptions;

use App\Traits\JsonResponseHelper;
use Exception;
use Illuminate\Contracts\Debug\ShouldntReport;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ValidationException extends Exception implements ShouldntReport
{
    use JsonResponseHelper;

    public function __construct(protected Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Render the exception into an HTTP response.
     */
    public function render(Request $request): JsonResponse|RedirectResponse
    {
        // Check if this is a true API request (not Inertia)
        $isApiRequest = ($request->expectsJson() || $request->is('api/*'))
                       && ! $request->header('X-Inertia');

        if ($isApiRequest) {
            return $this->sendResponse(
                false,
                $this->validator->errors(),
                __('response.validation_errors'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        // For web requests (including Inertia), redirect back with validation errors
        return redirect()->back()
            ->withErrors($this->validator->errors())
            ->withInput($request->except(['password', 'password_confirmation']));
    }
}
