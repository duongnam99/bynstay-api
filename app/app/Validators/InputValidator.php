<?php

namespace App\Validators;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;

class InputValidator {

    /**
     * @param Illuminate\Http\Request
     */
    public static function storeHomestayPharse1(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'provine_id' => 'required'
        ]);
    }
    public static function storeHomestayPolicyType(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
        ]);
    }

    public static function homestayPolicy(Request $request)
    {
        return Validator::make($request->all(), [
            'homestay_id' => 'required',
            'policy_id' => 'required',
            'content' => 'required'
        ]);
    }

    public static function homestayUtility(Request $request)
    {
        return Validator::make($request->all(), [
            'homestay_id' => 'required',
            'utility_id' => 'required',
        ]);
    }
}
