<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeSystemRequest extends FormRequest
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
            'grade_system_name' => 'required|string|max:255',
            'point' => 'required|numeric',
            'grade' => 'required|string',
            'from_mark' => 'required|numeric',
            'to_mark' => 'required|numeric',
        ];
    }
}
