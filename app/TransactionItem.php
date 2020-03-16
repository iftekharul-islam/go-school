<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = ['fee_type_id', 'fee_amount','fee_transaction_id', 'note'];

    public function fee_type()
    {
        return $this->belongsTo('App\FeeType');
    }
}
