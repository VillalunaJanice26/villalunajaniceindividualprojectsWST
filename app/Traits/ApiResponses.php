<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponses
{
    /**
     * Shortcut for a 200 OK response.
     */
    protected function ok(string $message, mixed $data = null): JsonResponse
    {
        return $this->success($message, $data, 200);
    }

    /**
     * Generic success response.
     */
    protected function success(
        string $message,
        mixed $data = null,
        int $statusCode = 200
    ): JsonResponse {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $statusCode,
        ], $statusCode);
    }

    /**
     * Error response. Accepts a plain message or a list of error objects.
     */
    protected function error(
        string|array $errors = [],
        ?int $statusCode = null
    ): JsonResponse {
        // A single message
        if (is_string($errors)) {
            return response()->json([
                'message' => $errors,
                'status' => $statusCode ?? 400,
            ], $statusCode ?? 400);
        }

        // A list of errors
        $status = $statusCode ?? ($errors[0]['status'] ?? 500);

        // Guard against invalid HTTP status codes
        if ($status < 100 || $status > 599) {
            $status = 500;
        }

        return response()->json([
            'errors' => $errors,
        ], $status);
    }

    /**
     * Compatibility method for existing project routes.
     */
    protected function successResponse(
        $data = [],
        $message = 'Request successful',
        $status = 200
    ) {
        return $this->success($message, $data, $status);
    }

    /**
     * Compatibility method for existing error responses.
     */
    protected function errorResponse(
        $message = 'Something went wrong',
        $status = 400,
        $errors = null
    ) {
        if ($errors !== null) {
            return $this->error($errors, $status);
        }

        return $this->error($message, $status);
    }

    /**
     * 403 Forbidden.
     */
    protected function notAuthorized(
        string $message = 'You are not authorized to perform this action.'
    ): JsonResponse {
        return $this->error([
            [
                'status' => 403,
                'message' => $message,
                'source' => '',
            ],
        ]);
    }
}
