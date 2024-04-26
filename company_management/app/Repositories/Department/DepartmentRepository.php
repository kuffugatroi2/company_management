<?php

namespace App\Repositories\Department;

use App\Models\Department;
use App\Repositories\AbstractRepository;
use Carbon\Carbon;

class DepartmentRepository extends AbstractRepository implements DepartmentRepositoryInterface
{
    protected $model = Department::class;
    protected $today;

    public function __construct()
    {
        parent::__construct($this->model);
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function all($filter = [])
    {
        $departments = $this->getModel()->whereNull('deleted_at');

        if (isset($filter['name'])) {
            $departments->where('name', 'like', '%' . $filter['name'] . '%');
        }

        $departments = $departments->orderby('id', 'desc')->paginate($filter['select-item'] ?? 8);

        return $departments;
    }

    public function edit($id)
    {
        return $this->getModel()->where('company_id', $id)->whereNull('deleted_at')->get();
    }

    public function update($request, $inputId)
    {
        $index = 0;
        $departments = $this->edit($inputId['company_id']);
        if (count($request) == count($departments)) {
            foreach ($request as $value) {
                $currentDepartment = $departments[$index];
                if ($currentDepartment->id == $value['id']) {
                    $this->getModel()->where('id', $currentDepartment->id)->update(['code' => $value['code'], 'name' => $value['name']]);
                }
                $index++;
            }
        } elseif (count($request) > count($departments)) {
            foreach ($request as $key => $value) {
                $currentDepartment = $departments[$index];
                if ($currentDepartment->id == $value['id']) {
                    $this->getModel()->where('id', $currentDepartment->id)->update(['code' => $value['code'], 'name' => $value['name']]);
                }
                unset($request[$key]);
                if ($index == (count($departments) - 1)) {
                    break;
                }
                $index++;
            }
            $requestNew = reset($request);
            $requestNew['company_id'] = $inputId['company_id'];
            if (!is_null($inputId['parent_id'])) {
                $requestNew['parent_id'] = $inputId['parent_id'];
            }
            $this->store($requestNew);
        } elseif (count($request) < count($departments)) {
            $listIdInput = array_column($request, 'id');
            foreach ($request as $value) {
                foreach ($departments as $department) {
                    if (in_array($department->id, $listIdInput)) {
                        if ($department->id == $value['id']) {
                            $this->getModel()->where('id', $department->id)->update(['code' => $value['code'], 'name' => $value['name']]);
                        }
                    } else {
                        $department->delete();
                    }

                }
            }
        }
        return;
    }
}
