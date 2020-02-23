<?php

namespace App\Http\Controllers;

use App\Exam;
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
        $exams = Exam::where('active', 1)->get();
        return view('admitCard.create-admit-card',compact('classes', 'exams'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'section' => 'required',
            'exam' => 'required',
        ],[
            'section.required' => 'Select section',
            'exam.required' => 'Select exam',
        ]);
       
        $found = User::where('section_id', $request->section)->where('active', 1)->where('role', 'student')->count();
        if ($found == 0) {
            return back()->with('status', 'No Student Found');
        }

        $school = School::find(Auth::user()->id);
        $date = Carbon::now()->format('Y-m-d_g-i-s-a');
        $path = public_path('admits/'.$school->id);

        if(!File::isDirectory($path)){
            File::makeDirectory($path, 0777, true, true);
        }
        File::cleanDirectory($path);
        $exam = Exam::find($request->exam);
        $students = User::with('studentInfo', 'section.class')
            ->where('section_id', $request->section)
            ->where('role', 'student')
            ->where('active', 1)
            ->chunk(50, function($users) use ($school, $exam, $path, $date) {
                $this->generatePdf($users, $school, $exam, $path, $date);
            });
       
        #download zip file
        $zipfile = $school->id.'_'.$date.'.zip';
        $files = glob($path.'/*');
        Zipper::make($path.'/'.$zipfile)->add($files)->close();
        return response()->download($path.'/'.$zipfile)->deleteFileAfterSend(true);
    }

    public function generatePdf($students, $school, $exam, $path, $date)
    {
        foreach ($students as $student) {
            $data = [
                'name' => $student['name'],
                'section' => $student['section']['section_number'],
                'class' => $student['section']['class']['class_number'],
                'father_name' => $student['studentInfo']['father_name'],
                'mother_name' => $student['studentInfo']['mother_name'],
                'roll_number' => $student['studentInfo']['roll_number'],
                'student_pic' => $student['pic_path'],
                'school' => $school,
                'exam' => $exam
            ];
            $pdf = PDF::loadView('admitCard.admit-card-template', $data);
            $filename = $school->id.'_'.$student->student_code.'_'.'_'.$student->name.'_'.$date.'.pdf';
            $pdf->save($path.'/'.$filename);
        }
    }
}
