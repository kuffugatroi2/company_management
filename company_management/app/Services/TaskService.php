<?php

namespace App\Services;

use App\Repositories\Task\TaskRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class TaskService
{
    protected $taskRepository;
    protected $today;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $tasks = $this->taskRepository->all($filter);

            return [
                'status' => 200,
                'tasks' => $tasks,
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
        $input = $request->only('project_id', 'person_id', 'name', 'description', 'start_time', 'end_time', 'priority', 'status');
        $input['project_id'] = decrypt($request['project_id']);

        try {
            $this->taskRepository->store(array_filter($input));

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
            $task = $this->taskRepository->edit(decrypt($id));

            if (is_null($task)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }

            return [
                'status' => 200,
                'data' => $task,
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
        $input = $request->only('project_id', 'person_id', 'name', 'description', 'start_time', 'end_time', 'priority', 'status');
        $input['project_id'] = decrypt($request['project_id']);
        $input['updated_at'] = $this->today;
        $task = $this->edit($id);
        if ($task['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        $resultCheck = true;
        $inputNumber = $input['name'];
        $listTask = $this->getListTask();

        $checkName = in_array($inputNumber, $listTask['listNameTask']);

        if ($checkName && $inputNumber != $task['data']['name']) {
            $resultCheck = false;
            return [
                'status' => 400,
                'checkIsset' => $resultCheck,
                'message' => "nhiệm vụ $inputNumber đã tồn tại!",
            ];
        }

        try {
            $person = $this->taskRepository->update($input, decrypt($id));
            return [
                'status' => 200,
                'data' => $person
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
        $task = $this->edit($id);
        if ($task['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $this->taskRepository->destroy(decrypt($id));

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
        // Truy cập mảng taskIds trong dữ liệu
        $taskIds = $requestData['listIds'];

        try {
            $this->taskRepository->deleteAll($taskIds);
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

    public function getListTask()
    {
        return $this->taskRepository->getListTask();
    }
}
