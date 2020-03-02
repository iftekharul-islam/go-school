<?php

namespace App\Http\Controllers;

use App\Exam;
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

    public function manageClasses()
    {
        $user = Auth::user();

        $schools = School::all();
        $classes = Myclass::orderBy('class_number','ASC')->get();
        $sections = Section::all();

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
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_medium' => 'required',
            'school_about' => 'required',
            'school_established' => 'required',
            'school_address' => 'required',
            'school_address' => 'required',
            'district' => 'required',
            'is_sms_enable' => 'required',
            'logo' => 'required|max:1024|mimes:jpeg,png,jpg,gif,svg',
            'sms_charge' => 'required|numeric',
            'per_student_charge'    => 'required|numeric',
            'invoice_generation_date'  => 'required|integer',
            'due_date'  => 'required|integer',
            'signup_date'  => 'required|date_format:Y-m-d',
            'email'  => 'required|email|max:191',
        ],[
            'is_sms_enable.required' => 'Select SMS Option'
        ]);

        $path = Storage::disk('public')->putFile('school-logos', $request->file('logo'));
        $path = 'storage/'.$path;
        $tb = new School();
        $tb->name = $request->school_name;
        $tb->established = $request->school_established;
        $tb->about = $request->school_about;
        $tb->medium = $request->school_medium;
        $tb->code = date('y').substr(number_format(time() * mt_rand(), 0, '', ''), 0, 6);
        $tb->theme = 'flatly';
        $tb->logo = $path;
        $tb->school_address = $request->school_address;
        $tb->district = $request->district;
        $tb->is_sms_enable = $request->is_sms_enable;
        $tb->sms_charge = $request->sms_charge;
        $tb->per_student_charge = $request->per_student_charge;
        $tb->invoice_generation_date = $request->invoice_generation_date;
        $tb->due_date = $request->due_date;
        $tb->email = $request->email;
        $tb->singup_date = $request->signup_date;
        $tb->save();

        return redirect()->route('school-details', $tb->id)->with('status', $tb->name.' created successfully');
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

    public function departmentEdit($id)
    {
        $department = Department::findOrFail($id);

        return view('school.edit-department', compact('department'));
    }

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

    public function departmentDestroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return back()->with('status', 'Department info deleted');
    }

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
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'school_name' => 'required',
            'school_medium' => 'required',
            'school_about' => 'required',
            'school_established' => 'required',
            'school_address' => 'required',
            'district' => 'required',
            'is_sms_enable' => 'required',
            'logo' => 'max:1024|mimes:jpeg,png,jpg,gif,svg',
            'sms_charge' => 'required|numeric',
            'per_student_charge'    => 'required|numeric',
            'invoice_generation_date'  => 'required|integer',
            'due_date'  => 'required|integer',
            'signup_date'  => 'required|date_format:Y-m-d',
            'email'  => 'required|email|max:191',
        ],[
            'is_sms_enable.required' => 'Select SMS Option'
        ]);

        $tb = School::findOrFail($id);
        $path = $tb->logo;
        if ($request->hasFile('logo'))
        {
            $path = Storage::disk('public')->putFile('school-logos', $request->file('logo'));
            $path = 'storage/'.$path;
        }
        
        $tb->name = $request->school_name;
        $tb->about = $request->school_about;
        $tb->medium = $request->school_medium;
        $tb->established = $request->school_established;
        $tb->logo = $path;
        $tb->district = $request->district;
        $tb->is_sms_enable = $request->is_sms_enable;
        $tb->school_address = $request->school_address;
        $tb->sms_charge = $request->sms_charge;
        $tb->per_student_charge = $request->per_student_charge;
        $tb->invoice_generation_date = $request->invoice_generation_date;
        $tb->due_date = $request->due_date;
        $tb->email = $request->email;
        $tb->singup_date = $request->signup_date;
        $tb->save();

        return redirect()->back()->with('status', 'School Information Updated');
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

        if( Hash::check($request->password, $user->password) ) {
            $school->delete();
            $message = $name.' deleted successfully';
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
        return back()->with('status', $name.' '.$schoolStatus);
    }

    public function smsSummary(Request $request, $school_id)
    {
        $this->validate($request, [
            'from_date' => 'nullable|before_or_equal:'.$request->to_date,
            'to_date' => 'nullable|after_or_equal:'.$request->from_date,
        ],[
            'from_date.before_or_equal' => 'From date must be a date before or equal "To date"',
            'to_date.after_or_equal' => 'To date must be a date after or equal to "From date"',
            
        ]);

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

        return view('school.sms-summary', compact('sms', 'from', 'to','school'));
    }

    public function schoolSetup()
    {
        $school = School::findOrFail(Auth::user()->school_id);
        return view('school.school-setting', compact('school'));
    }
    public function updateSchoolSetting(Request $request, $school_id)
    {
        $this->validate($request, [
            'school_address' => 'required|max:200',
            'about' => 'required|max:500',
            'medium' => 'required|max:200',
            'absent_msg' => 'required|max:140',
            'present_msg' => 'required|max:140',
        ],[
            'school_address.required' => 'Enter School Address',
            'school_address.max' => 'Maximum 200 characters',
            'about.required' => 'Enter short description',
            'about.max' => 'Maximum 500 characters',
            'absent_msg.required' => 'Enter student absent message',
            'absent_msg.max' => 'Maximum 140 characters',
            'present_msg.required' => 'Enter student present message',
            'present_msg.max' => 'Maximum 140 characters',
        ]);

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
