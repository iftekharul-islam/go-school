<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StuffAttendance extends Model
{
    public function scopeAbsent($q)
    {
        return $q->where('present', 0);
    }

    public function scopePresent($q)
    {
        return $q->where('present', 1);
    }

    public function stuff()
    {
        return $this->belongsTo(User::class, 'stuff_id');
    }
}
