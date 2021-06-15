<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Homestay;
use App\Models\SuggestedPlace;
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

    public function suggested()
    {
        $data = SuggestedPlace::with('district')->get();

        return $this->sendResponse($data);
    }

    public function search(Request $request)
    {

        if ($request->has('query')) {
            $provinces = VnProvince::where('name', 'like', '%' . $request->get('query') . '%')->limit(3)->get()->toArray();
            $districts = VnDistrict::where('name', 'like', '%' . $request->get('query') . '%')->limit(2)->get()->toArray();
            $homestays = Homestay::where('name', 'like', '%' . $request->get('query') . '%')->limit(5)->get()->toArray();
            foreach($districts as $key => $district) {
                // $districts[$key]['id'] = 'd_'.$district['id'];
                $districts[$key]['s_type'] = 'district';
            }
            foreach($provinces as $key => $province) {
                $provinces[$key]['s_type'] = 'province';
            }
            foreach($homestays as $key => $homestay) {
                $homestays[$key]['s_type'] = 'homestay';
            }

            $result = array_merge($homestays, $districts, $provinces);
            // $result = $provines->concat($districts);

            return response()->json($result);
            return response()->json(array_merge($provinces,$districts));
        }

        return response()->json(['status' => false]);
    }
}
