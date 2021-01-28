<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;


if (!function_exists('current_user')) {

    function current_user()
    {

        return Auth::user()->role;

    }
}

if (!function_exists('new_date_format')) {

    function new_date_format($date)
    {

        return Carbon::parse($date)->format('d-m-Y');

    }
}
