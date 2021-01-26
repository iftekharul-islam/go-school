<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolSettingRequest extends FormRequest
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
            'school_address' => 'required|max:200',
            'about' => 'required|max:500',
            'medium' => 'required|max:200',
            'absent_msg' => 'required|max:140',
            'present_msg' => 'required|max:140',
        ];
    }

    public function messages()
    {
        return [
            'school_address.required' => 'Enter School Address',
            'school_address.max' => 'Maximum 200 characters',
            'about.required' => 'Enter short description',
            'about.max' => 'Maximum 500 characters',
            'absent_msg.required' => 'Enter student absent message',
            'absent_msg.max' => 'Maximum 140 characters',
            'present_msg.required' => 'Enter student present message',
            'present_msg.max' => 'Maximum 140 characters',
        ];
    }
}
