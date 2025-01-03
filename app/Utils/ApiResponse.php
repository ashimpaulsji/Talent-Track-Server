<?php

namespace App\Utils;

class ApiResponse
{
    public static function success($data = null, $message = 'Operation successful', $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public static function error($message = 'An error occurred', $status = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $status);
    }
}
