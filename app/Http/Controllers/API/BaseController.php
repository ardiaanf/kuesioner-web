<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * success response method.
     * @param $result
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($result, $message, $code = 200)
    {
        $response = [
            'error' => false,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     * @param $error
     * @param array $errorMessages
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'error' => true,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
