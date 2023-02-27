<?php

namespace App\Http\Requests\Shift;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShiftRequest extends FormRequest
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
            'shift' => 'required|max:255',
            'last_attendance_time' => ['required','max:255',function($attribute, $value, $fail){
                if(!empty(request()->get('exit_time'))){
                    $last_attendance_time = Carbon::parse(request()->get('last_attendance_time'));
                    $exit_time = Carbon::parse(request()->get('exit_time'));
                    if($last_attendance_time->gt($exit_time)){
                        $fail('Last attendance time must be greater than exit time');
                    }
                }
                
            }],
            'exit_time' => 'required|max:255'
        ];
    }

    public function messages()
    {
        return [
            'shift.required' => 'Shift is required',
            'shift.max' => 'Maximum 255 characters',
            'last_attendance_time.required' => 'Last attendance time is required',
            'last_attendance_time.max' => 'Maximum 255 characters',
			'exit_time.required' => 'Exit time is required',
			'exit_time.max' => 'Maximum 255 characters',
        ];
    }
}

