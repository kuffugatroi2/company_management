<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectFormRequest;
use App\Services\ProjectService;
use App\Services\CompanyService;
use App\Services\PersonService;
use App\Services\ProjectPersonService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;
    protected $companyService;
    protected $personService;
    protected $projectPersonService;

    public function __construct(ProjectService $projectService, CompanyService $companyService, PersonService $personService, ProjectPersonService $projectPersonService)
    {
        $this->projectService = $projectService;
        $this->companyService = $companyService;
        $this->personService = $personService;
        $this->projectPersonService = $projectPersonService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $projects = $this->projectService->index($request);

        $data = [
            'data' => $projects,
        ];

        return view('admin.project.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = $this->companyService->getListCompany();

        $data = [
            'action' => route('projects.store'),
            'method' => 'POST',
            'function' => 'create',
            'companies' => $companies['listCompany'] ?? [],
        ];

        return view('Admin.project.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectFormRequest $request)
    {
        $project = $this->projectService->store($request);

        if ($project['status'] == 500) {
            return response()->json(['error' => $project['error'], 'status' => $project['status']]);
        }

        return redirect()->route('projects.index')->with(($project['status'] == 200) ? 'message' : 'error', ($project['status'] == 200) ? 'Thêm dự án thành công!' : 'Thêm dự án thất bại!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = $this->projectService->edit($id);
        $companies = $this->companyService->getListCompany();

        if ($project['status'] == 404 || $project['status'] == 500) {
            return response()->json(['error' => $project['error'], 'status' => $project['status']]);
        }

        $data = [
            'action' => route('projects.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'project' => $project ?? [],
            'companies' => $companies['listCompany'] ?? [],

        ];
        return view('admin.project.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectFormRequest $request, $id)
    {
        $project = $this->projectService->update($request, $id);

        if (isset($project['checkIsset']) && $project['checkIsset'] == false) {
            return redirect()->back()->with(($project['input'] == 'code') ? 'errorCode' : 'errorName', $project['message']);
        }

        if ($project['status'] == 404 || $project['status'] == 500) {
            return response()->json(['error' => $project['error'], 'status' => $project['status']]);
        }

        return redirect()->route('projects.index')->with(($project['status'] == 200) ? 'message' : 'error', ($project['status'] == 200) ? 'Update dự án thành công!' : 'Update dự án thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project = $this->projectService->destroy($id);

        if ($project['status'] == 404 || $project['status'] == 500) {
            return response()->json(['error' => $project['error'], 'status' => $project['status']]);
        }

        return redirect()->back()->with(($project['status'] == 200) ? 'message' : 'error', ($project['status'] == 200) ? 'Xóa dự án thành công!' : 'Xóa dự án thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->projectService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }

    public function getPerson($idCompany, $idProject)
    {
        $listPersonId = $this->projectPersonService->getListProjectPerson();
        $persons = $this->personService->getListPersonByIdCompany($idCompany);

        foreach ($persons as $key => $person) {
            if (!$person->projects->isEmpty()) {
                foreach ($person->projects as $value) {
                    if (in_array($person->id, $listPersonId['listUserid']) && $value->pivot->project_id == $idProject) {
                        echo "<input type='checkbox' name='person_id-$key' id='person_id' value='" . $person->id . "' data-parsley-mincheck='2' class='flat mt-2' checked/> $person->full_name";
                        echo "<br>";
                    }
                    else {
                        echo "<input type='checkbox' name='person_id-$key' id='person_id' value='" . $person->id . "' data-parsley-mincheck='2' class='flat mt-2'/> $person->full_name";
                        echo "<br>";
                    }
                }
            } else {
                echo "<input type='checkbox' name='person_id-$key' id='person_id' value='" . $person->id . "' data-parsley-mincheck='2' class='flat mt-2'/> $person->full_name";
                echo "<br>";
            }
        }
    }
}
