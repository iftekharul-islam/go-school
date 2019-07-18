<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeInfoRequest extends FormRequest
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
            'grade' => 'required|string',
            'point' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
            'from_mark' => 'required|numeric',
            'to_mark' => 'required|numeric',
        ];
    }
}
