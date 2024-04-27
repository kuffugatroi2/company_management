<?php

namespace App\Repositories\ProjectPerson;

use App\Repositories\AbstractRepositoryInterface;

interface ProjectPersonRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListProjectPerson();
    public function deleteAll($arrayId);
}
