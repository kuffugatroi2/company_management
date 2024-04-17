<?php

namespace App\Repositories\Company;

use App\Repositories\AbstractRepositoryInterface;

interface CompanyRepositoryInterface extends AbstractRepositoryInterface
{
    public function getListCompany();
    public function deleteAll($arrayId);
}
