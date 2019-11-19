<?php

namespace App\Http\Requests\user;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'pic_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
            'blood_group' => 'required',
            'religion' => 'required',
        ];

        if ($this->get('user_role') == 'teacher') {
            $rules['department_id'] = 'required|numeric';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Name field cannot be empty',
            'blood_group.required' => 'Blood group field cannot be empty',
            'religion.required' => 'Religion field cannot be empty',
            'pic_path.max' => 'Image size cannot be larger than 800KB',
            'pic_path.image' => 'Invalid image type',
        ];
    }
}
