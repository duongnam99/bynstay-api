<?php
namespace App\Repositories\WishList;

use App\Models\HomestayImage;
use App\Models\HomestayPrice;
use App\Models\User;
use App\Repositories\BaseRepository;

class WishListRepository extends BaseRepository implements WishListRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\WishList::class;
    }

    public function isExist($userId, $hsId)
    {
        if ($this->model->where('homestay_id', $hsId)->where('user_id', $userId)->first()) {
            return true;
        }

        return false;
    }

    public function getHs($userId)
    {
        $rs = User::where('id', $userId)->with('wishlist')->first();
        $homestays = $rs['wishlist'];
        foreach($homestays as $key => $homestay) {
            $homestays[$key]['images'] = HomestayImage::where('homestay_id', $homestay['id'])->get();
            $homestays[$key]['price'] = HomestayPrice::where('homestay_id', $homestay['id'])->first();
        }

        return $homestays;
    }

    public function deleteRelation($userId, $hsId)
    {
        return $this->model->where('user_id', $userId)->where('homestay_id', $hsId)->delete();
    }

    public function isWhished($userId, $hsId)
    {
        if ($this->model->where('user_id', $userId)->where('homestay_id', $hsId)->first()) {
            return true;
        }

        return false;
    }

}