<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'section' => 'required|numeric',
            'gender' => 'required|string',
            'blood_group' => 'required|string',
            'nationality' => 'required|string',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'phone_number' => 'required|unique:users|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
            'address' => 'required|string',
            'session' => 'required',
            'version' => 'required',
            'birthday' => 'required',
            'religion' => 'required|string',
            'father_phone_number' => 'required',
            'father_national_id' => 'required',
            'mother_national_id' => 'required',
            'pic_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field cannot be empty',
            'pic_path.required' => 'Please provide and image for the profile',
            'pic_path.image' => 'Invalid image type',
            'pic_path.max' => 'Image size cannot be larger than 800KB',
            'email.email' => 'Please provide a valid email address',
        ];
    }

}
