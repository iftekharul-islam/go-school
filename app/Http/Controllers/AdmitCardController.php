<?php

namespace App\Http\Controllers;

use App\Myclass;
use App\School;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use Zipper;
use File;
class AdmitCardController extends Controller
{
    public function create()
    {
        $classes = Myclass::with('sections.users.studentInfo')
            ->where('school_id', Auth::user()->school_id)
            ->get();

        return view('admitCard.create-admit-card',compact('classes'));
    }

    public function generate(Request $request)
    {
        $school = School::find(Auth::user()->id);
        $students = User::with('studentInfo', 'section.class')->where('section_id', $request->section)->paginate(3);
        $date = Carbon::now()->format('Y-m-d');
        $path = public_path('admits/'.$school->id);
        if(!File::isDirectory($path)){
            File::makeDirectory($path);
        }
      
        if (!empty($students)) {
            foreach ($students as $student) {
                $data = [
                    'name' => $student->name,
                    'section' => $student['section']['section_number'],
                    'class' => $student['section']['class']['class_number'],
                    'father_name' => $student['studentInfo']['father_name'],
                    'mother_name' => $student['studentInfo']['mother_name'],
                    'roll_number' => $student['studentInfo']['roll_number'],
                    'student_pic' => $student['pic_path'],
                    'school' => $school
                ];
                $pdf = PDF::loadView('admitCard.admit-card-template', $data);
                $filename = $school->id.'_'.$student->student_code.'_'.'_'.$student->name.'_'.$date.'.pdf';
                $pdf->save($path.'/'.$filename);
            }
            $zipfile = $school->id.'_'.$date.'.zip';
            $files = glob($path.'/*');
            Zipper::make($path.'/'.$zipfile)->add($files)->close();
            return response()->download($path.'/'.$zipfile)->deleteFileAfterSend(true);
        }
    }
}
