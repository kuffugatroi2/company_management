<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class RoleFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $parameter = $this->route()->parameters();
        $rules = !empty($parameter) ? '' : 'unique:role,role';

        return [
            'role' => [
                'required',
                $rules,
            ],
        ];
    }

    public function messages()
    {
        $role = $this->input('role');
        return [
            'role.required' => "Bạn chưa nhập vai trò nhân viên",
            'role.unique' => "Vai trò $role đã tồn tại!",
        ];
    }
}
