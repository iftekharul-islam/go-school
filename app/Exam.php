<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function grade()
    {
        return $this->hasOne(Grade::class);
    }

    public function class()
    {
        return $this->hasMany(ExamForClass::class);
    }

}
