<?php

namespace App\Repositories\HomestayUtility;

use App\Models\Homestay;
use App\Models\HomestayUtility;
use App\Models\HomestayUtilityType;
use App\Repositories\BaseRepository;

class HomestayUtilityRepository extends BaseRepository implements HomestayUtilityRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\HomestayUtility::class;
    }

    public function getParent()
    {
        $data = HomestayUtilityType::where('parent_id', null)->get();
        return $data;
    }

    public function getChild()
    {
        $data = HomestayUtilityType::where('parent_id', '!=', null)->get();
        return $data;
    }

    public function getChildByParent($id)
    {
        $data = HomestayUtilityType::where('parent_id', $id)->get();
        return $data;
    }

    public function getHsUtil($id)
    {
        $data = Homestay::find($id)->utilities()->get();
        $result = [];
        foreach ($data as $util) {
            if ($util->parent_id != null) {
                $parent = HomestayUtilityType::where('id', $util->parent_id)->first();
                if (!array_key_exists($parent->name, $result)) {
                    $result[$parent->name][] = $util;
                } else {
                    array_push($result[$parent->name], $util);
                }
            }
       
        }
        
        return $result;
    }


    public function isExist($input) 
    {
        if ($this->model->where('homestay_id', $input['homestay_id'])->where('utility_id', $input['utility_id'])->first()) {
            return true;
        }

        return false;
    }
}
