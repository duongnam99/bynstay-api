<?php
namespace App\Repositories\Homestay;

interface HomestayRepositoryInterface
{
    public function getHomestay($id);

    public function storeHometayPharse1($data);
    public function findByLocation($location);
    public function filterHsType($ids, $type);
    public function getHsIdByUser($userId);

}