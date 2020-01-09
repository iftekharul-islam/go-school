<?php
namespace App\Services\Attendance;

use App\User;
use App\Attendance;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class AttendanceService {
    public $request;

    public function getStudentsBySection($section_id){
        return User::with('section')
            ->select('id','name','student_code','section_id')
            ->where('section_id', $section_id)
            ->student()
            ->where('active', 1)
            ->orderBy('student_code', 'DESC')
            ->get();
    }

    public function getStudentsWithInfoBySection($section_id){
        return User::with(['section','school','studentInfo'])
            ->where('section_id', $section_id)
            ->student()
            ->where('active', 1)
            ->orderBy('name', 'asc')
            ->paginate(50);
    }

    public function adjustPost($request){
        if ($request->get('isPresent') ) {
            try {
                for ($i = 0; $i < count($request->isPresent); $i++) {
                    $users = Attendance::find($request->att_id[$i]);
                    $users->id = $request->att_id[$i];
                    $users->present = isset($request->isPresent[$i]) ? 1 : 0;
                    $users->updated_at = date('Y-m-d H:i:s');
                    $users->save();
                    return back()->with('status', 'Updated');
                }
            } catch (\Exception $ex) {
                return false;
            }
        }
        else
            return back()->with('error-status', 'You haven\'t selected any field');
    }

    public function getTodaysAttendanceBySectionId($section_id){
        return Attendance::where('section_id', $section_id)
            ->whereDate('created_at', \DB::raw('CURRENT_DATE'))
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique('student_id');
    }

    public function getAttendanceSummary($request)
    {
        return User::with(['attendances' => function ($query) use ($request) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        }])
        ->where('section_id', $request->section_id)
        ->student()
        ->where('active', 1)
        ->orderBy('name', 'asc')
        ->paginate(50);
    }

    public function getAllAttendanceBySecAndExam($section_id){
        return \DB::table('attendances')
            ->select('student_id', \DB::raw('
                      COUNT(CASE WHEN present=1 THEN present END) AS totalPresent,
                      COUNT(CASE WHEN present=0 THEN present END) AS totalAbsent,
                      COUNT(CASE WHEN present=2 THEN present END) AS totalEscaped'
            ))
            ->where('section_id', $section_id)
            ->groupBy('student_id')
            ->get();
    }

    public function getAllAttendanceByStudentId( $student_id ){
        return \DB::table('attendances')
            ->select('student_id', \DB::raw('
                      COUNT(CASE WHEN present=1 THEN present END) AS total_present,
                      COUNT(CASE WHEN present=0 THEN present END) AS total_absent,
                      COUNT(CASE WHEN present=2 THEN present END) AS total_escaped'
            ))
            ->groupBy('student_id')->where('student_id', $student_id)
            ->get();
    }

    public function getStudent($student_id){
        return User::with('section')
            ->where('id', $student_id)
            ->student()
            ->where('active', 1)
            ->firstOrFail();
    }


    public function getAbsentAttendanceByStudentAndExam($student_id, $exId){
        return Attendance::with(['student', 'section'])
            ->where('student_id', $student_id)
            ->whereIn('present',['0','2'])
            ->get();
    }

    public function getAttendanceByStudentAndExam($student_id, $exId){
        return Attendance::with(['student', 'section'])
            ->where('student_id', $student_id)
            ->get();
    }

    public function updateAttendance(){
        $i = 0;
        $at = [];
        foreach ($this->request->attendances as $key => $attendance) {
            $tb = Attendance::findOrFail($attendance);
            if( !isset($this->request["isPresent$i"]) && $tb->present == 1){
                $tb->present = 0;
                $tb->updated_at = date('Y-m-d H:i:s');
                $tb->save();
            }
            elseif(isset($this->request["isPresent$i"]) && $tb->present == 0){
                $tb->present = 1;
                $tb->updated_at = date('Y-m-d H:i:s');
                $tb->save();
            }
            ++$i;
        }
        return $at;
    }

    public function storeAttendance(){
        $i = 0;
        foreach ($this->request->students as $key => $student) {
            $tb = new Attendance;
            $tb->student_id = $student;
            $tb->section_id = $this->request->section_id;
            $tb->exam_id = $this->request->exam_id;
            $tb->present = isset($this->request["isPresent$i"])?1:0;
            $tb->user_id = auth()->user()->id;
            $tb->created_at = date('Y-m-d H:i:s');
            $tb->updated_at = date('Y-m-d H:i:s');
            $at[] = $tb->attributesToArray();
            ++$i;
        }
        Attendance::insert($at);
        $this->sendSms($at);
    }

    private function sendSms($data)
    {
        $students = array_map(function($item) {
            if ($item['present'] === 1 ) {
                return $item['student_id'];
            }
        }, $data);



        $students = array_filter($students);
//        dd($students);
        $students = User::whereIn('id', $students)->get();

        foreach ($students as $key=>$student) {
            $phone = $student->studentInfo['father_phone_number'];
            $checked_digit = substr($phone, 0, 3);
            if ($checked_digit == '+88') {
                $phone = ltrim($phone, '+');
            } else {
                if ($checked_digit == '880') {
                    $phone = $phone;
                } else {
                    $phone = '88' . $phone;
                }
            }
            $user = config("message.sms_user");
            $pass = config("message.sms_pass");
            $sid = config("message.sms_sid");
            $url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
            $client = new Client();
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'user' => $user,
                    'pass' => $pass,
                    'sid'  => $sid,
                    'sms'  => [
                        [$phone, $student->name . " attended today's (" .Carbon::now()->toFormattedDateString() . ") class."],
                    ],
                ],
            ]);
        }
    }
}
