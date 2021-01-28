<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

/**
 * @return mixed
 */
function current_user()
{
    return Auth::user();
}

/**
 * @param $date
 * @return string
 */
function new_date_format($date)
{
    return Carbon::parse($date)->format(config('time-format.default'));
}
