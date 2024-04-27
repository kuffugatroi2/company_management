<?php

namespace App\Repositories\ProjectPerson;

use App\Models\ProjectPerson;
use App\Repositories\AbstractRepository;
use Carbon\Carbon;

class ProjectPersonRepository extends AbstractRepository implements ProjectPersonRepositoryInterface
{
    protected $model = ProjectPerson::class;
    protected $today;

    public function __construct()
    {
        parent::__construct($this->model);
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
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
        return $this->getModel()->where('project_id', $id)->whereNull('deleted_at')->get();
    }

    public function update($request, $projectPerson)
    {
        $index = 0;
        if (count($request) == count($projectPerson)) {
            foreach ($request as $value) {
                $currentProjectPerson = $projectPerson[$index];
                $this->getModel()->where('id', $currentProjectPerson['id'])->update(['person_id' => $value['person_id'], 'project_id' => $value['project_id'], 'updated_at' => $this->today]);
                $index++;
            }
        } elseif (count($request) > count($projectPerson)) {
            foreach ($request as $key => $value) {
                $currentProjectPerson = $projectPerson[$index];
                $this->getModel()->where('id', $currentProjectPerson['id'])->update(['person_id' => $value['person_id'], 'project_id' => $value['project_id'], 'updated_at' => $this->today]);
                unset($request[$key]);
                if ($index == (count($projectPerson) - 1)) {
                    break;
                }
                $index++;
            }
            $this->store($request);
        } elseif (count($request) < count($projectPerson)) {
            foreach ($request as $key => $value) {
                $currentProjectPerson = $projectPerson[$index];
                $this->getModel()->where('id', $currentProjectPerson['id'])->update(['person_id' => $value['person_id'], 'project_id' => $value['project_id'], 'updated_at' => $this->today]);
                if ($index == (count($request) - 1)) {
                    break;
                }
                $index++;
            }
            for ($i = count($request); $i < count($projectPerson); $i++) {
                $roleUserToDelete = $projectPerson[$i];
                $roleUserToDelete->delete();
            }
        }
        return;
    }

    public function destroy($request)
    {
        foreach ($request as $value) {
            $value->delete();
        }
        return;
    }

    public function deleteAll($projectIds)
    {
        $this->getModel()->whereIn('project_id', $projectIds)->delete();
        return;
    }

    public function getListProjectPerson()
    {
        $listUserid = $this->getModel()->whereNull('deleted_at')->pluck('person_id')->toArray();

        return [
            'listUserid' => $listUserid,
        ];
    }
}
