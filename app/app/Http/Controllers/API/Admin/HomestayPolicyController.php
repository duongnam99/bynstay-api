<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomestayPolicyResource;
use App\Repositories\HomestayPolicy\HomestayPolicyRepositoryInterface;
use App\Validators\InputValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomestayPolicyController extends AdminBaseController
{
    protected $homestayPolicyRepo;

    public function __construct(HomestayPolicyRepositoryInterface $homestayPolicyRepo)
    {
        $this->homestayPolicyRepo = $homestayPolicyRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->homestayPolicyRepo->getAll();
        return $this->sendResponse(HomestayPolicyResource::collection($data), true);
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
        $validator = InputValidator::homestayPolicy($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        
        if (!$this->homestayPolicyRepo->isExist($input)) {
            $data = $this->homestayPolicyRepo->create($input);
            return $this->sendResponse(new HomestayPolicyResource($data));
        }
        
        return $this->sendResponse([
            'status' => false,
            'message' => 'Policy already exist'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = $this->homestayPolicyRepo->find($id);
        return $this->sendResponse(new HomestayPolicyResource($record));
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
        $validator = InputValidator::homestayPolicy($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $record = $this->homestayPolicyRepo->find($id);

        if (is_null($record)) {
            return $this->sendError('Record not found.');
        }
        $record = $this->homestayPolicyRepo->update($id, $request->all());

        if($record === false) {
            $$record = ["status" => false];
        }

        return $this->sendResponse(new HomestayPolicyResource($record));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $policy = $this->homestayPolicyRepo->findBy('policy_id', $id);
        $result = $this->homestayPolicyRepo->delete($policy->id);
        $response = ["status" => $result];
        return $this->sendResponse(new HomestayPolicyResource($response));
    }

    public function getFull($id)
    {
        $result = $this->homestayPolicyRepo->getFull($id);
        return $this->sendResponse($result);

    }
}
