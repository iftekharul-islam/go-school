<?php
namespace App\Services\Attendance;

use App\StuffAttendance;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TeacherAttendanceService {
    public $request;

    public function storeTeacherAttendance()
    {
        $i = 0;
        $authUser = Auth::user();
        foreach ($this->request->teachers as $key => $teacher) {
            $user = User::findOrFail($teacher);
            $tb = new StuffAttendance();
            $tb->stuff_id = $teacher;
            $tb->role = $user->role;
            $tb->school_id = $authUser->school_id;
            $tb->present = isset($this->request["isPresent$i"])?1:0;
            $tb->user_id = $authUser->id;
            $tb->created_at = date('Y-m-d H:i:s');
            $tb->updated_at = date('Y-m-d H:i:s');
            $at[] = $tb->attributesToArray();
            ++$i;
        }
        StuffAttendance::insert($at);
    }

    public function getTeacherTodayAttendance()
    {
        return StuffAttendance::whereDate('created_at', \DB::raw('CURRENT_DATE'))
            ->where('school_id', Auth::user()->school_id)
            ->where('role', 'teacher')
            ->orderBy('stuff_id', 'ASC')
            ->get()
            ->unique('stuff_id');
    }

    public function getLibrariansTodayAttendance()
    {
        return StuffAttendance::whereDate('created_at', \DB::raw('CURRENT_DATE'))
            ->where('school_id', Auth::user()->school_id)
            ->orderBy('stuff_id', 'desc')
            ->whereIn('role', ['librarian', 'accountant'])
            ->get()
            ->unique('stuff_id');
    }

    public function getTeacherTotalAttendance()
    {
        return DB::table('stuff_attendances')
            ->select('stuff_id', DB::raw('
                      COUNT(CASE WHEN present=1 THEN present END) AS totalPresent,
                      COUNT(CASE WHEN present=0 THEN present END) AS totalAbsent'
            ))
            ->where('school_id', Auth::user()->school_id)
            ->where('role', 'teacher')
            ->groupBy('stuff_id')
            ->get();
    }

    public function getLibrarianTotalAttendance()
    {
        return DB::table('stuff_attendances')
            ->select('stuff_id', DB::raw('
                      COUNT(CASE WHEN present=1 THEN present END) AS totalPresent,
                      COUNT(CASE WHEN present=0 THEN present END) AS totalAbsent'
            ))
            ->where('school_id', Auth::user()->school_id)
            ->whereIn('role', ['accountant', 'librarian'])
            ->groupBy('stuff_id')
            ->get();
    }

    public function updateTodayAttendance()
    {
        $i = 0;
        foreach ($this->request->attendances as $key => $attendance) {
            $tb = StuffAttendance::findOrfail($attendance);
            if(isset($this->request["isPresent$i"])){
                $tb->present = 1;
            }
            if(!isset($this->request["isPresent$i"]) && $tb->present == 1 ) {
                $tb->present = 0;
            }
            $tb->updated_at = date('Y-m-d H:i:s');
            $tb->save();
            ++$i;
        }
    }

    public function storeAttendance()
    {
        $i = 0;
        foreach ($this->request->teachers as $key => $teacher) {
            $tb = new StuffAttendance;
            $tb->stuff_id = $teacher;
            $tb->school_id = Auth::user()->school_id;
            $tb->present = isset($this->request["isPresent$i"])?1:0;
            $tb->user_id = auth()->user()->id;
            $tb->created_at = date('Y-m-d H:i:s');
            $tb->updated_at = date('Y-m-d H:i:s');
            $at[] = $tb->attributesToArray();
            ++$i;
        }
        StuffAttendance::insert($at);
    }

    public function getPreviousAttendance()
    {
        return StuffAttendance::with(['stuff'])
            ->where('stuff_id', $this->stuff_id)
            ->where('present',0)
            ->where('role', 'teacher')
            ->get();
    }

    public function getStaffPreviousAttendance()
    {
        return StuffAttendance::with(['stuff'])
            ->where('stuff_id', $this->stuff_id)
            ->where('present',0)
            ->whereIn('role', ['librarian', 'accountant'])
            ->get();
    }

    public function adjustPreviousAttendance($request)
    {
        if ($request->get('isPresent') ) {
            try {
                for ($i = 0; $i < count($request->isPresent); $i++) {
                    $users = StuffAttendance::find($request->att_id[$i]);
                    $users->present = isset($request->isPresent[$i]) ? 1 : 0;
                    $users->updated_at = date('Y-m-d H:i:s');
                    $users->save();
                }
                return redirect()->to('admin/staff/teacher-attendance?att=2')->with('status', 'Updated');
            } catch (\Exception $ex) {
                return false;
            }
        }
        else
            return back()->with('error-status', 'You haven\'t selected any field');
    }


    public function adjustStaffPreviousAttendance($request)
    {
        if ($request->get('isPresent') ) {
            try {
                for ($i = 0; $i < count($request->isPresent); $i++) {
                    $users = StuffAttendance::find($request->att_id[$i]);
                    $users->present = isset($request->isPresent[$i]) ? 1 : 0;
                    $users->updated_at = date('Y-m-d H:i:s');
                    $users->save();
                }
                return redirect()->to('admin/staff/attendance?att=3')->with('status', 'Updated');
            } catch (\Exception $ex) {
                return false;
            }
        }
        else
            return back()->with('error-status', 'You haven\'t selected any field');
    }


    public function getAllAttendanceByStuffId($stuff_id)
    {
        return \DB::table('stuff_attendances')
            ->select('stuff_id', \DB::raw('
                      COUNT(CASE WHEN present=1 THEN present END) AS total_present,
                      COUNT(CASE WHEN present=0 THEN present END) AS total_absent'
            ))
            ->groupBy('stuff_id')->where('stuff_id', $stuff_id)
            ->get();
    }

    public function updateStaffTodayAttendance()
    {
        $i = 0;
        foreach ($this->request->attendances as $key => $attendance) {
            $tb = StuffAttendance::findOrFail($attendance);
            if(isset($this->request["isPresent$i"])){
                $tb->present = 1;
            }
            if(!isset($this->request["isPresent$i"]) && $tb->present == 1 ) {
                $tb->present = 0;
            }
            $tb->updated_at = date('Y-m-d H:i:s');
            $tb->save();
            ++$i;
        }
    }

    public function storeStuffAttendance()
    {
        $i = 0;
        $authUser = Auth::user();
        foreach ($this->request->staffs as $key => $staff) {
            $user = User::findOrFail($staff);
            $tb = new StuffAttendance();
            $tb->stuff_id = $staff;
            $tb->role = $user->role;
            $tb->school_id = $authUser->school_id;
            $tb->present = isset($this->request["isPresent$i"])?1:0;
            $tb->user_id = $authUser->id;
            $tb->created_at = date('Y-m-d H:i:s');
            $tb->updated_at = date('Y-m-d H:i:s');
            $at[] = $tb->attributesToArray();
            ++$i;
        }
        StuffAttendance::insert($at);
    }
}