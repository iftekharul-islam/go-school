<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Issuedbook extends Model
{
    protected $table = 'issued_books';

    public function book()
    {
        return $this->belongsTo('App\Book');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_code', 'student_code');
    }
}
