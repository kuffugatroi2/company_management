<?php

namespace App\Http\Requests\Person;

use Illuminate\Foundation\Http\FormRequest;

class PersonFormRequest extends FormRequest
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
        $rules = !empty($parameter) ? '' : 'unique:person,phone_number';

        return [
            'company_id' => [
                'required',
                'numeric',
            ],
            'full_name' => [
                'required',
                'regex:/^[\p{L}\s]+$/u',
            ],
            'birthdate' => [
                'required',
                'date',
            ],
            'phone_number' => [
                'nullable',
                'digits:10',
                $rules,
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
        $phoneNumber = $this->input('phone_number');
        return [
            'company_id.required' => "Bạn chưa chọn công ty",
            'company_id.numeric' => "Id công ty phải ở dạng số",
            'full_name.required' => "Bạn chưa nhập họ tên",
            'full_name.regex' => "Họ tên không được chứa chữ số hoặc ký tự đặc biệt",
            'birthdate.required' => "Bạn chọn ngày sinh",
            'birthdate.date' => "Ngày sinh phải ở dạng date",
            'phone_number.numeric' => "Số điện thoại phải ở dạng số",
            'phone_number.digits' => "Số điện thoại phải đủ 10 số",
            'phone_number.unique' => "Công ty $phoneNumber đã tồn tại!",
            'address.required' => "Bạn chưa nhập địa chỉ công ty",
            'address.min' => "Địa chỉ không được ngắn hơn 20 ký tự",
            'address.max' => "Địa chỉ không được ngắn hơn 100 ký tự",
        ];
    }
}
