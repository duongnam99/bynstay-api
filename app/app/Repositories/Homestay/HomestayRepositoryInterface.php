<?php
namespace App\Repositories\Homestay;

interface HomestayRepositoryInterface
{
    public function getHomestay($id);

    public function storeHometayPharse1($data);
}