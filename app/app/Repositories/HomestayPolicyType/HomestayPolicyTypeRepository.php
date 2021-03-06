<?php
namespace App\Repositories\HomestayPolicyType;

use App\Repositories\BaseRepository;
use App\Repositories\HomestayPolicyType\HomestayPolicyTypeRepositoryInterface;

class HomestayPolicyTypeRepository extends BaseRepository implements HomestayPolicyTypeRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\HomestayPolicyType::class;
    }
}