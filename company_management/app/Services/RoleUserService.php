<?php

namespace App\Services;

use App\Repositories\RoleUser\RoleUserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class RoleUserService
{
    protected $roleUserRepository;
    protected $today;

    public function __construct(RoleUserRepositoryInterface $roleUserRepository)
    {
        $this->roleUserRepository = $roleUserRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function store($request)
    {
        try {
            $this->roleUserRepository->store($request);
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

    public function edit($id)
    {
        try {
            $roleUser = $this->roleUserRepository->edit($id);
            if (is_null($roleUser)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }
            return [
                'status' => 200,
                'data' => $roleUser
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
        $roleUser = $this->edit($id);
        if ($roleUser['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $role = $this->roleUserRepository->update($request, $roleUser['data']);
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
