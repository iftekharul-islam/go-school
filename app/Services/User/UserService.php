<?php
namespace App\Services\User;

use App\User;
use App\StudentInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mavinoo\LaravelBatch\Batch;

class UserService {

    protected $user;
    protected $db;
    protected $batch;
    protected $st, $st2;

    public function __construct(User $user, DB $db, Batch $batch){
        $this->user = $user;
        $this->db = $db;
        $this->batch = $batch;
    }

    public function isListOfStudents($school_code, $student_code){
        return !empty($school_code) && $student_code == 1;
    }

    public function isListOfTeachers($school_code, $teacher_code){
        return !empty($school_code) && $teacher_code == 1;
    }

    public function indexView($view, $users){
        return view($view, [
            'users' => $users,
//            'current_page' => $users->currentPage(),
//            'per_page' => $users->perPage(),
        ]);
    }

    public function hasSectionId($section_id){
        return $section_id > 0;
    }

    public function updateStudentInfo($request, $id){
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

    public function promoteSectionStudentsView($students, $classes, $section_id){
        return view('school.new-promote-students', compact('students','classes','section_id'));
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
                    'active' => isset($request["left_school$i"])?0:1,
                ];

                $this->st2[] = [
                    'student_id' => $student->id,
                    'session' => $request->to_session[$i]
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
                if(!empty($stdntInfo)) {
                    $stdntInfo->session = $value['session'];
                    $stdntInfo->save();
                }
            }
            return back()->withInput(['tab'=> 'tab8'] )->with('status', 'All Student Promoted !');
        }
    }

    public function isAccountant($role){
        return $role == 'accountant';
    }

    public function isLibrarian($role){
        return $role == 'librarian';
    }

    public function indexOtherView($view, $users){
        return view($view, [
            'users' => $users,
//            'current_page' => $users->currentPage(),
//            'per_page' => $users->perPage(),
        ]);
    }

    public function getStudents(){
        return $this->user->with(['section.class', 'school', 'studentInfo'])
            ->where('code', auth()->user()->school->code)
            ->student()
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getTeachers(){
        return $this->user->with(['section', 'school'])
            ->where('code', auth()->user()->school->code)
            ->where('role', 'teacher')
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getAccountants(){
        return $this->user->with('school')
            ->where('code', auth()->user()->school->code)
            ->where('role', 'accountant')
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getLibrarians(){
        return $this->user->with('school')
            ->where('code', auth()->user()->school->code)
            ->where('role', 'librarian')
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getSectionStudentsWithSchool($section_id){
        return $this->user->with('school', 'section')
            ->student()
            ->where('section_id', $section_id)
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->get();
    }

    public function getSectionStudentsWithStudentInfo($section_id){
        return $this->user->with('section', 'studentInfo')
            ->where('section_id', $section_id)
            ->where('role', 'student')
            ->where('active', 1)
            ->get();
    }

    public function getSectionStudents($section_id){
        return $this->user->where('section_id', $section_id)
            ->where('active', 1)
            ->where('role', 'student')
            ->get();
    }

    public function getUserByUserCode($user_code){
        return User::with('section', 'studentInfo')
            ->where('student_code', $user_code)
            ->firstOrFail();
    }

    public function storeAdmin($request, $path){
        $tb = new $this->user;
        $tb->name = $request->name;
        $tb->email = $request->email;
        $tb->password = bcrypt($request->password);
        $tb->role = 'admin';
        $tb->active = 1;
        $tb->school_id = $request->school_id;
        $tb->code = $request->code;
        $tb->student_code = session('register_school_id').date('y').substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
        $tb->gender = $request->gender;
        $tb->blood_group = $request->blood_group;
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : '';
        $tb->phone_number = $request->phone_number;
        $tb->pic_path = 'storage/'.$path;
        $tb->verified = 1;
        $tb->address = $request->address;
        $tb->about = $request->about;
        $tb->save();
        return $tb;
    }

    public function storeStudent($request, $file){
        $tb = new $this->user;
        $tb->name = $request->name;
        $tb->email = (!empty($request->email)) ? $request->email : '';
        $tb->password = bcrypt($request->password);
        $tb->role = 'student';
        $tb->active = 1;
        $tb->school_id = auth()->user()->school_id;
        $tb->code = auth()->user()->code;
        $tb->student_code = auth()->user()->school_id.date('y').substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
        $tb->gender = $request->gender;
        $tb->blood_group = $request->blood_group;
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : '';
        $tb->phone_number = $request->phone_number;
        $tb->address = (!empty($request->address)) ? $request->address : '';
        $tb->about = (!empty($request->about)) ? $request->about : '';
        $tb->pic_path = 'storage/'.$file;
        $tb->verified = 1;
        $tb->section_id = $request->section;
        $tb->save();
        return $tb;
    }

    public function  storeStudentInfo($request, $student)
    {
        $data = [
            'student_id' => $student->student_code,
            'session' => $request->get('session'),
            'version' => $request->get('version'),
            'group' => (!empty($request->get('group'))) ? $request->get('group') : '',
            'birthday' => $request->get('birthday'),
            'religion' => $request->get('religion'),
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
            'user_id' => $student->id
        ];

        $info =  StudentInfo::create($data);
        return $info;

    }

    public function storeStaff($request, $role, $file){
        $tb = new $this->user;
        $tb->name = $request->name;
        $tb->email = (!empty($request->email)) ? $request->email : '';
        $tb->password = bcrypt($request->password);
        $tb->role = $role;
        $tb->active = 1;
        $tb->about = (!empty($request->about)) ? $request->about : '';
        $tb->address = $request->address;
        $tb->school_id = auth()->user()->school_id;
        $tb->code = auth()->user()->code;
        $tb->student_code = auth()->user()->school_id.date('y').substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
        $tb->gender = $request->gender;
        $tb->blood_group = $request->blood_group;
        $tb->nationality = (!empty($request->nationality)) ? $request->nationality : '';
        $tb->phone_number = $request->phone_number;
        $tb->pic_path = 'storage/'.$file;
        $tb->verified = 1;
        $tb->department_id = (!empty($request->department_id))?$request->department_id:0;

        if($role == 'teacher'){
            $tb->section_id = ($request->class_teacher_section_id != 0) ? $request->class_teacher_section_id : 0;
        }

        $tb->save();
        return $tb;
    }
}