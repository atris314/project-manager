<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserProfileRequest extends FormRequest
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

    public function rules()
    {
        return [
            'image' => 'required|image|mimes:jpg,jpeg,png',
        ];
    }
    public function messages()
    {
        return [
            'image.required' => 'تصویر پروفایل را آپلود کنید',
            'image.image' => 'فایل باید تصویر باشد',
            'image.mimes' => 'فقط فرمت jpg, jpeg, png مجاز است',
//            'image.max'   => 'حجم تصویر حداکثر باید ۲ مگابایت باشد',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => [
                'status' => false,
                'message' => $validator->errors(),
            ],
            'server_time' => now()->toIso8601String(),
        ], 400));
    }

}
