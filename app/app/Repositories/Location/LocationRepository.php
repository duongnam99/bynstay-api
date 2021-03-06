<?php
namespace App\Repositories\Location;

use App\Repositories\BaseRepository;
use App\Repositories\Location\LocationRepositoryInterface;

class LocationRepository extends BaseRepository implements LocationRepositoryInterface
{
    //lấy model tương ứng
    public function getModel()
    {
        return \App\Models\Location::class;
    }


}