<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use http\Message;

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
            'name' => 'required|string|max:255',
            'pic_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];

        if ($this->get('user_role') == 'teacher') {
            $rules['department_id'] = 'required|numeric';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'name.required' => 'Name field cannot be empty',
            'pic_path.max' => 'Image size cannot be larger than 800KB',
            'pic_path.image' => 'Invalid image type',
        ];
    }
}
