<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateAdminRequest
 * @package App\Http\Requests\User
 */
class CreateAdminRequest extends FormRequest
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
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required',
            'about' => 'required',
            'address' => 'required',
            'blood_group' => 'required',
            'phone_number' => 'required|unique:users|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
            'email' => 'email|max:255|unique:users',
            'pic_path' => 'required|image'
        ];
    }
}
