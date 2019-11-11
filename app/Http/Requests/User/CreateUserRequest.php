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
            'department_id' => 'required'
        ];
    }
}
