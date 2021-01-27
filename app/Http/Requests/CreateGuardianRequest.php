<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGuardianRequest extends FormRequest
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
            'email' => 'sometimes|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone_number' => 'required|unique:users|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
            'gender' => 'required',
            'address' => 'required|string',
            'pic_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];
    }
}
