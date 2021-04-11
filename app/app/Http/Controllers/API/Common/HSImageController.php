<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\HomestayImageResource;
use App\Repositories\HomestayImage\HomestayImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class HSImageController extends BaseController
{
    protected $homestayImageRepo;

    public function __construct(HomestayImageRepositoryInterface $homestayImageRepo)
    {
        $this->homestayImageRepo = $homestayImageRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->homestayImageRepo->getAll();
        return $this->sendResponse(HomestayImageResource::collection($data), true);
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
        if ($request->has('file')) {
            foreach($request->file as $file) {
                
                $path = Storage::disk('public_uploads')->put('homestay', $file);
                // Storage::disk('public')->put($file->getClientOriginalName(), File::get($file));
                $data = $this->homestayImageRepo->create([
                    'image' => $path,
                    'homestay_id' => $request->homestay_id
                ]);
            }

            return response()->json(['success' => true]);
        }
      
        return response()->json(['success' => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $result = $this->homestayImageRepo->findBy('homestay_id', $id);
        return response()->json($result);
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
        $result = $this->homestayImageRepo->delete($id);
        $response = ["status" => $result];
        return $this->sendResponse(new HomestayImageResource($response));
    }

    public function getHsImage($hsId)
    {
        $result = $this->homestayImageRepo->findManyBy('homestay_id', $hsId);
        foreach($result as $key => $image) {
            $result[$key]['url'] = asset('uploads/'.$image['image']);
        }
        return response()->json($result);
    }
}
