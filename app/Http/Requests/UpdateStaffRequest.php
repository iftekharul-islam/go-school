<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
            'pic_path' => 'image|mimes:jpeg,png,jpg,gif,svg|max:800',
        ];
    }
    public function messages()
    {
        return [
            'pic_path.max' => 'Image size cannot be larger than 800KB',
            'pic_path.image' => 'Invalid image type',
            ];
    }
}
