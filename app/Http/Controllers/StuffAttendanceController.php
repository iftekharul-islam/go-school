<?php

namespace App\Http\Controllers;

use App\User;
use App\StuffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Attendance\TeacherAttendanceService;

class StuffAttendanceController extends Controller
{
    public function __construct(TeacherAttendanceService $teacherAttendanceService)
    {
        $this->teacherAttendanceService = $teacherAttendanceService;
    }

    public function index()
    {
        $teachers = User::where('school_id', Auth::user()->school_id)
            ->where('role', 'teacher')
            ->orderBy('name', 'ASC')
            ->where('active', 1)
            ->get();
        $teachersFilterByAdmin = User::where('school_id', Auth::user()->school_id)
            ->where('role', 'teacher')
            ->orderBy('name', 'ASC')
            ->where('active', 1)
            ->whereIn('department_id', Auth::user()->adminDepartments()->pluck('departments.id'))
            ->get();

        if ($teachersFilterByAdmin->count() > 0) {
            $teachers = $teachersFilterByAdmin;
        }
        $attendances = $this->teacherAttendanceService->getTeacherTodayAttendance();
        $attCount = $this->teacherAttendanceService->getTeacherTotalAttendance();

        return view('attendance.teacher-attendance', compact('teachers', 'attendances', 'attCount'));
    }

    public function allTeacher()
    {
        $teachers = User::where('school_id', Auth::user()->school_id)
            ->where('role', 'teacher')
            ->orderBy('name', 'ASC')
            ->where('active', 1)
            ->get();
        return view('attendance.all-teachers', compact('teachers'));
    }

    public function stuffAttendance()
    {
        $librarians = User::where('school_id', Auth::user()->school_id)->whereIn('role', ['librarian', 'accountant'])->get();
        $attendances = $this->teacherAttendanceService->getLibrariansTodayAttendance();
        $attCount = $this->teacherAttendanceService->getLibrarianTotalAttendance();

        return view('attendance.librarian-attendance', compact('librarians', 'attCount', 'attendances'));
    }

    public function store(Request $request)
    {
        $this->teacherAttendanceService->request = $request;
        if (1 == $request->update) {
            $this->teacherAttendanceService->updateTodayAttendance();
        } else {
            $this->teacherAttendanceService->storeTeacherAttendance();
        }

        return redirect()->back()->with('status', 'Attendance record saved');
    }

    public function stuffAttendanceStore(Request $request)
    {
        $this->teacherAttendanceService->request = $request;
        if (1 == $request->update) {
            $this->teacherAttendanceService->updateStaffTodayAttendance();
        } else {
            $this->teacherAttendanceService->storeStuffAttendance();
        }
        $success =  __('text.Attendance record saved') ;

        return redirect()->back()->with('status', $success);
    }

    public function adjustMissingAttendance($stuff_id)
    {
        $this->teacherAttendanceService->stuff_id = $stuff_id;
        $attendances = $this->teacherAttendanceService->getPreviousAttendance();

        return view('attendance.adjust-teacher-attendance', compact('attendances', 'stuff_id'));
    }

    public function adjustMissingAttendancePost(Request $request)
    {
        $request->validate([
            'att_id' => 'required|array',
        ]);

        return $this->teacherAttendanceService->adjustPreviousAttendance($request);
    }

    public function details($stuff_id)
    {
        $present = 0;
        $absent = 0;
        $total = 0;
        $attCount = $this->teacherAttendanceService->getAllAttendanceByStuffId($stuff_id);
        if ($attCount) {
            foreach ($attCount as $att) {
                $total = $att->total_present + $att->total_absent;
                $present = $att->total_present;
                $absent = $att->total_absent;
            }
        }
        $attendances = StuffAttendance::with('stuff')->where('stuff_id', $stuff_id)->get();

        return view('attendance.admin-teacher-attendances', compact('attendances', 'total', 'present', 'absent'));
    }

    public function adjustStaffMissingAttendance($staff_id)
    {
        $this->teacherAttendanceService->stuff_id = $staff_id;
        $attendances = $this->teacherAttendanceService->getStaffPreviousAttendance();

        return view('attendance.adjust-staff-attendance', compact('attendances', 'staff_id'));
    }

    public function adjustStaffMissingAttendancePost(Request $request)
    {
        $request->validate([
            'att_id' => 'required|array',
        ]);

        return $this->teacherAttendanceService->adjustStaffPreviousAttendance($request);
    }
}
