<?php

namespace App\Http\Middleware;

use App\School;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAdmin
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
        if (Auth::user()->hasRole('admin')) {
            return $next($request);
        }
        return redirect(Auth::user()->role.'/home');
    }
}
