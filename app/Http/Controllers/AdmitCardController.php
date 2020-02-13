<?php

namespace App\Http\Controllers;

use App\Myclass;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdmitCardController extends Controller
{
    public function createAdmit()
    {
        $school = Auth::user();
        $school->load('school');

        $classes = Myclass::with('sections.users')->where('school_id', Auth::user()->school_id)->get();

//        $students = $this->userService->getSectionStudentsWithSchool($request->section);
        $students = User::query()
                    ->where('school_id', Auth::user()->school->id)
                    ->get();
//        dd($students);

        // for mpd pdf creator package
//        $pdf = PDF::loadView('pdfView');
//        return $pdf->stream('admit.pdf');

        return view('create-admit-card',compact('school', 'students', 'classes'));
    }
}
