<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateTeacherRequest
 * @package App\Http\Requests\User
 */
class CreateTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'sometimes|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'address' => 'required|string',
            'teacher_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field cannot be empty',
            'teacher_pic.required' => 'Please provide and image for the profile',
            'teacher_pic.image' => 'Invalid image type',
            'teacher_pic.max' => 'Image size cannot be larger than 800KB',
            'email.email' => 'Please provide a valid email address',
        ];
    }
}
