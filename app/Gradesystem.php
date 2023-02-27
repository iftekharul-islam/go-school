<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gradesystem extends Model
{
    protected $table = 'grade_systems';
    protected $fillable = ['grade_system_name', 'school_id'];

    public function school()
    {
        return $this->belongsTo('App\School');
    }

    public function gradeSystemInfo()
    {
        return $this->hasMany('App\GradeSystemInfo');
    }
}
