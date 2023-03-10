<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    protected $fillable = ['content', 'type', 'student_id', 'school_id', 'sms_count'];

    public function user(){
        return $this->belongsTo('App\User','student_id');
    }
}
