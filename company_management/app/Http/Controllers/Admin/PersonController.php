<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\PersonFormRequest;
use App\Services\CompanyService;
use App\Services\PersonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PersonController extends Controller
{
    protected $personService;
    protected $companyService;

    public function __construct(PersonService $personService ,CompanyService $companyService)
    {
        $this->personService = $personService;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $persons = $this->personService->index($request);

        $data = [
            'data' => $persons,
        ];

        return view('admin.person.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back();
        }

        $companies = $this->companyService->getListCompany();
        $userId = decrypt($request->input('user_id'));

        $data = [
            'action' => route('persons.store'),
            'method' => 'POST',
            'function' => 'create',
            'companies' => $companies ?? [],
            'userId' => $userId ?? null,
        ];

        return view('Admin.person.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PersonFormRequest $request)
    {
        $person = $this->personService->store($request);

        if ($person['status'] == 500) {
            return response()->json(['error' => $person['error'], 'status' => $person['status']]);
        }

        return redirect()->route('persons.index')->with(($person['status'] == 200) ? 'message' : 'error', ($person['status'] == 200) ? 'Thêm nhân viên thành công!' : 'Thêm nhân viên thất bại!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $person = $this->personService->edit($id);

        if ($person['status'] == 404 || $person['status'] == 500) {
            return response()->json(['error' => $person['error'], 'status' => $person['status']]);
        }

        $data = [
            'action' => route('persons.update', $id),
            'method' => 'POST',
            'function' => 'edit',
            'person' => $person ?? [],

        ];
        return view('admin.person.form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PersonFormRequest $request,  $id)
    {
        $person = $this->personService->update($request, $id);

        if (isset($person['checkIsset']) && $person['checkIsset'] == false) {
            return redirect()->back()->with('error', $person['message']);
        }

        if ($person['status'] == 404 || $person['status'] == 500) {
            return response()->json(['error' => $person['error'], 'status' => $person['status']]);
        }

        return redirect()->route('persons.index')->with(($person['status'] == 200) ? 'message' : 'error', ($person['status'] == 200) ? 'Update nhân viên thành công!' : 'Update nhân viên thất bại!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = $this->personService->destroy($id);

        if ($person['status'] == 404 || $person['status'] == 500) {
            return response()->json(['error' => $person['error'], 'status' => $person['status']]);
        }

        return redirect()->back()->with(($person['status'] == 200) ? 'message' : 'error', ($person['status'] == 200) ? 'Xóa nhân viên thành công!' : 'Xóa nhân viên thất bại!');
    }

    public function deleteAll(Request $request)
    {
        $this->personService->deleteAll($request);
        return response()->json(['message' => 'Success', 'status' => '200']);
    }
}
