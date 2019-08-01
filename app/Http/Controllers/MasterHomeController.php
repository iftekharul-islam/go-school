<?php

namespace App\Http\Controllers;

use App\School;
use App\User;

class MasterHomeController extends Controller
{
    public function index ()
    {
        $school = School::all()->count();
        $total_student = User::where('role', 'student')->where('active',1)->get()->count();
        $total_admin = User::where('role', 'admin')->where('active',1)->get()->count();
        return view('master-home',[
            'school'        => $school,
            'total_student' => $total_student,
            'total_admin'   => $total_admin
        ]);
    }

    public function allSchool()
    {
        $schools = School::get();
        return view('school.all-school', [
           'schools' => $schools
        ]);
    }
}
