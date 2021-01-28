<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issuedbook extends Model
{
    protected $table = 'issued_books';

    public function book()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_code', 'student_code');
    }
}
