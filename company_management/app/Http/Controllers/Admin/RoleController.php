<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleFormRequest;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService )
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $roles = $this->roleService->index($request);

        $data = [
            'data' => $roles,
        ];

        return view('admin.role.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'action' => route('roles.store'),
            'method' => 'POST',
            'function' => 'create',
        ];

        return view('Admin.role.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleFormRequest $request)
    {
        $role = $this->roleService->store($request);

        if ($role['status'] == 500) {
            return response()->json(['error' => $role['error'], 'status' => $role['status']]);
        }

        return redirect()->route('roles.index')->with(($role['status'] == 200) ? 'message' : 'error', ($role['status'] == 200) ? 'Thêm vai trò thành công!' : 'Thêm vai trò thất bại!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = $this->roleService->edit($id);

        if ($role['status'] == 404 || $role['status'] == 500) {
            return response()->json(['error' => $role['error'], 'status' => $role['status']]);
        }

        $data = [
            'action' => route('roles.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'role' => $role ?? [],

        ];
        return view('admin.role.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleFormRequest $request, $id)
    {
        $role = $this->roleService->update($request, $id);

        if (isset($role['checkIsset']) && $role['checkIsset'] == false) {
            return redirect()->back()->with('error', $role['message']);
        }

        if ($role['status'] == 404 || $role['status'] == 500) {
            return response()->json(['error' => $role['error'], 'status' => $role['status']]);
        }

        return redirect()->route('roles.index')->with(($role['status'] == 200) ? 'message' : 'error', ($role['status'] == 200) ? 'Update vai trò thành công!' : 'Update vai trò thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = $this->roleService->destroy($id);

        if ($role['status'] == 404 || $role['status'] == 500) {
            return response()->json(['error' => $role['error'], 'status' => $role['status']]);
        }

        return redirect()->back()->with(($role['status'] == 200) ? 'message' : 'error', ($role['status'] == 200) ? 'Xóa vai trò thành công!' : 'Xóa vai trò thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->roleService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }
}
