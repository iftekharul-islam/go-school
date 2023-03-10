<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Class CreateUserRequest
 * @package App\Http\Requests\User
 */
class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->role == 'admin';
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
            'email' => 'sometimes|max:255|unique:users',
            'student_code' => 'required|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'section' => 'required|numeric',
            'gender' => 'required|string',
            'blood_group' => 'required|string',
            'guardian_id' => 'required|integer|exists:users,id',
            'guardian_name' => 'required|string',
            'guardian_phone_number' => 'required|string',
            'session' => 'required',
            'version' => 'required',
            'birthday' => 'required',
            'religion' => 'required|string',
            'father_annual_income' => 'nullable|integer|digits_between:0,10',
            'mother_annual_income' => 'nullable|integer|digits_between:0,10',
            'student_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field cannot be empty',
            'student_pic.required' => 'Please provide and image for the profile',
            'student_pic.image' => 'Invalid image type',
            'student_pic.max' => 'Image size cannot be larger than 800KB',
            'email.email' => 'Please provide a valid email address',
            'father_phone_number.required' => 'Please enter a Valid phone number',
            'father_annual_income.digits_between' => 'Income amount should be max 10 character',
            'mother_annual_income.digits_between' => 'Income amount should be max 10 character',
        ];
    }

}
