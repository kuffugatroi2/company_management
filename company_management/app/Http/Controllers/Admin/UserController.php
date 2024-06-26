<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserFormRequest;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $roleService;

    public function __construct(UserService $userService, RoleService $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = $this->userService->index($request);

        $data = [
            'data' => $users,
        ];

        return view('Admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roleService->getListRole();

        $data = [
            'action' => route('users.store'),
            'method' => 'POST',
            'function' => 'create',
            'roles' => $roles['getListRole'] ?? [],
        ];

        return view('Admin.user.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        $user = $this->userService->store($request);

        if (isset($user['checkIsset']) && $user['checkIsset'] == false) {
            return redirect()->back()->with('errorRole', $user['message']);
        }

        if ($user['status'] == 500) {
            return response()->json(['error' => $user['error'], 'status' => $user['status']]);
        }

        return redirect()->route('users.index')->with(($user['status'] == 200) ? 'message' : 'error', ($user['status'] == 200) ? 'Thêm user thành công!' : 'Thêm user thất bại!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = $this->userService->edit($id);

        $data = [
            'user' => $user ?? [],
        ];

        return view('admin.user.detail-user', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = $this->userService->edit($id);
        $roles = $this->roleService->getListRole();

        if ($user['status'] == 404 || $user['status'] == 500) {
            return response()->json(['error' => $user['error'], 'status' => $user['status']]);
        }

        $data = [
            'action' => route('users.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'user' => $user ?? [],
            'roles' => $roles['getListRole'] ?? [],
        ];

        return view('admin.user.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, $id)
    {
        $user = $this->userService->update($request, $id);

        if (isset($user['checkIsset']) && $user['checkIsset'] == false) {
            return redirect()->back()->with('errorRole', $user['message']);
        }

        if ($user['status'] == 404 || $user['status'] == 500) {
            return response()->json(['error' => $user['error'], 'status' => $user['status']]);
        }

        return redirect()->route('users.index')->with(($user['status'] == 200) ? 'message' : 'error', ($user['status'] == 200) ? 'Update user thành công!' : 'Update user thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->userService->destroy($id);

        if ($user['status'] == 404 || $user['status'] == 500) {
            return response()->json(['error' => $user['error'], 'status' => $user['status']]);
        }

        return redirect()->back()->with(($user['status'] == 200) ? 'message' : 'error', ($user['status'] == 200) ? 'Xóa user thành công!' : 'Xóa user thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->userService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }
}
