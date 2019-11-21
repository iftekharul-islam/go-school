<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoutineUploadRequest extends FormRequest
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
            'title' => 'required|max:255',
            'file' => 'required|max:6000|mimes:doc,docx,png,jpeg,pdf,xlsx,xls,ppt,pptx,txt',
            'section' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Please provide a title for syllabus',
            'file.required' => 'Please select a file',
            'file.max' => 'Please select a file less than 5MB',
            'file.mimes' => 'Inavild file type'
        ];
    }
}
