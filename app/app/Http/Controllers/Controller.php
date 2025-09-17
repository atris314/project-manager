<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function sendResponse($result, $message, $code = 200)
    {
        $response = [
            'data' => $result,
            'server_time' => now()->toIso8601String(),
            'status' => true,
            'message' => $message,
        ];
        return response()->json($response, $code);
    }


    /**
     * return error response.
     *

     * @return \Illuminate\Http\JsonResponse
     */

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'data' => [
                'status' => false,
                'message' => $error,
            ],
            'server_time' => now()->toIso8601String(),
        ];
        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
