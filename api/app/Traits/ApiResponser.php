<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

/**
 *
 */
trait ApiResponser
{

    /**
     * @param $data
     * @param $message
     * @param $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $message = null, $code = 200):JsonResponse
    {
        $array =  [];
        $array['status']= 'Success';
        if ($message) {
            $array['message'] = $message;
        }
        if ($data) {
            $array['data'] = $data;
        }
        return response()->json($array, $code);
    }

    /**
     * @param $message
     * @param $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = null, $code)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
        ], $code);
    }



}
