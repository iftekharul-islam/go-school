<?php

namespace App\Http\Controllers;
use App\Routine;
use App\Syllabus;
use App\Notice;
use App\Event;
use App\User;
use Illuminate\Support\Facades\Auth;

class InactiveSettingsController extends Controller
{
    public function syllabuses()
    {
        $files = Syllabus::with('myclass')
            ->where('school_id', Auth::user()->school_id)
            ->where('active', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('inactiveSettings.syllabuses', ['files' => $files, 'class_id' => 1]);
    }

    public function notices()
    {
        $files = Notice::where('school_id', \Auth::user()->school_id)
            ->where('active', 0)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('inactiveSettings.notices', ['files' => $files]);
    }

    public function events()
    {
        $files = Event::where('school_id', \Auth::user()->school_id)->where('active', 0)->orderBy('created_at', 'DESC')->get();
        return view('inactiveSettings.events', ['files' => $files]);
    }

    public function students()
    {
        $type = "Students";
        $users = User::where('school_id', Auth::user()->school_id)->where('active', 0)->where('role', 'student')->get();
        return view('inactiveSettings.users', compact('type', 'users'));
    }

    public function accountants()
    {
        $type = "Accountants";
        $users = User::where('school_id', Auth::user()->school_id)->where('active', 0)->where('role', 'accountant')->get();
        return view('inactiveSettings.users', compact('type', 'users'));

    }

    public function teachers()
    {
        $type = "Teachers";
        $users = User::where('school_id', Auth::user()->school_id)->where('active', 0)->where('role', 'teacher')->get();
        return view('inactiveSettings.users', compact('type', 'users'));

    }
    public function librarians()
    {
        $type = "Librarians";
        $users = User::where('school_id', Auth::user()->school_id)->where('active', 0)->where('role', 'librarians')->get();
        return view('inactiveSettings.users', compact('type', 'users'));

    }
    public function routines()
    {
        $section_id =1;
        $files = Routine::with('section')
            ->where('school_id', Auth::user()->school_id)
            ->where('active', 0)
            ->get();
        return view('inactiveSettings.routines', compact( 'files','section_id'));

    }
}
