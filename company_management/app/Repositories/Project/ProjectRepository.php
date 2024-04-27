<?php

namespace App\Repositories\Project;

use App\Models\Project;
use App\Repositories\AbstractRepository;

class ProjectRepository extends AbstractRepository implements ProjectRepositoryInterface
{
    protected $model = Project::class;

    public function __construct()
    {
        parent::__construct($this->model);
    }

    public function all($filter = [])
    {
        $companies = $this->getModel()->whereNull('deleted_at');
        if (isset($filter['code'])) {
            $companies->where('code', 'like', '%' . $filter['code'] . '%');
        }
        if (isset($filter['name'])) {
            $companies->where('name', 'like', '%' . $filter['name'] . '%');
        }
        $companies = $companies->orderby('id', 'desc')->paginate($filter['select-item'] ?? 8);
        return $companies;
    }

    public function getListProject()
    {
        $listCodeProject = $this->getModel()->whereNull('deleted_at')->pluck('code')->toArray();
        $listNameProject = $this->getModel()->whereNull('deleted_at')->pluck('name')->toArray();
        $listProject = $this->getModel()->whereNull('deleted_at')->select('id', 'name')->get();

        return [
            'listCodeProject' => $listCodeProject,
            'listNameProject' => $listNameProject,
            'listProject' => $listProject,
        ];
    }

    public function deleteAll($projectIds)
    {
        $this->getModel()->whereIn('id', $projectIds)->delete();
        return;
    }
}
