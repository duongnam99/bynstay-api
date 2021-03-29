<?php
namespace App\Repositories\HomestayPolicy;

use App\Models\Homestay;
use App\Models\HomestayPolicy;
use App\Repositories\BaseRepository;

class HomestayPolicyRepository extends BaseRepository implements HomestayPolicyRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\HomestayPolicy::class;
    }

    public function getFull($hsId)
    {
        $data = Homestay::find($hsId)->policyTypes()->get();
        foreach ($data as $key => $rec) {
            $data[$key]['content'] = HomestayPolicy::where('homestay_id', $rec['pivot']['homestay_id'])->where('policy_id', $rec['pivot']['policy_id'])->first()->content;
        }
        return $data;
    }

    public function isExist($input) 
    {
        if ($this->model->where('homestay_id', $input['homestay_id'])->where('policy_id', $input['policy_id'])->first()) {
            return true;
        }

        return false;
    }
}