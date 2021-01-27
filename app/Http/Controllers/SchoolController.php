<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Http\Requests\School\CreateSchoolRequest;
use App\Http\Requests\School\UpdateSchoolRequest;
use App\Http\Requests\School\UpdateSchoolSettingRequest;
use App\Http\Requests\SmsSummaryCreateRequest;
use App\Notification;
use App\User;
use App\School;
use App\Myclass;
use App\Section;
use App\Department;
use App\Gradesystem;
use App\SmsHistory;
use Carbon\Carbon;
//use App\Http\Resources\SchoolResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery\Matcher\Not;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDepartment()
    {
        return view('school.create-new-department');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageClasses()
    {
        $user = Auth::user();
        $schools = School::all();
        $classes = Myclass::orderBy('class_number', 'ASC')->get();
        $sections = Section::orderBy('section_number', 'ASC')->get();

        $teachers = User::where('role', 'teacher')
            ->orderBy('name', 'ASC')
            ->where('active', 1)
            ->get();

        $departments = Department::where('school_id', $user->school_id)->get();
        $adminAccessDepartment = Department::where('school_id', $user->school_id)->whereIn('id', Auth::user()->adminDepartments()->pluck('departments.id'))->get();
        return view('school.manage-classes',
            compact('schools',
                'adminAccessDepartment',
                'user',
                'classes',
                'sections',
                'departments',
                'teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('school.new-school');
    }

    /**
     * @param CreateSchoolRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateSchoolRequest $request)
    {
        $path = Storage::disk('public')->putFile('school-logos', $request->file('logo'));
        $path = 'storage/' . $path;

        $tb = new School();
        $tb->name = $request->school_name;
        $tb->established = $request->school_established;
        $tb->about = $request->school_about;
        $tb->medium = $request->school_medium;
        $tb->code = date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
        $tb->theme = 'flatly';
        $tb->logo = $path;
        $tb->school_address = $request->school_address;
        $tb->district = $request->district;
        $tb->is_sms_enable = $request->is_sms_enable;
        $tb->online_class_sms = $request->online_class_sms;
        $tb->sms_charge = $request->sms_charge;
        $tb->payment_type = $request->payment_type;
        $tb->charge = $request->charge;
        $tb->invoice_generation_date = $request->invoice_generation_date;
        $tb->due_date = $request->due_date;
        $tb->email = $request->email;
        $tb->singup_date = $request->signup_date;
        $tb->save();

        return redirect()->route('school-details', $tb->id)->with('status', $tb->name . ' created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($school_id)
    {
        $admins = User::where('school_id', $school_id)->where('role', 'admin')->get();

        return view('school.admin-list', compact('admins'));
    }

    /**
     * @param $school_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSchool($school_id)
    {
        $admins = User::where('school_id', $school_id)->where('role', 'admin')->get();
        $total_students = User::where('school_id', $school_id)->where('role', 'student')->where('active', 1)->count();
        $total_classes = Myclass::where('school_id', $school_id)->count();
        $total_teacher = User::where('school_id', $school_id)->where('role', 'teacher')->where('active', 1)->count();
        $total_exams = Exam::where('school_id', $school_id)->where('active', 1)->count();
        $school = School::where('id', $school_id)->first();

        return view('school.new-school-master', [
            'school' => $school,
            'total_students' => $total_students,
            'total_classes' => $total_classes,
            'total_teacher' => $total_teacher,
            'total_exams' => $total_exams,
            'admins' => $admins,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::findOrFail($id);

        return view('school.new-edit-school', compact('school'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeDepartment(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:50',
        ]);
        $s = new Department();
        $s->school_id = Auth::user()->school_id;
        $s->department_name = $request->department_name;
        $s->save();

        return back()->with('status', 'New Department created');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function departmentEdit($id)
    {
        $department = Department::findOrFail($id);

        return view('school.edit-department', compact('department'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function departmentUpdate(Request $request, $id)
    {
        $request->validate([
            'department_name' => 'required|string|max:50',
        ]);
        $department = Department::findOrFail($id);
        $department->department_name = $request->department_name;
        $department->save();

        return redirect()->route('admin.department-lists');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function departmentDestroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return back()->with('status', 'Department info deleted');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allDepartment()
    {
        $dpts = Department::with(['teachers' => function ($q) {
            $q->where('role', 'teacher');
        }, 'students' => function ($query) {
            $query->where('role', 'student');
        }])->where('school_id', Auth::user()->school_id)->get();

        $adminWithDepartment = Department::with(['teachers' => function ($q) {
            $q->where('role', 'teacher');
        }, 'students' => function ($query) {
            $query->where('role', 'student');
        }])->where('school_id', Auth::user()->school_id)
            ->whereIn('id', Auth::user()->adminDepartments()->pluck('departments.id'))->get();

        return view('school.departments', compact('dpts', 'adminWithDepartment'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function departmentTeachers($id)
    {
        $users = User::where('role', 'teacher')
            ->where('active', 1)
            ->where('school_id', Auth::user()->school_id)
            ->where('department_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('school.department-teachers', compact('users'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function departmentStudents($id)
    {
        $users = User::where('role', 'student')
            ->where('active', 1)
            ->where('school_id', Auth::user()->school_id)
            ->where('department_id', $id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('school.department-students', compact('users'));
    }

    public function changeTheme(Request $request)
    {
        $tb = School::findOrFail($request->s);
        $tb->theme = $request->school_theme;
        $tb->save();

        return back();
    }

    /**
     * @param UpdateSchoolRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSchoolRequest $request, $id)
    {
        $tb = School::findOrFail($id);
        $path = $tb->logo;

        if ($request->hasFile('logo')) {
            $path = Storage::disk('public')->putFile('school-logos', $request->file('logo'));
            $path = 'storage/' . $path;
        }

        $tb->name = $request->school_name;
        $tb->about = $request->school_about;
        $tb->medium = $request->school_medium;
        $tb->established = $request->school_established;
        $tb->logo = $path;
        $tb->district = $request->district;
        $tb->is_sms_enable = $request->is_sms_enable;
        $tb->online_class_sms = $request->online_class_sms;
        $tb->school_address = $request->school_address;
        $tb->sms_charge = $request->sms_charge;
        $tb->payment_type = $request->payment_type;
        $tb->charge = $request->charge;
        $tb->invoice_generation_date = $request->invoice_generation_date;
        $tb->due_date = $request->due_date;
        $tb->email = $request->email;
        $tb->singup_date = $request->signup_date;
        $tb->save();

        return redirect()->route('school-details', $id)->with('status', 'School Information Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $school_id)
    {
        $school = School::findOrFail($school_id);
        $user = Auth::user();
        $message = '';
        $name = $school->name;

        if (Hash::check($request->password, $user->password)) {
            $school->delete();
            $message = $name . ' deleted successfully';
        } else {
            return back()->with('status', 'Incorrect Password Provided');
        }

        return redirect()->route('all.school')->with('status', $message);
    }

    /**
     * update  school status
     *
     * @param int $school_id
     *
     * @return \Illuminate\Http\Response
     */
    public function updateStatusSchool($school_id, $status)
    {
        $school = School::findOrFail($school_id);
        $name = $school->name;
        $school->is_active = $status;
        $school->save();
        $schoolStatus = $status == 0 ? 'deactivated' : 'activated';
        return back()->with('status', $name . ' ' . $schoolStatus);
    }

    /**
     * @param Request $request
     * @param $school_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function smsSummary(SmsSummaryCreateRequest $request, $school_id)
    {
        $now = Carbon::now();
        $from = $request->from_date ? $request->from_date : $now->firstOfMonth()->format('Y-m-d');
        $to = $request->to_date ? $request->to_date : $now->today()->format('Y-m-d');

        if ($request->last_month == 1) {
            $firstDay = new Carbon('first day of last month');
            $lastDay = new Carbon('last day of last month');
            $from = $firstDay->format('Y-m-d');
            $to = $lastDay->format('Y-m-d');
        }

        $school = School::findOrFail($school_id);
        $sms = SmsHistory::with('user.section.class')->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->where('school_id', $school_id)
            ->orderby('created_at', 'asc')
            ->paginate(30);

        $sms_count = 0;
        foreach ($sms as $key => $item) {
            $sms_count += ceil(strlen($item->content) / 140);
        }

        $count = Notification::with('student')
            ->whereHas('student', function ($query) use ($school_id) {
                $query->where('school_id', $school_id);
            })
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->pluck('sms_count')
            ->toArray();

        $total_count = 0;
        foreach ($count as $key => $item) {
            $total_count += $item;
        }
        $total_sum = $sms_count + $total_count;

        return view('school.sms-summary', compact('sms', 'from', 'to', 'school', 'total_sum'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function schoolSetup()
    {
        $school = School::findOrFail(Auth::user()->school_id);
        return view('school.school-setting', compact('school'));
    }

    /**
     * @param Request $request
     * @param $school_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSchoolSetting(UpdateSchoolSettingRequest $request, $school_id)
    {
        $school = School::findOrFail($school_id);
        $school->school_address = $request->school_address;
        $school->about = $request->about;
        $school->medium = $request->medium;
        $school->absent_msg = $request->absent_msg;
        $school->present_msg = $request->present_msg;
        $school->save();

        return back()->with('status', 'School Setting Updated');
    }
}
