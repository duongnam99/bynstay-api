<?php
namespace App\Repositories\HomestayOrder;

use App\Models\Homestay;
use App\Models\HomestayImage;
use App\Models\HomestayOrder;
use App\Models\HomestayPolicy;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

class HomestayOrderRepository extends BaseRepository implements HomestayOrderRepositoryInterface
{
    public function getModel()
    {
        return HomestayOrder::class;
    }

    public function getOrderedTime($hsId)
    {
        return $this->model->where('end_date', '>', Carbon::now())->where('homestay_id', $hsId)->get();
    }

    public function getOrderByHomestay($hsIds)
    {
        return $this->model->whereIn('homestay_id', $hsIds)->get();
    }

    public function getOrderByCustomer($csEmail)
    {
        $orders = $this->model->where('customer_email', $csEmail)->with('homestay')->get();
        if (count($orders) == 0) {
            return $orders;
        }
        
        foreach($orders as $key => $order) {
            $orders[$key]['homestay']['images'] = HomestayImage::where('homestay_id', $order['homestay']['id'])->get();
        }

        return $orders;
    }
}