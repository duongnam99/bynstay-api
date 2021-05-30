<?php

namespace App\Repositories\HomestayPrice;

interface HomestayPriceRepositoryInterface {
    
    public function isExist($input);
    public function findAndSort($ids, $type);
}
