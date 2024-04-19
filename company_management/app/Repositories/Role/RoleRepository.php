<?php

namespace App\Repositories\Role;

use App\Models\Role;
use App\Repositories\AbstractRepository;

class RoleRepository extends AbstractRepository implements RoleRepositoryInterface
{
    protected $model = Role::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function all($filter = [])
    {
        $roles = $this->getModel()->whereNull('deleted_at');
        if (isset($filter['role'])) {
            $roles->where('role', 'like', '%' . $filter['role'] . '%');
        }
        $roles = $roles->orderby('id', 'desc')->paginate($filter['select-item'] ?? 8);
        return $roles;
    }

    public function getListRole()
    {
        $listRole = $this->getModel()->whereNull('deleted_at')->pluck('role')->toArray();
        return [
            'listRole' => $listRole,
        ];
    }

    public function deleteAll($roleIds)
    {
        $this->getModel()->whereIn('id', $roleIds)->delete();
        return;
    }
}
