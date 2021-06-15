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

    public function getHomestay($id)
    {
        return $this->model->where('id', $id)->first()->location()->get();
    }

    public function storeHometayPharse1($data)
    {
        return $this->model->create($data);
    }

    public function findByLocation($location)
    {
        return $this->model->whereIn('location_id', $location)->with(['images', 'prices', 'utilities', 'type'])->get();
    }

    public function filterHsType($ids, $type)
    {
        return $this->model->whereIn('id', $ids)->where('type_id', $type)->get();
    }

    public function getHsIdByUser($userId)
    {
        return $this->model->where('user_id', $userId)->pluck('id');
    }

}