<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Myclass extends Model
{
    protected $table = 'classes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_number',
        'group',
        'school_id',
        'department_id',
    ];

    /**
     * Get the school record associated with the user.
     */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    public function sections()
    {
        return $this->hasMany('App\Section', 'class_id');
    }

    public function exam()
    {
        return $this->belongsTo('App\ExamForClass');
    }

    public function books()
    {
        return $this->hasMany('App\Book', 'class_id');
    }

    public function feeMasters()
    {
        return $this->hasMany(FeeMaster::class, 'class_id', 'id');
    }
}
