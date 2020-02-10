<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
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
            'school_id'     => 'required|integer',
            'sms_charge' => 'required|numeric',
            'per_student_charge'    => 'required|numeric',
            'invoice_generation_date'  => 'required|integer',
            'email'  => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'school_id.required' => 'Select School',
            'school_id.integer' => 'School ID must be number',
            'sms_charge.required' => 'Enter SMS Charge',
            'sms_charge.numeric' => 'Should be numeric',
            'per_student_charge.required' => 'Enter Per Student Charge',
            'per_student_charge.numeric'  => 'Should be numeric',
            'invoice_generation_date.required' => 'Select Date',
            'invoice_generation_date.integer'  => 'Must be number',
            'email.required' => 'Enter an email',
            'email.email' => 'Enter a valid email',
        ];
    }
}
