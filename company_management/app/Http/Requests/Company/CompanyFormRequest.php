<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class CompanyFormRequest extends FormRequest
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
            $rulesCode = 'unique:company,code';
            $rulesName = 'unique:company,name';
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
            'address' => [
                'required',
                'min:20',
                'max:100',
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
            'address.required' => "Bạn chưa nhập địa chỉ công ty",
            'address.min' => "Địa chỉ công ty không được ngắn hơn 20 ký tự",
            'address.max' => "Địa chỉ công ty không được ngắn hơn 100 ký tự",
        ];
    }
}
