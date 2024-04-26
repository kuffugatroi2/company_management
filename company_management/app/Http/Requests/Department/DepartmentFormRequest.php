<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentFormRequest extends FormRequest
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
        if (!empty($parameter)) {
            $rulesCode = '';
            $rulesName = '';
        } else {
            $rulesCode = 'unique:department,code';
            $rulesName = 'unique:department,name';
        }
        return [
            'code' => [
                'string',
                'regex:/^[a-zA-Z0-9_\-@.]+$/',
                $rulesCode,
            ],
            'name' => [
                'min:10',
                'max:100',
                $rulesName,
            ],
        ];
    }

    public function messages()
    {
        $code = $this->input('code');
        $name = $this->input('name');
        return [
            'code.string' => "Mã code phải ở dạng string",
            'code.unique' => "Mã $code đã tồn tại!",
            'code.regex' => "Mã code không được nhập khoảng trắng",
            'name.min' => "Tên phòng ban không được ngắn hơn 10 ký tự",
            'name.max' => "Tên phòng ban không được ngắn hơn 100 ký tự",
            'name.unique' => "phòng ban $name đã tồn tại!",
        ];
    }
}
