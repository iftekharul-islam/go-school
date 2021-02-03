<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StuffAttendance extends Model
{
    public function stuff()
    {
        return $this->belongsTo(User::class, 'stuff_id');
    }
}
