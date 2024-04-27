<?php

namespace App\Services;

use App\Repositories\Project\ProjectRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class ProjectService
{
    protected $projectRepository;
    protected $projectPersonService;
    protected $today;

    public function __construct(ProjectRepositoryInterface $projectRepository, ProjectPersonService $projectPersonService)
    {
        $this->projectRepository = $projectRepository;
        $this->projectPersonService = $projectPersonService;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $projects = $this->projectRepository->all($filter);

            return [
                'status' => 200,
                'projects' => $projects,
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
        $input = $request->only('code', 'name', 'description', 'company_id');
        $input['company_id'] = decrypt($request['company_id']);
        $inputPerson = $request->except('code', 'name', 'description', 'company_id', '_token');
        $listPersonId = [];

        foreach (array_filter($inputPerson) as $key => $value) {
            list($prefix, $index) = explode('-', $key);
            $listPersonId[$index][$prefix] = $value;
        }

        DB::beginTransaction();
        try {
            $project = $this->projectRepository->store($input);
            $projectId = $project->id;

            if (!empty($listPersonId)) {
                $listProjectPerson = array_map(function ($item) use ($projectId) {
                    return array_merge($item, ["project_id" => $projectId]);
                }, $listPersonId);
                $this->projectPersonService->store($listProjectPerson);
            }

            DB::commit();
            return [
                'status' => 200,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function edit($id)
    {
        try {
            $project = $this->projectRepository->edit(decrypt($id));

            if (is_null($project)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }

            return [
                'status' => 200,
                'data' => $project,
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
        $input = $request->only('code', 'name', 'description', 'company_id');
        $input['company_id'] = decrypt($request['company_id']);
        $input['updated_at'] = $this->today;
        $inputPerson = $request->except('code', 'name', 'description', 'company_id', '_token', '_method');
        $listPersonId = [];

        foreach (array_filter($inputPerson) as $key => $value) {
            list($prefix, $index) = explode('-', $key);
            $listPersonId[$index][$prefix] = $value;
        }

        $project = $this->edit($id);
        if ($project['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        $resultCheck = true;
        $inputCode = $input['code'];
        $inputName = $input['name'];
        $listProject = $this->getListProject();
        $checkCode = in_array($inputCode, $listProject['listCodeProject']);
        $checkName = in_array($inputName, $listProject['listNameProject']);

        if ($checkCode && $inputCode != $project['data']['code']) {
            $resultCheck = false;
            return [
                'status' => 400,
                'checkIsset' => $resultCheck,
                'input' => 'code',
                'message' => "Mã $inputCode đã tồn tại!",
            ];
        } elseif ($checkName && $inputName != $project['data']['name']) {
            $resultCheck = false;
            return [
                'status' => 400,
                'checkIsset' => $resultCheck,
                'input' => 'name',
                'message' => "Dự án $inputName đã tồn tại!",
            ];
        }

        DB::beginTransaction();
        try {

            $companyIdNew = decrypt($request['company_id']);
            if ($project['data']->company_id == $companyIdNew) {
                $projectId = decrypt($id);
                $this->projectRepository->update($input, $projectId);

                if (!empty($listPersonId)) {
                    $listProjectPerson = array_map(function ($item) use ($projectId) {
                        return array_merge($item, ["project_id" => $projectId]);
                    }, $listPersonId);
                    $this->projectPersonService->update($listProjectPerson, $project['data']->id);
                }
            } else {
                // Kiểm tra company mới
                $projectId = decrypt($id);
                $this->projectRepository->update($input, $projectId);
                if (!empty($listPersonId)) {
                    $listProjectPerson = array_map(function ($item) use ($projectId) {
                        return array_merge($item, ["project_id" => $projectId]);
                    }, $listPersonId);
                    $this->projectPersonService->destroy($projectId);
                    $this->projectPersonService->store($listProjectPerson);
                } else {
                    $this->projectPersonService->destroy($projectId);
                }
            }



            DB::commit();
            return [
                'status' => 200,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function destroy($id)
    {
        $project = $this->edit($id);
        if ($project['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        DB::beginTransaction();
        try {
            $projectId = decrypt($id);
            $this->projectRepository->destroy($projectId);
            $this->projectPersonService->destroy($projectId);

            DB::commit();
            return [
                'status' => 200,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
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
        // Truy cập mảng projectIds trong dữ liệu
        $projectIds = $requestData['listIds'];

        DB::beginTransaction();
        try {
            $this->projectRepository->deleteAll($projectIds);
            $this->projectPersonService->deleteAll($projectIds);
            DB::commit();
            return [
                'status' => 200,
            ];
        } catch (Exception $exception) {
            DB::rollBack();
            return [
                'status' => 500,
                'error' => $exception->getMessage()
            ];
        }
    }

    public function getListProject()
    {
        return $this->projectRepository->getListProject();
    }
}
