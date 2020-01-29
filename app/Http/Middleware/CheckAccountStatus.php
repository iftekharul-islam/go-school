<?php

namespace App\Http\Middleware;

use App\School;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccountStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $school = School::findOrFail(Auth::user()->school_id)->first();
        if ( $school->is_active == 0 && Auth::user()->role != 'master') {
            return redirect('/account-suspended');
        }

        return $next($request);
    }
}
