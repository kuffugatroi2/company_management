<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentFormRequest;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $departments = $this->departmentService->index($request);
        
        $data = [
            'data' => $departments,
        ];

        return view('admin.department.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentFormRequest $request)
    {
        $department = $this->departmentService->store($request);

        if ($department['status'] == 500) {
            return response()->json(['error' => $department['error'], 'status' => $department['status']]);
        }

        return redirect()->route('companies.index')->with(($department['status'] == 200) ? 'message' : 'error', ($department['status'] == 200) ? 'Thêm phòng ban thành công!' : 'Thêm phòng ban thất bại!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentFormRequest $request, $id)
    {
        $department = $this->departmentService->update($request, $id);

        if (isset($department['checkIsset']) && $department['checkIsset'] == false) {
            return redirect()->back()->with(($department['input'] == 'code') ? 'errorCode' : 'errorName', $department['message']);
        }

        if ($department['status'] == 404 || $department['status'] == 500) {
            return response()->json(['error' => $department['error'], 'status' => $department['status']]);
        }

        return redirect()->route('companies.index')->with(($department['status'] == 200) ? 'message' : 'error', ($department['status'] == 200) ? 'Update phòng ban thành công!' : 'Update phòng ban thất bại!');
    }
}
