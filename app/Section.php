<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'section_number', 'room_number', 'class_id', 'user_id',
    ];
    /**
     * Get the class record associated with the user.
    */
    public function class()
    {
        return $this->belongsTo('App\Myclass');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function attendanceTimes()
    {
        return $this->hasMany('App\SectionMeta');
    }

    public function students()
    {
        return $this->hasMany('App\User')->where('role', 'student');
    }
}
