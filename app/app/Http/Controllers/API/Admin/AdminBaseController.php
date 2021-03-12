<?php


namespace App\Http\Controllers\API\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class AdminBaseController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $isGetList = false)
    {
        if ($isGetList) {
            return response()->json($result, 200)
            ->header('Access-Control-Expose-Headers', 'X-Total-Count')
            ->header('X-Total-Count', $result->count());
        }
        return response()->json($result, 200);
        // ->header('Access-Control-Expose-Headers', 'X-Total-Count');
        // ->header('X-Total-Count', $result->count());
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
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