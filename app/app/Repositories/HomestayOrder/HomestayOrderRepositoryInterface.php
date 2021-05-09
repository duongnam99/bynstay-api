<?php
namespace App\Repositories\HomestayOrder;

interface HomestayOrderRepositoryInterface
{
    public function getOrderedTime($hsId);
}