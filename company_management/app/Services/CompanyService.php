<?php

namespace App\Services;

use App\Repositories\Company\CompanyRepositoryInterface;
use Carbon\Carbon;
use Exception;

class CompanyService
{
    protected $companyRepository;
    protected $today;

    public function __construct(CompanyRepositoryInterface $companyRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $companies = $this->companyRepository->all($filter);

            return [
                'status' => 200,
                'companies' => $companies,
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
        $input = $request->only('code', 'name', 'address');

        try {
            $company = $this->companyRepository->store($input);
            return [
                'status' => 200,
                'data' => $company
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
            $company = $this->companyRepository->edit(decrypt($id));
            if (is_null($company)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }
            return [
                'status' => 200,
                'data' => $company
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
        $input = $request->only('code', 'name', 'address');
        $input['updated_at'] = $this->today;

        $company = $this->edit($id);
        if ($company['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        $resultCheck = true;
        $inputCode = $input['code'];
        $inputName = $input['name'];
        $listCompany = $this->getListCompany();
        $checkCode = in_array($inputCode, $listCompany['listCodeCompany']);
        $checkName = in_array($inputName, $listCompany['listNameCompany']);

        if ($checkCode && $inputCode != $company['data']['code']) {
            $resultCheck = false;
            return [
                'status' => 400,
                'checkIsset' => $resultCheck,
                'input' => 'code',
                'message' => "Mã $inputCode đã tồn tại!",
            ];
        } elseif ($checkName && $inputName != $company['data']['name']) {
            $resultCheck = false;
            return [
                'status' => 400,
                'checkIsset' => $resultCheck,
                'input' => 'name',
                'message' => "Công ty $inputName đã tồn tại!",
            ];
        }

        try {
            $company = $this->companyRepository->update($input, decrypt($id));
            return [
                'status' => 200,
                'data' => $company
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
        $company = $this->edit($id);
        if ($company['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        try {
            $company = $this->companyRepository->destroy(decrypt($id));
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
        // Truy cập mảng companyIds trong dữ liệu
        $companyIds = $requestData['listIds'];

        try {
            $this->companyRepository->deleteAll($companyIds);
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

    public function getListCompany()
    {
        return $this->companyRepository->getListCompany();
    }
}
