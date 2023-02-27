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
        return $this->belongsTo(Myclass::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function attendanceTimes()
    {
        return $this->hasMany(SectionMeta::class);
    }

    public function students()
    {
        return $this->hasMany(User::class)->where('role', 'student')->where('active', 1);
    }
}
