<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserProfileRequest extends FormRequest
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
            'pic_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
            'father_name'  => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field cannot be empty',
            'pic_path.max' => 'Image size cannot be larger than 800KB',
            'pic_path.image' => 'Invalid image type',
            'father_name.required' => 'Father name field cannot be empty',
            'mother_name.required' => 'Mother name field cannot be empty',
        ];
    }
}
