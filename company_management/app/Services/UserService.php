<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;

class UserService
{
    protected $userRepository;
    protected $today;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $users = $this->userRepository->all($filter);

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

        try {
            $user = $this->userRepository->store($input);
            return [
                'status' => 200,
                'data' => $user
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
            $user = $this->userRepository->edit(decrypt($id));
            if (is_null($user)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }
            return [
                'status' => 200,
                'data' => $user
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

        $user = $this->edit($id);
        if ($user['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $brand = $this->userRepository->update($input, decrypt($id));
            return [
                'status' => 200,
                'data' => $brand
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
        // Truy cập mảng brandIds trong dữ liệu
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
}
