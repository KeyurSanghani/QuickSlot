<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait JsonResponseHelper
{
    /**
     * JSON response method.
     *
     * @param  bool  $status
     * @param  null|array  $data
     * @param  null|string  $message
     * @param  int  $code
     */
    public function sendResponse($status = true, $data = null, $message = null, $code = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'status' => $status,
            'message' => $message === null ? __('response.default_success_message') : $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }

    /**
     * JSON response method to return internal server message.
     *
     * @param  null|string  $message
     */
    public function internalServerError($message = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message ?? __('response.default_error_message'),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * JSON response method to return unauthorized action message.
     *
     * @param  null|string  $message
     */
    public function UnauthorizedActionError($message = null): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message ?? __('response.not_authorized'),
        ], Response::HTTP_UNAUTHORIZED);
    }
}
