<?php

namespace App\Repositories\Task;

use App\Repositories\AbstractRepositoryInterface;

interface TaskRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListTask();
    public function deleteAll($arrayId);
}
