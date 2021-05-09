<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\HomestayOrder\HomestayOrderRepositoryInterface;
use App\Validators\InputValidator;
use Illuminate\Http\Request;

class HsOrderController extends BaseController
{
    protected $homestayOrderRepo;

    public function __construct(HomestayOrderRepositoryInterface $homestayOrderRepo)
    {
        $this->homestayOrderRepo = $homestayOrderRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $validator = InputValidator::homestayOrder($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        
        $data = $this->homestayOrderRepo->create($input);
        return $this->sendResponse($data);
        
        return $this->sendResponse([
            'status' => false,
            'message' => 'Order created fail!'
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
        $result = $this->homestayOrderRepo->find($id);
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

    public function orderTime($hsId)
    {
        $orders = $this->homestayOrderRepo->getOrderedTime($hsId);
        $range = [];
        foreach ($orders as $key => $order) {
            $range[$key]['from'] = $order['start_date'];
            $range[$key]['to'] = $order['end_date'];
        }
        return response()->json(['range' => $range]);
    }
}
