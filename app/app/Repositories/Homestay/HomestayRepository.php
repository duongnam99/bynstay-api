<?php
namespace App\Repositories\Homestay;

use App\Repositories\BaseRepository;
use App\Repositories\Homestay\HomestayRepositoryInterface;

class HomestayRepository extends BaseRepository implements HomestayRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Homestay::class;
    }

    public function getHomestay()
    {
        return $this->model->select('product_name')->take(5)->get();
    }

    public function storeHometayPharse1($data)
    {
        return $this->model->create($data);
    }
}