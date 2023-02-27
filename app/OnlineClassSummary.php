<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineClassSummary extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['class_schedules_id', 'total_sms'];

}
