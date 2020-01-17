<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeTransaction extends Model
{
    protected $fillable = [
        'student_id', 'amount', 'discount_id', 'discount', 'fine', 'status', 'mode', 'fee_master_id', 'accountant_id','deducted_advance_amount'
    ];

    public function feeMasters()
    {
        return $this->belongsToMany('App\FeeMaster', 'fee_master_fee_transaction');
    }
}
