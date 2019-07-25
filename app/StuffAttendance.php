<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StuffAttendance extends Model
{
    public function stuff()
    {
        return $this->belongsTo('App\User', 'stuff_id');
    }
}
