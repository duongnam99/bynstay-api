<?php
namespace App\Repositories\SuggestPlace;

use App\Models\SuggestedPlace;
use App\Repositories\BaseRepository;

class SuggestPlaceRepository extends BaseRepository implements SuggestPlaceRepositoryInterface
{
    public function getModel()
    {
        return SuggestedPlace::class;
    }
}