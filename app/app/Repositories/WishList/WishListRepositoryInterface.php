<?php

namespace App\Repositories\WishList;

interface WishListRepositoryInterface
{
    public function isExist($userId, $hsId);
    public function getHs($userId);
    public function deleteRelation($userId, $hsId);
    public function isWhished($userId, $hsId);
}
