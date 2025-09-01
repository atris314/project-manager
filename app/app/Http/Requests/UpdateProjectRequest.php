<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title'=>'sometimes|string|max:190',
            'description'=>'sometimes|nullable|string',
            'start_date'=>'sometimes|nullable|date',
            'end_date'=>'sometimes|nullable|date|after_or_equal:start_date',
            'status'=>'sometimes|in:planned,in_progress,completed,on_hold',
        ];
    }


    public function messages(): array
    {
        return [
            'title.required' => 'لطفاً عنوان پروژه را تعریف کنید.',
            'title.string' => 'عنوان پروژه حتما باید کاراکتر متنی باشد',
            'title.max' => 'عنوان پروژه نمیتواند بیشتر از 190 کاراکتر باشد.',
            'description.string' => 'عنوان پروژه نمیتواند بیشتر از 190 کاراکتر باشد.',
        ];
    }

    public function all($keys = null)
    {
        return Request()->validate($this->rules(), $this->messages());
    }
}
