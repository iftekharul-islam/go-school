<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExamDetailsRequest extends FormRequest
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
            'exam_name' => 'required|string',
            'term' => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
          'exam_name.required' => 'Please provide exam title',
          'term.required' => 'Please provide term title',
          'start_date.required' => 'Please provide exam start date',
          'end_date.required' => 'Please provide exam end date'
        ];
    }
}
