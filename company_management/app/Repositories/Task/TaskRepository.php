<?php

namespace App\Repositories\Task;

use App\Models\Task;
use App\Repositories\AbstractRepository;

class TaskRepository extends AbstractRepository implements TaskRepositoryInterface
{
    protected $model = Task::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function all($filter = [])
    {
        $companies = $this->getModel()->whereNull('deleted_at');
        if (isset($filter['project_id'])) {
            $companies->where('project_id', $filter['project_id']);
        }
        if (isset($filter['person_id'])) {
            $companies->where('person_id', $filter['person_id']);
        }
        if (isset($filter['priovity'])) {
            $companies->where('priovity', $filter['priovity']);
        }
        if (isset($filter['status'])) {
            $companies->where('status', $filter['status']);
        }
        if (isset($filter['name'])) {
            $companies->where('name', 'like', '%' . $filter['name'] . '%');
        }
        $companies = $companies->orderby('id', 'desc')->paginate($filter['select-item'] ?? 8);
        return $companies;
    }

    public function getListTask()
    {
        $listNameTask = $this->getModel()->whereNull('deleted_at')->pluck('name')->toArray();

        return [
            'listNameTask' => $listNameTask,
        ];
    }

    public function deleteAll($taskIds)
    {
        $this->getModel()->whereIn('id', $taskIds)->delete();
        return;
    }
}
