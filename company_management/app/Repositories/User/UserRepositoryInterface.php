<?php

namespace App\Repositories\User;

use App\Repositories\AbstractRepositoryInterface;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    public function deleteAll($arrayId);
}
