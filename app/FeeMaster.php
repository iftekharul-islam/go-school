<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeMaster extends Model
{
    protected $fillable = ['class_id', 'fee_type_id', 'format', 'amount'];
}
