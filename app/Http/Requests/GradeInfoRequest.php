<?php

namespace App\Http\Requests;

use App\Rules\GreaterThan;
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
            'from_mark' => 'required|numeric|max:95',
            'to_mark' => ['required', 'max:100', 'numeric',new GreaterThan($this->request->get('from_mark'))]
        ];
    }
}
