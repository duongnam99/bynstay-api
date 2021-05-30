<?php
namespace App\Repositories\HomestayOrder;

interface HomestayOrderRepositoryInterface
{
    public function getOrderedTime($hsId);
    public function getOrderByHomestay($hsIds);
    public function getOrderByCustomer($csEmail);

}