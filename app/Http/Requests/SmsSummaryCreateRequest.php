<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SmsSummaryCreateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'from_date' => 'nullable|before_or_equal:' . $request->to_date,
            'to_date' => 'nullable|after_or_equal:' . $request->from_date,
        ];
    }

    /**
     * @return array|void
     */
    public function messages()
    {
        return [
            'from_date.before_or_equal' => 'From date must be a date before or equal "To date"',
            'to_date.after_or_equal' => 'To date must be a date after or equal to "From date"',
        ];

    }
}
