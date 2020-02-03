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
        if ( Auth::user()->role != 'master' ) {
            $school = School::find(Auth::user()->school_id);
            if ( empty($school) || $school->is_active == 0 ) {
                Auth::logout();
                return redirect('/account-suspended');
            }
        }

        return $next($request);
    }
}
