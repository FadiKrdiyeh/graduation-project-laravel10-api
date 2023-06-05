<?php

namespace App\Traits;

trait ApiResponse {
    public function apiResponse(bool $status, int $statusCode, string $message, $data = null)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}