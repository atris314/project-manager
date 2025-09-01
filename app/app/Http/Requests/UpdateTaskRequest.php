<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:190',
            'description' => 'nullable',
            'assigned_to' => 'required|exists:users,id',
//            'project_id' => 'required|exists:projects,id'
            'status' => 'sometimes|string|in:todo,doing,done,blocked'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'لطفاً عنوان وظیفه را تعریف کنید.',
            'title.string' => 'عنوان وظیفه حتما باید کاراکتر متنی باشد',
            'title.max' => 'عنوان وظیفه نمیتواند بیشتر از 190 کاراکتر باشد.',
        ];
    }

    public function all($keys = null)
    {
        return Request()->validate($this->rules(), $this->messages());
    }
}
