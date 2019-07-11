<?php

namespace App\Http\Controllers;

use App\School;

class MasterHomeController extends Controller
{
    public function index ()
    {
        $schools = School::all();
        return view('master-home',[
            'schools' => $schools
        ]);
    }
}
