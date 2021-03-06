<?php

namespace App\Http\Controllers\API\Admin;

use Illuminate\Http\Request;
use App\Validators\InputValidator;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomestayPolicyTypeResource;
use App\Repositories\HomestayPolicyType\HomestayPolicyTypeRepositoryInterface;

class HomestayPolicyTypeController extends AdminBaseController
{
    protected $homestayPolicytypeRepo;

    public function __construct(HomestayPolicyTypeRepositoryInterface $homestayPolicytypeRepo)
    {
        $this->homestayPolicytypeRepo = $homestayPolicytypeRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->homestayPolicytypeRepo->getAll();
        return $this->sendResponse(HomestayPolicyTypeResource::collection($data), true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
   
        $validator = InputValidator::storeHomestayPolicyType($request);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $data = $this->homestayPolicytypeRepo->create($input);
   

        return $this->sendResponse(new HomestayPolicyTypeResource($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->homestayPolicytypeRepo->find($id);
        return $this->sendResponse(new HomestayPolicyTypeResource($record));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $input = $request->all();
   
        $validator = InputValidator::storeHomestayPolicyType($request);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $record = $this->homestayPolicytypeRepo->find($id);
  
        if (is_null($record)) {
            return $this->sendError('Type not found.');
        }
        $record = $this->homestayPolicytypeRepo->update($id, $request->all());

        if($record === false) {
            $$record = ["status" => false];
        }

        return $this->sendResponse(new HomestayPolicyTypeResource($record));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->homestayPolicytypeRepo->delete($id);
        $response = ["status" => $result];
        return $this->sendResponse(new HomestayPolicyTypeResource($response));
    }
}
