<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function teachers()
    {
        return $this->hasMany('App\User', 'department_id');
    }

    public function students()
    {
        return $this->hasMany('App\User', 'department_id');
    }

    public function admins()
    {
        return $this->belongsToMany('App\User', 'department_user');
    }
}