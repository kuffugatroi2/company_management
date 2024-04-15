<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\AbstractRepository;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    protected $model = User::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function all($filter = [])
    {
        $users = $this->getModel()->whereNull('deleted_at');
        if (isset($filter['email'])) {
            $users->where('email', 'like', '%' . $filter['email'] . '%');
        }
        if (isset($filter['is_active']) && in_array($filter['is_active'], $this->model::ARRAYSTATUS)) {
            $users->where('is_active', $filter['is_active']);
        }
        $users = $users->orderby('id', 'desc')->paginate($filter['select-item'] ?? 8);
        return $users;
    }

    public function deleteAll($userIds)
    {
        $this->getModel()->whereIn('id', $userIds)->delete();
        return;
    }
}
