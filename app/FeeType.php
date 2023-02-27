<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    protected $fillable = ['name', 'order', 'school_id', 'description', 'code', 'is_default'];
}
