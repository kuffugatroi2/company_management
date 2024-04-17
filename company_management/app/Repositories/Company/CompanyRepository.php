<?php

namespace App\Repositories\Company;

use App\Models\Company;
use App\Repositories\AbstractRepository;

class CompanyRepository extends AbstractRepository implements CompanyRepositoryInterface
{
    protected $model = Company::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function all($filter = [])
    {
        $companies = $this->getModel()->whereNull('deleted_at');
        if (isset($filter['code'])) {
            $companies->where('code', 'like', '%' . $filter['code'] . '%');
        }
        if (isset($filter['name'])) {
            $companies->where('name', 'like', '%' . $filter['name'] . '%');
        }
        if (isset($filter['address'])) {
            $companies->where('address', 'like', '%' . $filter['address'] . '%');
        }
        $companies = $companies->orderby('id', 'desc')->paginate($filter['select-item'] ?? 8);
        return $companies;
    }

    public function getListCompany()
    {
        $listCodeCompany = $this->getModel()->whereNull('deleted_at')->pluck('code')->toArray();
        $listNameCompany = $this->getModel()->whereNull('deleted_at')->pluck('name')->toArray();
        return [
            'listCodeCompany' => $listCodeCompany,
            'listNameCompany' => $listNameCompany,
        ];
    }

    public function deleteAll($userIds)
    {
        $this->getModel()->whereIn('id', $userIds)->delete();
        return;
    }
}
