<?php

namespace App\Traits;

trait ApiResponses
{
    // Success API Response
    protected function successResponse(
        $data = [],
        $message = 'Request successful',
        $status = 200
    ) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    // Error API Response
    protected function errorResponse(
        $message = 'Something went wrong',
        $status = 400,
        $errors = null
    ) {
        $response = [
            'success' => false,
            'message' => $message
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    /**
     * 403 Forbidden: the user is logged in but is not allowed to do this.
     */
    protected function notAuthorized(
        string $message = 'You are not authorized to perform this action.'
    ) {
        return $this->errorResponse($message, 403);
    }
}
