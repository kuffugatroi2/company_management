<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\CompanyFormRequest;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $companies = $this->companyService->index($request);

        $data = [
            'data' => $companies,
        ];

        return view('admin.company.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'action' => route('companies.store'),
            'method' => 'POST',
            'function' => 'create',
        ];

        return view('Admin.company.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyFormRequest $request)
    {
        $company = $this->companyService->store($request);

        if ($company['status'] == 500) {
            return response()->json(['error' => $company['error'], 'status' => $company['status']]);
        }

        return redirect()->route('companies.index')->with(($company['status'] == 200) ? 'message' : 'error', ($company['status'] == 200) ? 'Thêm công ty thành công!' : 'Thêm công ty thất bại!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $company = $this->companyService->edit($id);

        if ($company['status'] == 404 || $company['status'] == 500) {
            return response()->json(['error' => $company['error'], 'status' => $company['status']]);
        }

        $data = [
            'action' => route('companies.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'company' => $company ?? [],
            'departments' => $company['departments'] ?? [],
            'departmentParent' => $company['departmentParent'] ?? [],
            'departmentChild' => $company['departmentChild'] ?? [],
            'listIdDepartmentChild' => $company['listIdDepartmentChild'] ?? [],
        ];
        return view('admin.company.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyFormRequest $request, $id)
    {
        $company = $this->companyService->update($request, $id);

        if (isset($company['checkIsset']) && $company['checkIsset'] == false) {
            return redirect()->back()->with(($company['input'] == 'code') ? 'errorCode' : 'errorName', $company['message']);
        }

        if ($company['status'] == 404 || $company['status'] == 500) {
            return response()->json(['error' => $company['error'], 'status' => $company['status']]);
        }

        return redirect()->route('companies.index')->with(($company['status'] == 200) ? 'message' : 'error', ($company['status'] == 200) ? 'Update công ty thành công!' : 'Update công ty thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $company = $this->companyService->destroy($id);

        if ($company['status'] == 404 || $company['status'] == 500) {
            return response()->json(['error' => $company['error'], 'status' => $company['status']]);
        }

        return redirect()->back()->with(($company['status'] == 200) ? 'message' : 'error', ($company['status'] == 200) ? 'Xóa công ty thành công!' : 'Xóa công ty thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->companyService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }
}
