<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuardianHomeController extends Controller
{
    public function __invoke()
    {
        return view('guardian-home');

    }
}
