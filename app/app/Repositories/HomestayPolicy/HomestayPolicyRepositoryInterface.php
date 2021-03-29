<?php
namespace App\Repositories\HomestayPolicy;

interface HomestayPolicyRepositoryInterface
{
    public function getFull($hsId);
    public function isExist($input);
}