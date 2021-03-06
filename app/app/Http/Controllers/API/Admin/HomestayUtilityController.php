<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\API\Admin\AdminBaseController;
use App\Http\Resources\HomestayUtilitesResource;
use App\Models\HomestayUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomestayUtilityController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $utilities = HomestayUtility::with('parent')->get();
        return $this->sendResponse(HomestayUtilitesResource::collection($utilities), 'Homestay utility retrieved successfully.');
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
        
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $utility = HomestayUtility::create($input);
        
        return $this->sendResponse(new HomestayUtilitesResource($utility), 'Utility created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $utility = HomestayUtility::find($id);
  
        if (is_null($utility)) {
            return $this->sendError('Utility not found.');
        }
   
        return $this->sendResponse(new HomestayUtilitesResource($utility), true);
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
        $input = $request->all();
   
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $utility = HomestayUtility::find($id);
  
        if (is_null($utility)) {
            return $this->sendError('Utility not found.');
        }

        $utility->parent_id = $input['parent_id'];
        $utility->name = $input['name'];
        $utility->save();
   
        return $this->sendResponse(new HomestayUtilitesResource($utility));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $utility = HomestayUtility::findOrFail($id);
        $utility->delete();
        return $this->sendResponse(new HomestayUtilitesResource($utility));
    }

    public function getListChildById($id)
    {
        $utility = HomestayUtility::where('parent_id', $id)->get();
        return $this->sendResponse(new HomestayUtilitesResource($utility));
    }
}
