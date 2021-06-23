<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Mail\MailOrder;
use App\Models\Host;
use App\Repositories\Homestay\HomestayRepositoryInterface;
use App\Repositories\HomestayOrder\HomestayOrderRepositoryInterface;
use App\Validators\InputValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HsOrderController extends BaseController
{
    protected $homestayOrderRepo;
    protected $homestayRepo;

    public function __construct(
        HomestayOrderRepositoryInterface $homestayOrderRepo,
        HomestayRepositoryInterface $homestayRepo    
    )
    {
        $this->homestayOrderRepo = $homestayOrderRepo;
        $this->homestayRepo = $homestayRepo;
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
        $input = $request->all();

        $result = $this->homestayOrderRepo->update($id, $input);
        return response()->json($result);
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

    public function getCustomerByHost(Request $request)
    {
        $homestayIds = $this->homestayRepo->getHsIdByUser( $request->user()->id);
        $orders = $this->homestayOrderRepo->getOrderByHomestay($homestayIds);
        $customers = $orders->map->only(['customer_email', 'customer_name', 'customer_phone']);

        return response()->json($customers);
    }

    public function getOrderByHost(Request $request)
    {
        $homestayIds = $this->homestayRepo->getHsIdByUser($request->user()->id);
        $orders = $this->homestayOrderRepo->getOrderByHomestay($homestayIds);

        return response()->json($orders);
    }

    public function getCustomerOrder(Request $request)
    {
        if ($request->email != $request->user()->email) {
            return $this->sendError("No permission", [], 403);
        }
        
        $orders = $this->homestayOrderRepo->getOrderByCustomer($request->email);
   
        return response()->json($orders);
    }

    public function resendMailOrder(Request $request)
    {

        $order = $this->homestayOrderRepo->find($request->orderId);
         
        $result =  Mail::to($order['customer_email'])->send(new MailOrder($order));

        return response()->json(['send' => 1]);
    }
}
