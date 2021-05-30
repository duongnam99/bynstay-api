<?php
namespace App\Repositories\Location;

interface LocationRepositoryInterface
{
   public function findWithHomestay($column, $value);
}