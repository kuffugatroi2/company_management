<?php

namespace App\Repositories\Role;

use App\Repositories\AbstractRepositoryInterface;

interface RoleRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListRole();
    public function deleteAll($arrayId);
}
