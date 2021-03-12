<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Http\Resources\HomestayPriceResource;
use App\Repositories\HomestayPrice\HomestayPriceRepositoryInterface;
use App\Validators\InputValidator;
use Illuminate\Http\Request;

class HSPriceController extends BaseController
{
    /**
     * @var HomestayPriceRepositoryInterface
     */
    protected $homestayPriceRepo;

    public function __construct(HomestayPriceRepositoryInterface $homestayPriceRepo)
    {
        $this->homestayPriceRepo = $homestayPriceRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = $this->homestayPriceRepo->getAll();
        return $this->sendResponse(HomestayPriceResource::collection($data), true);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = InputValidator::homestayPrice($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $data = $this->homestayPriceRepo->create($input);

        return $this->sendResponse(new HomestayPriceResource($data));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $record = $this->homestayPriceRepo->find($id);
        return $this->sendResponse(new HomestayPriceResource($record));
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = InputValidator::homestayPrice($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $record = $this->homestayPriceRepo->find($id);

        if (is_null($record)) {
            return $this->sendError('Type not found.');
        }
        $record = $this->homestayPriceRepo->update($id, $request->all());

        if($record === false) {
            $$record = ["status" => false];
        }

        return $this->sendResponse(new HomestayPriceResource($record));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = $this->homestayPriceRepo->delete($id);
        $response = ["status" => $result];
        return $this->sendResponse(new HomestayPriceResource($response));
    }
}
