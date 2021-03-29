<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;
use App\Repositories\HomestayImage\HomestayImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HSImageController extends Controller
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
                Storage::disk('public')->put($file->getClientOriginalName(), $file);
            }
            $data = $this->homestayImageRepo->create([
                'image' => $file->getClientOriginalName(),
                'homestay_id' => $request->homestay_id
            ]);
            return $this->sendResponse(new HomestayImageResource($data));
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
        //
    }
}
