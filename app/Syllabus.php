<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Syllabus extends Model
{
	protected $table = 'syllabuses';

	protected $fillable = ['file_path', 'user_id', 'class_id', 'title', 'active', 'description', 'school_id'];
    /**
     * Get the school record associated with the user.
    */
    public function school()
    {
        return $this->belongsTo('App\School');
    }
    /**
     * Get the class record associated with the syllabus.
    */
    public function myclass()
    {
        return $this->belongsTo('App\Myclass','class_id');
    }
}
