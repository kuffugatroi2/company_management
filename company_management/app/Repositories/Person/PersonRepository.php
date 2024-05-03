<?php

namespace App\Repositories\Person;

use App\Models\Person;
use App\Repositories\AbstractRepository;

class PersonRepository extends AbstractRepository implements PersonRepositoryInterface
{
    protected $model = Person::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function all($filter = [])
    {
        $persons = $this->getModel()->whereNull('deleted_at');
        if (isset($filter['full_name'])) {
            $persons->where('full_name', 'like', '%' . $filter['full_name'] . '%');
        }
        if (isset($filter['phone_number'])) {
            $persons->where('phone_number', 'like', '%' . $filter['phone_number'] . '%');
        }
        if (isset($filter['address'])) {
            $persons->where('address', 'like', '%' . $filter['address'] . '%');
        }
        $persons = $persons->orderby('id', 'desc')->paginate($filter['select-item'] ?? 8);
        return $persons;
    }

    public function getListPerson()
    {
        $listPhoneNumber = $this->getModel()->whereNull('deleted_at')->pluck('phone_number')->toArray();

        return [
            'listPhoneNumber' => $listPhoneNumber,
        ];
    }

    public function getListPersonByIdCompany($id)
    {
        return $this->getModel()->where('company_id', $id)->whereNull('deleted_at')->get();
    }


    public function getPerson()
    {
        $listPerson = $this->getModel()->whereNull('deleted_at')->select('id', 'full_name')->get();
        return [
            'listPerson' => $listPerson,
        ];
    }

    public function deleteAll($personIds)
    {
        $this->getModel()->whereIn('id', $personIds)->delete();
        return;
    }
}
