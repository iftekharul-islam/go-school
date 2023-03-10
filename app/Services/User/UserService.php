<?php

namespace App\Services\User;

use App\Discount;
use App\Events\NewUserRegistered;
use App\User;
use App\StudentInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserService
{
    protected $user;
    protected $db;
    protected $st;
    protected $st2;

    public function __construct(User $user, DB $db)
    {
        $this->user = $user;
        $this->db = $db;
    }

    public function isListOfStudents($school_code, $student_code)
    {
        return !empty($school_code) && 1 == $student_code;
    }

    public function isListOfTeachers($school_code, $teacher_code)
    {
        return !empty($school_code) && 1 == $teacher_code;
    }

    public function indexView($view, $users, $classes, $searchData, $type)
    {
        return view($view, [
            'users' => $users,
            'classes' => $classes,
            'searchData' => $searchData,
            'type' => $type
        ]);
    }

    public function hasSectionId($section_id)
    {
        return $section_id > 0;
    }

    public function updateStudentInfo($request, $id)
    {
        $info = StudentInfo::firstOrCreate(['student_id' => $id]);
        $info->student_id = $id;
        $info->session = (!empty($request->session)) ? $request->session : '';
        $info->version = (!empty($request->version)) ? $request->version : '';
        $info->group = (!empty($request->group)) ? $request->group : '';
        $info->birthday = (!empty($request->birthday)) ? $request->birthday : '';
        $info->religion = (!empty($request->religion)) ? $request->religion : '';
        $info->father_name = (!empty($request->father_name)) ? $request->father_name : '';
        $info->father_phone_number = (!empty($request->father_phone_number)) ? $request->father_phone_number : '';
        $info->father_national_id = (!empty($request->father_national_id)) ? $request->father_national_id : '';
        $info->father_occupation = (!empty($request->father_occupation)) ? $request->father_occupation : '';
        $info->father_designation = (!empty($request->father_designation)) ? $request->father_designation : '';
        $info->father_annual_income = (!empty($request->father_annual_income)) ? $request->father_annual_income : '';
        $info->mother_name = (!empty($request->mother_name)) ? $request->mother_name : '';
        $info->mother_phone_number = (!empty($request->mother_phone_number)) ? $request->mother_phone_number : '';
        $info->mother_national_id = (!empty($request->mother_national_id)) ? $request->mother_national_id : '';
        $info->mother_occupation = (!empty($request->mother_occupation)) ? $request->mother_occupation : '';
        $info->mother_designation = (!empty($request->mother_designation)) ? $request->mother_designation : '';
        $info->mother_annual_income = (!empty($request->mother_annual_income)) ? $request->mother_annual_income : '';
        $info->user_id = auth()->user()->id;
        $info->save();
    }

    public function promoteSectionStudentsView($students, $classes, $section_id)
    {
        return view('school.new-promote-students', compact('students', 'classes', 'section_id'));
    }

    public function promoteSectionStudentsPost($request)
    {
        if ($request->section_id > 0) {
            $students = $this->getSectionStudents($request->section_id);
            $i = 0;
            foreach ($students as $student) {
                $this->st[] = [
                    'id' => $student->id,
                    'section_id' => $request->to_section[$i],
                    'active' => isset($request["left_school$i"]) ? 0 : 1,
                ];

                $this->st2[] = [
                    'student_id' => $student->id,
                    'session' => $request->to_session[$i],
                ];

                ++$i;
            }

            foreach ($this->st as $item) {
                $stdnt = User::where('id', $item['id'])->first();
                $stdnt->section_id = $item['section_id'];
                $stdnt->active = $item['active'];
                $stdnt->save();
            }
            foreach ($this->st2 as $value) {
                $stdntInfo = StudentInfo::where('student_id', $value['student_id'])->first();
                if (!empty($stdntInfo)) {
                    $stdntInfo->session = $value['session'];
                    $stdntInfo->save();
                }
            }

            return back()->with('status', 'All Student Promoted !');
        }
    }

    public function isAccountant($role)
    {
        return 'accountant' == $role;
    }

    public function isLibrarian($role)
    {
        return 'librarian' == $role;
    }

    public function indexOtherView($view, $users, $classes, $type)
    {
        return view($view, [
            'users' => $users,
            'type' => $type,
            'classes' => $classes
        ]);
    }

    public function getStudents($section_id = null, $name = null, $show = 30)
    {
        $students = $this->user->with(['section.class', 'school', 'studentInfo'])
            ->where('school_id', Auth::user()->school_id)
            ->student()
            ->where('active', 1)
            ->when($section_id, function($query) use ($section_id){
                return $query->where('section_id', $section_id);
            })
            ->when($name, function($query) use ($name){
                return $query->where('name', 'like', "%{$name}%");
            })
            ->orderBy('name', 'asc')
            ->paginate($show);
        $studentFilterByDepartments = $this->user->with(['section.class', 'school', 'studentInfo'])
            ->where('school_id', auth()->user()->school_id)
            ->student()
            ->where('active', 1)
            ->whereIn('department_id', Auth::user()->adminDepartments()->pluck('departments.id'))
            ->orderBy('name', 'asc')
            ->paginate($show);

        if ($studentFilterByDepartments->count() > 0) {
            $students = $studentFilterByDepartments;
        }

        return $students;
    }

    public function getTeachers()
    {
        $teachers = $this->user->with(['section', 'school'])
            ->where('school_id', auth()->user()->school_id)
            ->where('role', 'teacher')
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->paginate(40);

        $teacherFilterByDepartments = $this->user->with(['section', 'school'])
            ->where('school_id', auth()->user()->school_id)
            ->where('role', 'teacher')
            ->where('active', 1)
            ->whereIn('department_id', Auth::user()->adminDepartments()->pluck('departments.id'))
            ->orderBy('name', 'asc')
            ->get();
        if ($teacherFilterByDepartments->count() > 0) {
            $teachers = $teacherFilterByDepartments;
        }

        return $teachers;
    }

    public function getGuardians()
    {
        return $this->user->with('school')
            ->where('school_id', auth()->user()->school_id)
            ->where('role', 'guardian')
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->paginate(40);
    }

    public function getAccountants()
    {
        return $this->user->with('school')
            ->where('school_id', auth()->user()->school_id)
            ->where('role', 'accountant')
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->paginate(40);
    }

    public function getLibrarians()
    {
        return $this->user->with('school')
            ->where('school_id', auth()->user()->school_id)
            ->where('role', 'librarian')
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->paginate(40);
    }

    public function getSectionStudentsWithSchool($section_id)
    {
        return $this->user->with('school', 'section')
            ->student()
            ->where('section_id', $section_id)
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->paginate(20);
    }

    public function getSectionStudentsWithStudentInfo($section_id)
    {
        return $this->user->with('section', 'studentInfo')
            ->where('section_id', $section_id)
            ->where('role', 'student')
            ->where('active', 1)
            ->get();
    }

    public function getSectionStudents($section_id)
    {
        return $this->user->where('section_id', $section_id)
            ->where('active', 1)
            ->where('role', 'student')
            ->get();
    }

    public function getUserByUserCode($user_code)
    {
        return User::with('section', 'studentInfo', 'studentInfo.guardian')
            ->where('student_code', $user_code)
            ->firstOrFail();
    }

    public function storeAdmin($request, $path)
    {
        $tb = new $this->user();
        $tb->name = $request->name;
        $tb->email = $request->email;
        $tb->password = bcrypt($request->password);
        $tb->role = 'admin';
        $tb->active = 1;
        $tb->school_id = $request->school_id;
        $tb->code = $request->code;
        $tb->student_code = session('register_school_id') . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
        $tb->gender = $request->gender;
        $tb->blood_group = $request->blood_group;
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : '';
        $tb->phone_number = $request->phone_number;
        $tb->pic_path = $path ? 'storage/' . $path : '';
        $tb->verified = 1;
        $tb->address = $request->address;
        $tb->about = $request->about;
        $tb->save();

        return $tb;
    }

    public function storeStudent($request, $path)
    {
        $tb = new $this->user();
        $tb->name = $request->name;
        $tb->email = (!empty($request->email)) ? $request->email : '';
        $tb->password = bcrypt($request->password);
        $tb->role = 'student';
        $tb->active = 1;
        $tb->school_id = auth()->user()->school_id;
        $tb->code = auth()->user()->code;
        $tb->student_code = $request->student_code;
        $tb->gender = $request->gender;
        $tb->blood_group = $request->blood_group;
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : 'Bangladeshi';
        $tb->phone_number = $request->phone_number;
        $tb->address = (!empty($request->address)) ? $request->address : '';
        $tb->about = (!empty($request->about)) ? $request->about : '';
        $tb->pic_path = $path ? 'storage/' . $path : '';
        $tb->verified = 1;
        $tb->section_id = $request->section;
        $tb->department_id = (!empty($request->department_id)) ? $request->department_id : 0;
        $tb->save();

        return $tb;
    }

    public function storeStudentInfo($request, $student)
    {
        $data = [
            'student_id' => $student->student_code,
            'session' => $request->get('session'),
            'version' => $request->get('version'),
            'shift' => $request->get('shift'),
            'student_indentification' => $request->get('student_indentification'),
            'roll_number' => $request->get('roll_number'),
            'group' => (!empty($request->get('group'))) ? $request->get('group') : '',
            'birthday' => $request->get('birthday'),
            'religion' => $request->get('religion'),
            'guardian_id' => $request->get('guardian_id'),
            'guardian_name' => $request->get('guardian_name'),
            'guardian_phone_number' => $request->get('guardian_phone_number'),
            'father_name' => $request->get('father_name'),
            'father_phone_number' => $request->get('father_phone_number'),
            'father_national_id' => $request->get('father_national_id'),
            'father_occupation' => $request->get('father_occupation'),
            'father_designation' => $request->get('father_designation'),
            'father_annual_income' => $request->get('father_annual_income'),
            'mother_name' => $request->get('mother_name'),
            'mother_phone_number' => $request->get('mother_phone_number'),
            'mother_national_id' => $request->get('mother_national_id'),
            'mother_occupation' => $request->get('mother_occupation'),
            'mother_designation' => $request->get('mother_designation'),
            'mother_annual_income' => $request->get('mother_annual_income'),
            'user_id' => $student->id,
            'is_sms_enabled' => $request->sms_enabled == 'true' ? true : false
        ];

        $info = StudentInfo::create($data);
        return $info;
    }

    public function storeStaff($request, $role, $path)
    {
        $tb = new $this->user();
        $tb->name = $request->name;
        $tb->email = (!empty($request->email)) ? $request->email : '';
        $tb->password = bcrypt($request->password);
        $tb->role = $role;
        $tb->active = 1;
        $tb->about = (!empty($request->about)) ? $request->about : '';
        $tb->address = $request->address;
        $tb->school_id = auth()->user()->school_id;
        $tb->code = auth()->user()->code;
        $tb->student_code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
        $tb->gender = $request->gender;
        $tb->blood_group = $request->blood_group;
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : 'Bangladeshi';
        $tb->phone_number = $request->phone_number;
        $tb->pic_path = $path ? 'storage/' . $path : '';
        $tb->verified = 1;
        $tb->save();

        return $tb;
    }

    /**
     * @param $student_id
     * @return array
     */
    public function feeSummary($student_id)
    {
        $student = User::with(['studentInfo', 'section', 'section.class.feeMasters', 'section.class.feeMasters.feeType'])->where('id', $student_id)->first();

        $total_amount = 0;
        $total_fine = 0;
        $total_discount = 0;
        $total_paid = 0;
        $total_fee_paid = 0;
        $paid_amount = 0;

        if (!empty($student)) {

            foreach ($student->section->class->feeMasters as $fee_master) {

                $total_amount = $total_amount + $fee_master->amount;

                foreach ($fee_master->transactions as $transaction) {

                    if ($student->id === $transaction->student_id) {

                        $total_fee_paid = $total_fee_paid + $transaction['amount'] + $transaction['discount'] - $transaction['fine'];
                    }

                    if (count($fee_master->transactions) != 0) {

                        $count = count($transaction->feeMasters);

                        if ($student->id === $transaction->student_id) {

                            if ($count == 1) {

                                $paid_amount = $paid_amount + $transaction['amount'] - $transaction['fine'] + $transaction['discount'];
                                $total_fine = $total_fine + $transaction['fine'];
                                $total_discount = $total_discount + $transaction['discount'];
                                $total_paid = $total_paid + $transaction['amount'];

                            } else {

                                $paid_amount = $paid_amount + ($transaction['amount'] / $count) + ($transaction['discount'] / $count) - ($transaction['fine'] / $count);
                                $total_fine = $total_fine + $transaction['fine'] / $count;
                                $total_discount = $total_discount + $transaction['discount'] / $count;
                                $total_paid = $total_paid + $transaction['amount'] / $count;
                            }

                        }

                    }

                }

            }
        }

        $discounts = Discount::where('school_id', Auth::user()->school_id)->get();

        return $data = [
            'totalAmount' => $total_amount,
            'totalFine' => $total_fine,
            'totalDiscount' => $total_discount,
            'totalPaid' => $total_paid,
            'totalFeePaid' => $total_fee_paid,
            'student' => $student,
            'discounts' => $discounts,
            'paidAmount' => $paid_amount,
        ];
    }
}
