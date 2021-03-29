<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\VnDistrict;
use App\Models\VnProvince;
use App\Models\VnWard;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
    public function getDistrict()
    {
        $data = VnDistrict::all();

        return $this->sendResponse($data);
    }

    public function getProvince()
    {
        $data = VnProvince::all();

        return $this->sendResponse($data);
    }

    public function getWard()
    {
        $data = VnProvince::all();

        return $this->sendResponse($data);
    }

    public function getDistrictByProvince($id)
    {
        $data = VnDistrict::where('province_id', $id)->get();

        return $this->sendResponse($data);
    }

    public function getWardByDistrict($id)
    {
        $data = VnWard::where('district_id', $id)->get();

        return $this->sendResponse($data);
    }
}
