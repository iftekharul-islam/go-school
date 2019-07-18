<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeSystemInfo extends Model
{
    protected  $fillable = ['grade', 'grade_points', 'marks_from','marks_to', 'gradesystem_id'];
    public  function  gradeSystem() {

        return $this->belongsTo('App\GradeSystem');
    }
}
