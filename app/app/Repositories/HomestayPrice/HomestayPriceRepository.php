<?php

namespace App\Repositories\HomestayPrice;

use App\Models\HomestayPrice;
use App\Repositories\BaseRepository;

class HomestayPriceRepository extends BaseRepository implements HomestayPriceRepositoryInterface
{
    public function getModel()
    {
        return HomestayPrice::class;
    }

    public function isExist($input)
    {
        if ($this->model->where('homestay_id', $input['homestay_id'])->first()) {
            return true;
        }

        return false;
    }

    public function findAndSort($ids, $type)
    {
        return $this->model->whereIn('homestay_id', $ids)->orderBy('price_normal', $type)->get();
    }
}
