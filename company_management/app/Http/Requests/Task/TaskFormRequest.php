<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskFormRequest extends FormRequest
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
        $rules = !empty($parameter) ? '' : 'unique:task,name';

        return [
            'project_id' => [
                'required',
            ],
            'name' => [
                'required',
                'regex:/^[\p{L}\s]+$/u',
                $rules,
            ],
            'status' => [
                'numeric',
            ],
            'priority' => [
                'numeric'
            ],
        ];
    }

    public function messages()
    {
        $name = $this->input('name');
        return [
            'project_id.required' => "Dự án không được trống",
            'name.regex' => "Mã code không được nhập khoảng trắng",
            'name.required' => "Bạn chưa nhập nhiệm vụ",
            'name.unique' => "Nhiệm vụ $name đã tồn tại!",
            'priority.numeric' => 'priority phải ở dạng số',
            'status.numeric' => 'Trạng thái phải ở dạng số'
        ];
    }
}
