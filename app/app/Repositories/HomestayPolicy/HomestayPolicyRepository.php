<?php
namespace App\Repositories\HomestayPolicy;

use App\Repositories\BaseRepository;

class HomestayPolicyRepository extends BaseRepository implements HomestayPolicyRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\HomestayPolicy::class;
    }
}