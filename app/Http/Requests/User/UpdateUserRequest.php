<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use http\Message;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\User
 */
class UpdateUserRequest extends FormRequest
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
        $rules = [
            'user_id' => 'required|numeric',
            'name' => 'required|string|max:255',
            'pic_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
            'father_annual_income' => 'nullable|integer|digits_between:0,10',
            'mother_annual_income' => 'nullable|integer|digits_between:0,10'
        ];

        if ($this->get('user_role') == 'teacher') {
            $rules['phone_number'] = 'required|numeric';
            $rules['address'] = 'required|string';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Name field cannot be empty',
            'pic_path.max' => 'Image size cannot be larger than 800KB',
            'pic_path.image' => 'Invalid image type',
            'phone_number.required' => 'Please enter a valid phone number',
            'father_annual_income.digits_between' => 'Income amount should be max 10 character',
            'mother_annual_income.digits_between' => 'Income amount should be max 10 character',
        ];
    }
}
