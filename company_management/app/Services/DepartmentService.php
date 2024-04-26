<?php

namespace App\Services;

use App\Repositories\Department\DepartmentRepositoryInterface;
use Carbon\Carbon;
use Exception;

use function PHPUnit\Framework\isNull;

class DepartmentService
{
    protected $departmetRepository;
    protected $today;

    public function __construct(DepartmentRepositoryInterface $departmetRepository)
    {
        $this->departmetRepository = $departmetRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $departments = $this->departmetRepository->all($filter);
            $departmentParent = $departments->whereNull('parent_id');
            $departmentChild = $departments->whereNotNull('parent_id');

            return [
                'status' => 200,
                'departments' => $departments,
                'departmentParent' => $departmentParent,
                'departmentChild' => $departmentChild,
            ];
        } catch (Exception $exception) {
            return [
                'status' => 500,
                'error' => $exception->getMessage(),
            ];
        }
    }

    public function store($request)
    {
        $input = $request->only('code', 'name', 'company_id');
        $input['company_id'] = decrypt($request['company_id']);

        try {
            $this->departmetRepository->store($input);
            return [
                'status' => 200,
            ];
        } catch (Exception $exception) {
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function update($request, $id)
    {
        $input = $request->except('_token', '_method', 'company_id', 'parent_id');
        $inputDepartment = [];
        $inputId = [];
        $inputId['company_id'] = decrypt($id);
        $inputId['parent_id'] = $request['parent_id'];

        foreach (array_filter($input) as $key => $value) {
            list($prefix, $index) = explode('_', $key);
            $inputDepartment[$index][$prefix] = $value;
        }

        try {
            $this->departmetRepository->update($inputDepartment, $inputId);
            return [
                'status' => 200,
            ];
        } catch (Exception $exception) {
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }
}
