<?php

namespace App\Http\Controllers;

use App\Services\Attendance\AttendanceService;
use App\User;
use App\StuffAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Attendance\TeacherAttendanceService;

class StuffAttendanceController extends Controller
{
    protected $attendanceService;
    protected $teacherAttendanceService;

    public function __construct(TeacherAttendanceService $teacherAttendanceService, AttendanceService $attendanceService)
    {
        $this->teacherAttendanceService = $teacherAttendanceService;
        $this->attendanceService = $attendanceService;
    }

    public function index()
    {
        $staffs = User::where('school_id', Auth::user()->school_id)
            ->where('role', 'teacher')
            ->orderBy('id', 'ASC')
            ->where('active', 1)
            ->get();
        $teachersFilterByAdmin = User::where('school_id', Auth::user()->school_id)
            ->where('role', 'teacher')
            ->orderBy('id', 'ASC')
            ->where('active', 1)
            ->whereIn('department_id', Auth::user()->adminDepartments()->pluck('departments.id'))
            ->get();
        if (count($teachersFilterByAdmin) > 0) {
            $staffs = $teachersFilterByAdmin;
        }
        $attendances = $this->teacherAttendanceService->getTeacherTodayAttendance();
        $attCount = $this->teacherAttendanceService->getTeacherTotalAttendance();

        return view('attendance.staff_attendance', compact('staffs', 'attendances', 'attCount'));
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
        $staffs = User::where('school_id', Auth::user()->school_id)->whereNotIn('role', ['student','teacher','admin','master'])->get();
        $attendances = $this->teacherAttendanceService->getLibrariansTodayAttendance();
        $attCount = $this->teacherAttendanceService->getLibrarianTotalAttendance();

        return view('attendance.staff_attendance', compact('staffs', 'attCount', 'attendances'));
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
        $user_type = 'staff';
        $attCount = $this->teacherAttendanceService->getAllAttendanceByStuffId($stuff_id);
        if ($attCount) {
            foreach ($attCount as $att) {
                $total = $att->total_present + $att->total_absent;
                $present = $att->total_present;
                $absent = $att->total_absent;
            }
        }
        $attendances = StuffAttendance::with('stuff')->where('stuff_id', $stuff_id)->get();

        $calendar =$this->attendanceService->AttendanceCalendar($attendances);

        return view('attendance.staff_attendances', compact('attendances', 'total', 'present', 'absent', 'calendar', 'user_type'));
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

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function absents($id)
    {
        $attendance_type = 'absent';
        $value = $this->checkAttendance($id, $attendance_type);

        return view('attendance.absents', ([
            'data' => $value['data'],
            'attendance' => $value['attendance'],
        ]));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attendees($id)
    {
        $attendance_type = 'present';
        $value = $this->checkAttendance($id, $attendance_type);

        return view('attendance.attendees', ([
            'data' => $value['data'],
            'attendance' => $value['attendance'],
        ]));
    }

    public function checkAttendance($id, $attendance_type)
    {
        $user = User::find($id);
        $attendance_table = 'staffAttendances';

        if ($user->role == 'student') {
            $attendance_table = 'attendances';
        }

        $data = User::with([$attendance_table => function ($q) use ($attendance_type) {
            $q->absent();
        }])->where('id', $id)
            ->first();

        $attendance = $data->{$attendance_table};

        return [
          'data' => $data,
          'attendance' => $attendance,
        ];
    }
}
