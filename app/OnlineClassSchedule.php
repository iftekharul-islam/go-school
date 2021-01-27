<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineClassSchedule extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'section_id', 'message', 'status'];


    public function classSummary()
    {
        return $this->hasMany(OnlineClassSummary::class, 'class_schedule_id', 'id');
    }

    public function section()
    {
        return $this->hasOne(Section::class, 'id', 'section_id');
    }

    public function students()
    {
        return $this->hasMany(User::class, 'section_id', 'section_id')->where('role', 'student');
    }


}
