<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionMonth extends Model
{
    protected $fillable = ['fee_transaction_id', 'month'];

    public function TransactionProfiles()
    {
        return $this->belongsTo('App\TransactionProfile');
    }
}
