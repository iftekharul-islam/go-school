<?php

namespace App;

use Dingo\Api\Auth\Auth;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    /**
     * Get the school record associated with the user.
    */
    public function school()
    {
        return $this->belongsTo('App\School');
    }

    public function scopeSelectedRole($q)
    {
        $user_role = user_role(Auth::user()->role);

        return $q->where('roles', 'like', '%' . "\"{$user_role}\"" . '%');
    }
}
