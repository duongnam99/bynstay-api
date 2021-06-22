<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuggestedPlace;
use App\Repositories\SuggestPlace\SuggestPlaceRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SuggestPlaceController extends AdminBaseController
{
    protected $suggesPlaceRepo;
    public function __construct(SuggestPlaceRepositoryInterface $suggesPlaceRepo)
    {
        $this->suggesPlaceRepo = $suggesPlaceRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $places = SuggestedPlace::all();

        if ($request->has('_start')) {
            $places = SuggestedPlace::offset($request->_start);
            if ($request->has('_end')) {
                $places->limit((int) $request->_end - (int) $request->_start); 
            }
            return $this->sendResponse($places->get(), true, $places->count());

        }
        
        return $this->sendResponse($places, true);
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
            'pictures' => 'required',
            'district_id' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        
        $base64_image = $input['pictures']["src"];
        preg_match('/^data:image\/(\w+);base64,/', $base64_image);
        $image = substr($base64_image, strpos($base64_image, ',') + 1);

        $path = Storage::disk('public_uploads')->put('suggest-places/'.$input['pictures']["title"], base64_decode($image));

        $data = $this->suggesPlaceRepo->create([
            'image' => config('app.url').'uploads/suggest-places/'.$input['pictures']["title"],
            'district_id' => $request->district_id
        ]);

        return $this->sendResponse($data, 'Suggest place created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $place = SuggestedPlace::find($id);

        if (is_null($place)) {
            return $this->sendError('Suggest Place not found.');
        }

        return $this->sendResponse($place, true);
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
        $place = SuggestedPlace::findOrFail($id);
        $place->delete();
        return $this->sendResponse($place);
    }
}
