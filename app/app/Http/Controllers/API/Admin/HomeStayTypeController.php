<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Resources\HomestayTypeResource;
use App\Models\HomestayType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeStayTypeController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = HomestayType::all();
        return $this->sendResponse(HomestayTypeResource::collection($types), true);
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
   
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $type = HomestayType::create($input);
        
        return $this->sendResponse(new HomestayTypeResource($type));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = HomestayType::find($id);
  
        if (is_null($type)) {
            return $this->sendError('Type not found.');
        }
   
        return $this->sendResponse(new HomestayTypeResource($type));
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
   
        $validator = Validator::make($input, [
            'name' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $type = HomestayType::find($id);
  
        if (is_null($type)) {
            return $this->sendError('Type not found.');
        }

        $type->name = $input['name'];
        $type->save();
   
        return $this->sendResponse(new HomestayTypeResource($type));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $type = HomestayType::findOrFail($id);
        $type->delete();
        return $this->sendResponse(new HomestayTypeResource($type));
    }
}
