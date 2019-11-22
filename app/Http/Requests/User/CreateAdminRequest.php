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
            'address' => 'required',
            'blood_group' => 'required',
            'phone_number' => 'required|unique:users|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
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
        ];
    }
}
