<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeTransaction extends Model
{
    protected $fillable = [
        'student_id', 'amount', 'discount_id', 'discount', 'fine', 'status', 'mode', 'fee_master_id', 'accountant_id', 'month'
    ];
}
