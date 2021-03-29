<?php

namespace App\Repositories\HomestayUtility;

interface HomestayUtilityRepositoryInterface
{
    public function getParent();
    public function getChild();
    public function getChildByParent($id);
    public function getHsUtil($id);
    public function isExist($input);
}
