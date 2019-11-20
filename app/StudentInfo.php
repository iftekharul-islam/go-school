<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    protected $table = 'student_infos';
    protected $fillable = [
        'student_id',
        'session',
        'version',
        'group',
        'birthday',
        'religion',
        'father_name',
        'father_phone_number',
        'father_national_id',
        'father_occupation',
        'father_designation',
        'father_annual_income',
        'mother_name',
        'mother_phone_number',
        'mother_national_id',
        'mother_occupation',
        'mother_designation',
        'mother_annual_income',
        'user_id'
    ];

    protected $casts = [
      'birthday' => 'dateTime'
    ];

    /**
     * Get the student record associated with the user.
     */
    public function student()
    {
        return $this->belongsTo('App\User');
    }
}
