<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUserRequest
 * @package App\Http\Requests\User
 */
class UpdateUserRequest extends FormRequest
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
            'user_id' => 'required|numeric',
            'email' => 'required|',
            'name' => 'required|string|max:255',
            'phone_number' =>  'required|regex:/\+?(88)?0?1[56789][0-9]{8}\b/',
        ];

        if ($this->get('user_role') == 'teacher') {
            $rules['department_id'] = 'required|numeric';
        }

        return $rules;
    }
}
