<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function success($data = null, $message = null, $statusCode = 200)
    {
        $array = [
            'success' => true,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data,

        ];
        return response($array);
    } 
    
    public function successPagination($data = null, $message = null, $statusCode = 200)
    {
        $array = [
            'success' => true,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data,
            'pagination' => [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'per_page' => $data->perPage(),
                'total' => $data->total(),
                'has_more_pages' => $data->hasMorePages(),
                'next_page_url' => $data->nextPageUrl(),
                'prev_page_url' => $data->previousPageUrl(),
            ]

        ];
        return response($array);
    }
    public function successToken($data = null, $message = null, $statusCode = 200, $token = null)
    {
        $array = [
            'success' => true,
            'message' => $message,
            'code' => $statusCode,
            'data' => $data,
            'token' => $token,

        ];
        return response($array);
    }

    public function error($message = null, $error = null, $statusCode = 500)
    {
        $array = [
            'success' => false,
            'message' => $message,
            'code' => $statusCode,
            'error' => $error
        ];
        return response($array);
    }


    public function empty($message = null, $statusCode = 404)
    {
        $array = [
            'success' => true,
            'message' => $message,
            'code' => $statusCode,
            'data' => [],
        ];
        return response($array);
    }
}
