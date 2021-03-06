<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    /**
     * success response method.
     *
     * @return JsonResponse
     */
    public function sendResponse($result, $message = '', $isGetList = false)
    {
        if ($isGetList) {
            return response()->json($result, 200)
            ->header('Access-Control-Expose-Headers', 'X-Total-Count')
            ->header('X-Total-Count', $result->count());
        }
//
//    	$response = [
//            'success' => true,
//            'data'    => $result,
//            'message' => $message,
//        ];

        return response()->json($result, 200);
    }


    /**
     * return error response.
     *
     * @return JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
