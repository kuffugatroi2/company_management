<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectFormRequest extends FormRequest
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
            $rulesCode = 'unique:project,code';
            $rulesName = 'unique:project,name';
        }

        return [
            'code' => [
                'required',
                'string',
                'regex:/^[a-zA-Z0-9_\-@.]+$/',
                $rulesCode,
            ],
            'name' => [
                'required',
                'min:10',
                'max:100',
                $rulesName,
            ],
            'company_id' => [
                'required',
            ],
        ];
    }

    public function messages()
    {
        $code = $this->input('code');
        $name = $this->input('name');
        return [
            'code.required' => "Bạn chưa nhập mã code",
            'code.string' => "Mã code phải ở dạng string",
            'code.unique' => "Mã $code đã tồn tại!",
            'code.regex' => "Mã code không được nhập khoảng trắng",
            'name.required' => "Bạn chưa nhập tên công ty",
            'name.min' => "Tên công ty không được ngắn hơn 10 ký tự",
            'name.max' => "Tên công ty không được ngắn hơn 100 ký tự",
            'name.unique' => "Công ty $name đã tồn tại!",
            'company_id.required' => "Bạn chưa chọn công ty",
        ];
    }
}
