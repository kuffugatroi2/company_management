<?php

namespace App\Services;

use App\Repositories\ProjectPerson\ProjectPersonRepositoryInterface;
use Carbon\Carbon;
use Exception;

class ProjectPersonService
{
    protected $projectPersonRepository;
    protected $today;

    public function __construct(ProjectPersonRepositoryInterface $projectPersonRepository)
    {
        $this->projectPersonRepository = $projectPersonRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function store($request)
    {
        try {
            $this->projectPersonRepository->store($request);
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
            $project = $this->projectPersonRepository->edit($id);
            if (is_null($project)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }
            return [
                'status' => 200,
                'data' => $project
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
        $project = $this->edit($id);
        if ($project['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $this->projectPersonRepository->update($request, $project['data']);
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

        try {
            $this->projectPersonRepository->destroy($project['data']);
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

    public function deleteAll($projectIds)
    {
        try {
            $this->projectPersonRepository->deleteAll($projectIds);
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

    public function getListProjectPerson()
    {
        return $this->projectPersonRepository->getListProjectPerson();
    }
}
