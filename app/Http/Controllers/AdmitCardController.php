<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AdmitCardController extends Controller
{
    public function createAdmit()
    {
        $school = Auth::user();
        $school->load('school');

        // for mpd pdf creator package
//        $pdf = PDF::loadView('pdfView');
//        return $pdf->stream('admit.pdf');

        return view('create-admit-card',compact('school'));
    }
}
