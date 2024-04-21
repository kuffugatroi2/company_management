<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class UserService
{
    protected $userRepository;
    protected $roleService;
    protected $roleUserService;
    protected $today;

    public function __construct(UserRepositoryInterface $userRepository, RoleService $roleService, RoleUserService $roleUserService)
    {
        $this->userRepository = $userRepository;
        $this->roleService = $roleService;
        $this->roleUserService = $roleUserService;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $users = $this->userRepository->all($filter);
            $users->load('person');

            return [
                'status' => 200,
                'users' => $users,
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
        $input = $request->only('email', 'password', 'is_active');
        $inputRoles = $request->except('email', 'password', 'is_active', '_token');

        DB::beginTransaction();
        try {
            $resultCheck = true;
            if (empty($inputRoles)) {
                $resultCheck = false;
                return [
                    'status' => 400,
                    'checkIsset' => $resultCheck,
                    'message' => "Phải chọn ít nhất một vai trò",
                ];
            }

            $user = $this->userRepository->store($input);
            $listIdRole = $this->getArrayInsertRoleUser($inputRoles, $user->id);
            $this->roleUserService->store($listIdRole);

            DB::commit();
            return [
                'status' => 200,
                'data' => $user
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function edit($id)
    {
        try {
            $user = $this->userRepository->edit(decrypt($id));
            if (is_null($user)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }

            $listRole = $user->roles->map(function ($role) {
                if (is_null($role->pivot->deleted_at)) {
                    return $role->id;
                }
            })->toArray();
            $listRole = array_values(array_filter($listRole));

            return [
                'status' => 200,
                'data' => $user,
                'listRole' => $listRole ?? [],
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
        $input = $request->only('password', 'is_active');
        $input['updated_at'] = $this->today;
        $inputRoles = $request->except('email', 'password', 'is_active', '_token', '_method');

        $user = $this->edit($id);

        if ($user['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        DB::beginTransaction();
        try {
            $resultCheck = true;
            if (empty($inputRoles)) {
                $resultCheck = false;
                return [
                    'status' => 400,
                    'checkIsset' => $resultCheck,
                    'message' => "Phải chọn ít nhất một vai trò",
                ];
            }

            $this->userRepository->update($input, decrypt($id));
            $listIdRole = $this->getArrayInsertRoleUser($inputRoles, $user['data']->id);
            $this->roleUserService->update($listIdRole, $user['data']->id);

            DB::commit();
            return [
                'status' => 200,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function destroy($id)
    {
        $user = $this->edit($id);
        if ($user['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $user = $this->userRepository->destroy(decrypt($id));
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
        // Truy cập mảng UserIds trong dữ liệu
        $userIds = $requestData['listIds'];

        try {
            $this->userRepository->deleteAll($userIds);
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

    public function changeActive($id)
    {
        $user = $this->edit($id);
        if ($user['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $user = $this->userRepository->changeActive(decrypt($id), $user['data']->is_active);
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

    public function getArrayInsertRoleUser($inputRoles, $userId)
    {
        $listRole = $this->roleService->getListRole();
        $arrayInputRole = [];

        $listIdRole = $listRole['getListRole']->map(function ($role) use ($inputRoles, $listRole, $arrayInputRole, $userId) {
            foreach ($inputRoles as $key => $value) {
                if (in_array($key, $listRole['listRole'])) {
                    array_push($arrayInputRole, $key);
                }
            }
            if (in_array($role->role, $arrayInputRole)) {
                return [
                    'role_id' => $role->id,
                    'user_id' => $userId,
                ];
            }
        })->filter();
        return $listIdRole;
    }
}
