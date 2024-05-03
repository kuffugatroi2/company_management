<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
            $rules = '';
            $required = '';
        } else {
            $rules = 'unique:users,email';
            $required = 'required';
        }

        return [
            'email' => [
                'required',
                'email',
                $rules,
            ],
            'password' => [
                $required,
                'min:6',
            ],
            'password-again' => [
                'same:password'
            ],
        ];
    }

    public function messages()
    {
        $email = $this->input('email');
        return [
            'email.required' => "Bạn chưa nhập Email",
            'email.unique' => "Email $email đã tồn tại!",
            'password.required' => "Bạn chưa nhập Password",
            'password.min' => "Lỗi! Password không được ngắn hơn 6 ký tự",
            'password-again.same' => "Mật khẩu không khớp nhau!"
        ];
    }
}
