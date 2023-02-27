<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    protected $fillable = ['shift','last_attendance_time', 'exit_time', 'school_id'];

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
