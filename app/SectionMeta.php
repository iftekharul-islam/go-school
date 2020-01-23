<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionMeta extends Model
{
    protected $fillable = ['section_id','shift','last_attendance_time','exit_time'];
}
