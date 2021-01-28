<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateIssueBooksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $roles = ['librarian', 'admin'];
        $role = Auth::user()->role;

        return in_array($role, $roles) ?  true :  false ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'student_id' => 'required|exists:users,id',
            'issue_date' => 'required',
            'return_date' => 'required',
            'book_id' => 'required',
        ];
    }
}
