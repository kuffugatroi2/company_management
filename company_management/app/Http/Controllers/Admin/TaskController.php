<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelExports;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskFormRequest;
use App\Services\TaskService;
use App\Services\ProjectService;
use App\Services\CompanyService;
use App\Services\PersonService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TaskController extends Controller
{
    protected $taskService;
    protected $projectService;
    protected $companyService;
    protected $personService;

    public function __construct(TaskService $taskService, ProjectService $projectService, CompanyService $companyService, PersonService $personService)
    {
        $this->taskService = $taskService;
        $this->projectService = $projectService;
        $this->companyService = $companyService;
        $this->personService = $personService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = $this->taskService->index($request);
        $projects = $this->projectService->getListProject();
        $persons = $this->personService->getPerson();

        $data = [
            'data' => $tasks ?? [],
            'projects' => $projects['listProject'] ?? [],
            'persons' => $persons['listPerson'] ?? [],
        ];

        return view('admin.task.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = $this->projectService->getListProject();

        $data = [
            'action' => route('tasks.store'),
            'method' => 'POST',
            'function' => 'create',
            'projects' => $projects['listProject'] ?? [],
        ];

        return view('Admin.task.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskFormRequest $request)
    {
        $task = $this->taskService->store($request);

        if ($task['status'] == 500) {
            return response()->json(['error' => $task['error'], 'status' => $task['status']]);
        }

        return redirect()->route('tasks.index')->with(($task['status'] == 200) ? 'message' : 'error', ($task['status'] == 200) ? 'Thêm nhiệm vụ thành công!' : 'Thêm nhiệm vụ thất bại!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $task = $this->taskService->edit($id);

        if ($task['status'] == 404 || $task['status'] == 500) {
            return response()->json(['error' => $task['error'], 'status' => $task['status']]);
        }

        $data = [
            'action' => route('tasks.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'task' => $task ?? [],
        ];
        return view('admin.task.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskFormRequest $request, $id)
    {
        $task = $this->taskService->update($request, $id);

        if (isset($task['checkIsset']) && $task['checkIsset'] == false) {
            return redirect()->back()->with('error', $task['message']);
        }

        if ($task['status'] == 404 || $task['status'] == 500) {
            return response()->json(['error' => $task['error'], 'status' => $task['status']]);
        }

        return redirect()->route('tasks.index')->with(($task['status'] == 200) ? 'message' : 'error', ($task['status'] == 200) ? 'Update nhiệm vụ thành công!' : 'Update nhiệm vụ thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = $this->taskService->destroy($id);

        if ($task['status'] == 404 || $task['status'] == 500) {
            return response()->json(['error' => $task['error'], 'status' => $task['status']]);
        }

        return redirect()->back()->with(($task['status'] == 200) ? 'message' : 'error', ($task['status'] == 200) ? 'Xóa nhiệm vụ thành công!' : 'Xóa nhiệm vụ thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->taskService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }

    public function getPerson($idProject)
    {
        $projects = $this->projectService->edit($idProject);
        $persons = $projects['data']->persons;
        foreach ($persons as $person) {
            echo " <option value='" . $person->id . "'>" . $person->full_name . "</option>";
        }
    }

    public function export()
    {
        return Excel::download(new ExcelExports, 'tasks.xlsx');
    }
}
