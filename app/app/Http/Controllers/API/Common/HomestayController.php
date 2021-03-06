<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\HomestayResource;
use App\Models\Homestay;
use App\Models\Location;
use App\Repositories\Homestay\HomestayRepositoryInterface;
use App\Repositories\Location\LocationRepositoryInterface;
use App\Validators\InputValidator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomestayController extends BaseController
{

    protected $homestayRepo;

    protected $locationRepo;

    public function __construct(
        HomestayRepositoryInterface $homestayRepo,
        LocationRepositoryInterface $locationRepo
    )
    {
        $this->homestayRepo = $homestayRepo;
        $this->locationRepo = $locationRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homestay = Homestay::all();
        return $this->sendResponse(HomestayResource::collection($homestay));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch ($request->pharse) {
            case 1:
                $validator = InputValidator::storeHomestayPharse1($request);
                $data = $this->storePharse1($request);
                break;
            case 2:
                $validator = InputValidator::storeHomestayPharse1($request);
                $data = $this->storePharse1($request);
                break;
            default:
                $data = collect();
        }
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        return $this->sendResponse(new HomestayResource($data));
    }

    public function storePharse1($request) {
        try{

            $locationData = [
                'provine_id' => $request->provine_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
            ];
            $this->locationRepo->create($locationData);

            $homestayData = [
                'name' => $request->name,
                'type_id' => $request->type_id,
                'location' => $request->location,
                'location_id' => 1
            ];
            return $this->homestayRepo->create($homestayData);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function storePharse2($request) {
        try{

            $locationData = [
                'provine_id' => $request->provine_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
            ];
            $this->locationRepo->create($locationData);

            $homestayData = [
                'name' => $request->name,
                'type_id' => $request->type_id,
                'location' => $request->location,
                'location_id' => 1
            ];
            return $this->homestayRepo->create($homestayData);

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
