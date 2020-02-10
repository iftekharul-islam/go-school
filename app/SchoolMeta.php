<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolMeta extends Model
{
    protected $fillable = ['school_id', 'sms_charge', 'per_student_charge', 'invoice_generation_date','email', 'due_date'];

    public function school()
    {
        return $this->belongsTo('App\School');
    }
}
