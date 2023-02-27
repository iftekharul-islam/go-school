<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;

class CreateSchoolRequest extends FormRequest
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
            'school_name' => 'required|string|max:255',
            'school_medium' => 'required',
            'school_about' => 'required',
            'school_established' => 'required',
            'school_address' => 'required',
            'district' => 'required',
            'is_sms_enable' => 'required',
            'logo' => 'required|max:1024|mimes:jpeg,png,jpg,gif,svg',
            'payment_type' => 'required',
            'sms_charge' => 'nullable|numeric',
            'charge' => 'required|numeric',
            'invoice_generation_date' => 'nullable|integer',
            'due_date' => 'nullable|integer',
            'signup_date' => 'nullable|date_format:Y-m-d',
            'email' => 'nullable|email|max:191',
        ];
    }

    public function messages()
    {
        return [
            'is_sms_enable.required' => 'Select SMS Option'
        ];
    }
}
