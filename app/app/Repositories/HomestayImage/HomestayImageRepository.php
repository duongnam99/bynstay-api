<?php
namespace App\Repositories\HomestayImage;

use App\Repositories\BaseRepository;

class HomestayImageRepository extends BaseRepository implements HomestayImageRepositoryInterface
{
    public function getModel()
    {
        return \App\Models\HomestayImage::class;
    }

}