<?php

namespace App\Repositories\HomestayUtility;

use App\Repositories\BaseRepository;

class HomestayUtilityRepository extends BaseRepository implements HomestayUtilityRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\HomestayUtility::class;
    }
}
