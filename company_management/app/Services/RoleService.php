<?php

namespace App\Services;

use App\Repositories\Role\RoleRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class RoleService
{
    protected $roleRepository;
    protected $today;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $roles = $this->roleRepository->all($filter);

            return [
                'status' => 200,
                'roles' => $roles,
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
        $input = $request->only('role', 'description');

        try {
            $role = $this->roleRepository->store($input);
            return [
                'status' => 200,
                'data' => $role
            ];
        } catch (Exception $exception) {
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function edit($id)
    {
        try {
            $role = $this->roleRepository->edit(decrypt($id));
            if (is_null($role)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }
            return [
                'status' => 200,
                'data' => $role
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
        $input = $request->only('role', 'description');
        $input['updated_at'] = $this->today;

        $role = $this->edit($id);
        if ($role['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        $resultCheck = true;
        $inputRole = $input['role'];
        $listRole = $this->getListRole();
        $checkRole = in_array($inputRole, $listRole['listRole']);

        if ($checkRole && $inputRole != $role['data']['role']) {
            $resultCheck = false;
            return [
                'status' => 400,
                'checkIsset' => $resultCheck,
                'message' => "Vai trò $inputRole đã tồn tại!",
            ];
        }

        try {
            $role = $this->roleRepository->update($input, decrypt($id));
            return [
                'status' => 200,
                'data' => $role
            ];
        } catch (Exception $exception) {
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function destroy($id)
    {
        $role = $this->edit($id);
        if ($role['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $role = $this->roleRepository->destroy(decrypt($id));
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

    public function deleteAll($request)
    {
        // Lấy mảng dữ liệu từ phần thân yêu cầu
        $requestData = $request->json()->all();
        // Truy cập mảng roleIds trong dữ liệu
        $roleIds = $requestData['listIds'];

        try {
            $this->roleRepository->deleteAll($roleIds);
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

    public function getListRole()
    {
        return $this->roleRepository->getListRole();
    }
}
