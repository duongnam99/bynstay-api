<?php

namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\API\BaseController;
use App\Http\Controllers\Controller;
use App\Repositories\WishList\WishListRepositoryInterface;
use App\Validators\InputValidator;
use Illuminate\Http\Request;

class WishListController extends BaseController
{
    protected $wishListRepo;

    public function __construct(WishListRepositoryInterface $wishListRepo)
    {
        $this->wishListRepo = $wishListRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->wishListRepo->getAll();
        return response()->json($data);
        
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
        $validator = InputValidator::wishlist($request);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }
        
        if (!$this->wishListRepo->isExist($request->user()->id, $request->homestay_id)) {
            $data = $this->wishListRepo->create([
                'user_id' => $request->user()->id,
                'homestay_id' => $request->homestay_id
            ]);
            return response()->json($data);
        }
        
        return $this->sendResponse([
            'status' => false,
            'message' => 'homestay in wish list already exist'
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
        $record = $this->wishListRepo->find($id);
        return response()->json($record);
        
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
        $result = $this->wishListRepo->delete($id);
        $response = ["status" => $result];
        return response()->json($response);

    }

    public function getHs(Request $request)
    {
        $hs = $this->wishListRepo->getHs($request->user()->id);
        return response()->json($hs);
    }

    public function deleteWishHs(Request $request)
    {
        $rs = $this->wishListRepo->deleteRelation($request->user()->id, $request->id);
        return response()->json($rs);

    }

    public function checkWished(Request $request)
    {
        $rs = $this->wishListRepo->isWhished($request->user()->id, $request->id);
        $response = ["status" => $rs];
        return response()->json($response);

    }

}
