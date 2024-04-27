<?php

namespace App\Services;

use App\Repositories\Person\PersonRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PersonService
{
    protected $personRepository;
    protected $userService;
    protected $today;

    public function __construct(PersonRepositoryInterface $personRepository, UserService $userService)
    {
        $this->personRepository = $personRepository;
        $this->userService = $userService;
        $this->today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
    }

    public function index($request)
    {
        $params = $request->all();
        $filter = array_filter($params);

        try {
            $persons = $this->personRepository->all($filter);

            return [
                'status' => 200,
                'persons' => $persons,
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
        $input = $request->only('user_id', 'company_id', 'full_name', 'gender', 'birthdate', 'phone_number', 'address');

        try {
            $person = $this->personRepository->store($input);
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

    public function edit($id)
    {
        try {
            $person = $this->personRepository->edit(decrypt($id));
            if (is_null($person)) {
                return [
                    'success' => false,
                    'status' => 404,
                    'error' => 'not_found!'
                ];
            }
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

    public function update($request, $id)
    {
        $input = $request->only('company_id', 'full_name', 'gender', 'birthdate', 'phone_number', 'address');
        $input['updated_at'] = $this->today;

        $person = $this->edit($id);
        if ($person['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }

        $resultCheck = true;
        $inputPhoneNumber = $input['phone_number'];
        $listPerson = $this->getListPerson();
        $checkPhoneNumber = in_array($inputPhoneNumber, $listPerson['listPhoneNumber']);

        if ($checkPhoneNumber && $inputPhoneNumber != $person['data']['phone_number']) {
            $resultCheck = false;
            return [
                'status' => 400,
                'checkIsset' => $resultCheck,
                'message' => "Số điện thoại $inputPhoneNumber đã tồn tại!",
            ];
        }

        try {
            $person = $this->personRepository->update($input, decrypt($id));
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
        $person = $this->edit($id);
        if ($person['status'] != 200) {
            return [
                'success' => false,
                'status' => 404,
                'error' => 'not_found!'
            ];
        }
        $userID = encrypt($person['data']->user_id);

        DB::beginTransaction();
        try {
            $this->personRepository->destroy(decrypt($id));
            $this->userService->changeActive($userID);
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
        // Truy cập mảng personIds trong dữ liệu
        $personIds = $requestData['listIds'];

        try {
            $this->personRepository->deleteAll($personIds);
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

    public function getListPerson($id = [])
    {
        return $this->personRepository->getListPerson(decrypt($id));
    }
}
