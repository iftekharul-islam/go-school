<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamForClass extends Model
{
    protected $fillable = [
        'class_id',
        'exam_id',
        'active',
    ];

    public $timestamps = false;

    public function className(){
        return $this->hasOne(Myclass::class,'id', 'class_id');
    }

    public function exam(){
        return $this->belongsTo('App\Exam');
    }
}
