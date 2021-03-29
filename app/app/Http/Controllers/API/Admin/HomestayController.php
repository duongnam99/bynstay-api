<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\Admin\AdminBaseController;
use App\Http\Resources\HomestayResource;
use App\Models\Homestay;
use App\Models\Location;
use App\Repositories\Homestay\HomestayRepositoryInterface;
use App\Repositories\Location\LocationRepositoryInterface;
use App\Validators\InputValidator;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomestayController extends AdminBaseController
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
        return $this->sendResponse(HomestayResource::collection($homestay), true);
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
        $validator = InputValidator::storeHomestayPharse1($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $data = $this->storePharse1($request);

        return $this->sendResponse(new HomestayResource($data));
    }

    public function storePharse1($request) {
        try{

            $locationData = [
                'province_id' => $request->province_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
            ];
            $locationResult = $this->locationRepo->create($locationData);

            $homestayData = [
                'name' => $request->name,
                'type_id' => $request->type_id,
                'location' => $request->location,
                'location_id' => $locationResult->id
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
        $homestayResult = $this->homestayRepo->find($id);
        $locationResult = $this->locationRepo->find($homestayResult->location_id);
        $homestayResult->location_info = $locationResult;

        return response()->json($homestayResult);
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
        $validator = InputValidator::storeHomestayPharse1($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $record = $this->homestayRepo->find($id);

        if (is_null($record)) {
            return $this->sendError('Record not found.');
        }

        $homestay = $this->homestayRepo->update($id, $request->all());
        $location = $this->locationRepo->update($homestay->location_id, $request->all());

        if($record === false) {
            $$record = ["status" => false];
        }

        return $this->sendResponse(new HomestayResource($record));
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
