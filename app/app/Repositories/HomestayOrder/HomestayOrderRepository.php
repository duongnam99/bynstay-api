<?php
namespace App\Repositories\HomestayOrder;

use App\Models\Homestay;
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
}