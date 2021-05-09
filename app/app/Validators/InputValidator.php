<?php

namespace App\Validators;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Validator;

class InputValidator {

    public static function storeHomestayPharse1(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'location' => 'required',
            'province_id' => 'required',
            'type_id' => 'required'
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

    public static function homestayPrice(Request $request)
    {
        return Validator::make($request->all(), [
            'homestay_id' => 'required',
            'price_normal' => 'required',
            'max_night' => 'required|numeric|min:0|not_in:0',
            'max_guest' => 'required|numeric|min:0|not_in:0',
        ]);
    }

    public static function updateHostPw(Request $request)
    {
        return Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'new_password' => 'required',
        ]);
    }

    public static function homestayOrder(Request $request)
    {
        return Validator::make($request->all(), [
            'customer_email' => 'required|email',
            'customer_name' => 'required',
            'customer_phone' => 'required',
        ]);
    }
}
