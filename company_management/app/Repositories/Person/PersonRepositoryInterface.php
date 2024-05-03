<?php

namespace App\Repositories\Person;

use App\Repositories\AbstractRepositoryInterface;

interface PersonRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListPerson();
    public function getListPersonByIdCompany($id);
    public function getPerson();
    public function deleteAll($arrayId);
}
