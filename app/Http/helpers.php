<?php

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


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
    return Carbon::createFromFormat('Y-m-d', $date)->format(config('format.default_date'));
}

/**
 * @return array
 */
function full_year_by_month()
{
    return ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
}

/**
 * @return string
 */
function student_code_generate()
{
    return auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
}
