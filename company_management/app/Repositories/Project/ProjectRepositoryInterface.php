<?php

namespace App\Repositories\Project;

use App\Repositories\AbstractRepositoryInterface;

interface ProjectRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListProject();
    public function deleteAll($arrayId);
}
