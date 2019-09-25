<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeMaster extends Model
{
    protected $fillable = ['class_id', 'fee_type_id', 'format', 'amount'];

    public function myclass()
    {
        return $this->belongsTo('App\Myclass','class_id');
    }

    public function feeType()
    {
        return $this->belongsTo('App\FeeType');
    }

    public function transactions()
    {
        return $this->hasMany('App\FeeTransaction');
    }
}
