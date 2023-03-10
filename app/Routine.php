<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Routine extends Model
{
    protected $fillable = ['title', 'description', 'user_id', 'section_id', 'school_id', 'file_path', 'active'];
    /**
     * Get the school record associated with the user.
    */
    public function school()
    {
        return $this->belongsTo('App\School');
    }
    /**
     * Get the Section record associated with the Routine.
    */
    public function section()
    {
        return $this->belongsTo('App\Section');
    }
}
