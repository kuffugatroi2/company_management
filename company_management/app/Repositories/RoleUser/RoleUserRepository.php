<?php

namespace App\Repositories\RoleUser;

use App\Models\Role;
use App\Models\RoleUser;
use App\Repositories\AbstractRepository;

class RoleUserRepository extends AbstractRepository implements RoleUserRepositoryInterface
{
    protected $model = RoleUser::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function store($request)
    {
        foreach ($request as $value) {
            $this->getModel()->create($value);
        }
        return;
    }

    public function edit($id)
    {
        return $this->getModel()->where('user_id', $id)->whereNull('deleted_at')->get();
    }

    public function update($request, $roleUser)
    {
        $index = 0;
        if (count($request) == count($roleUser)) {
            foreach ($request as $value) {
                $currentRoleUser = $roleUser[$index];
                $this->getModel()->where('id', $currentRoleUser['id'])->update(['role_id' => $value['role_id']]);
                $index++;
            }
        } elseif (count($request) > count($roleUser)) {
            foreach ($request as $key => $value) {
                $currentRoleUser = $roleUser[$index];
                $this->getModel()->where('id', $currentRoleUser['id'])->update(['role_id' => $value['role_id']]);
                unset($request[$key]);
                if ($index == (count($roleUser) - 1)) {
                    break;
                }
                $index++;
            }
            $this->store($request);
        } elseif (count($request) < count($roleUser)) {
            foreach ($request as $key => $value) {
                $currentRoleUser = $roleUser[$index];
                $this->getModel()->where('id', $currentRoleUser['id'])->update(['role_id' => $value['role_id']]);
                if ($index == (count($request) - 1)) {
                    break;
                }
                $index++;
            }
            for ($i = count($request); $i < count($roleUser); $i++) {
                $roleUserToDelete = $roleUser[$i];
                $roleUserToDelete->delete();
            }
        }
        return;
    }
}
