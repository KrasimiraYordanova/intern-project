<?php

declare (strict_types = 1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    /**
     * Generate a success response.
     *
     * @param mixed $data The data to be included in the response.
     * @param string $message The message to be included in the response. Default is 'Success'.
     * @param int $code The HTTP status code for the response. Default is 200.
     * @return JsonResponse The JSON response.
     */

    protected function onSuccess($data, $message = 'success', $code = 200): JsonResponse {
        return response()->json([
            'data' => $data,
            'status' => $message,
            'statusCode' => $code
        ], $code);
    }

    /**
     * Generate an error response.
     *
     * @param string $message The error message. Default is 'Error'.
     * @param int $code The HTTP status code. Default is 400.
     */
    protected function onError($message = 'error', $code = 400): JsonResponse {
        return response()->json([
            'status' => $message,
            'statusCode' => $code,
        ], $code);
    }
}
