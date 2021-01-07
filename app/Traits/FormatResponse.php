<?php

namespace App\Traits;

trait FormatResponse {

    /**
     * format responsse data
     */
    public function formatResponse($status, $statusCode, $message, $data=null) {

        return response()->json([
            'status' => $status,
            'statusCode' => $statusCode,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }
}