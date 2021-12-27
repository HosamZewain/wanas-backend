<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class BaseController extends Controller
{
    public const RESPONSE_STATUS_OK = 200;
    public const RESPONSE_STATUS_ERROR = 400;


    /**
     * @param $msg
     * @param $data
     * @return JsonResponse
     */
    public function ResponseJsonSuccess($msg, $data)
    {
        $response = [
            'status' => self::RESPONSE_STATUS_OK,
            'msg' => $msg,
            'data' => $data
        ];

        return Response::json($response, 200);
    }

    /**
     * @param $msg
     * @param null $data
     * @param array|null $errors
     * @return JsonResponse
     */
    public function ResponseJsonError($msg, $data = null, array $errors = null)
    {
        $response = [
            'status' => self::RESPONSE_STATUS_ERROR,
            'msg' => $msg,
            'data' => $data,
            'errors' => $errors,
        ];
        return response()->json($response, self::RESPONSE_STATUS_ERROR);
    }
}
