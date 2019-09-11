<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable =['name', 'code', 'description', 'amount', 'school_id'];
}
