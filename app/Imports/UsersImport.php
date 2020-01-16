<?php

namespace App\Imports;

use App\StudentInfo;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersImport implements ToCollection
{
    use Importable;

    public  function __construct($section)
    {
        $this->section = $section;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        $error_rows = [];
        foreach ($rows as $key => $row)
        {
            if ($key == 0) {
                continue;
            }

            {
                $code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
                $name = explode(" ", $row[0]);

                $username = array_last($name) . $code;
                $pass = $username;
            }

            if (!$this->validateSheet($row))
            {
                session()->put('importWarning', true);
                $error_rows[] = $key+1;
                continue;
            }elseif($this->checkDuplicate($row[0],$row[9],$row[8]))
            {
                session()->put('duplicateWarning', true);
                continue;
            }



            $user = User::create([
                'name' => $row[0],
                'email' => $username,
                'password'=> bcrypt($pass),
                'role'     => 'student',
                'active'   => 1,
                'school_id'=> auth()->user()->school_id,
                'code'     => auth()->user()->code,
                'student_code' => $code,
                'gender' => $row[2],
                'nationality'=> $row[3],
                'address' => $row[4],
                'section_id' => $this->section,
            ]);

            StudentInfo::create([
                'student_id' => $code,
                'session' => date("Y"),
                'roll_number' => $row[1] ? $row[1] : '',
                'version' => $row[5],
                'shift' => $row[6] ? $row[6] : '',
                'group'  =>  $row[7] ? $row[7] : '',
                'birthday' => is_string($row[8]) ? Carbon::parse((string)$row[8]) : Date::excelToDateTimeObject($row[8]),
                'father_name' => $row[9],
                'father_phone_number' => $row[10],
                'father_national_id' => $row[11] ? $row[11] : '',
                'father_occupation' => $row[12],
                'mother_name' => $row[13],
                'religion' => $row[14],
                'user_id' => $user->id,
            ]);
        }
        session()->put('error_rows',$error_rows);
    }
    public function validateSheet($row)
    {
        if (!empty($row[0]) && !empty($row[2]) && !empty($row[3]) && !empty($row[4]) && !empty($row[5])  && !empty($row[8])
            && !empty($row[9]) && !empty($row[10]) && !empty($row[12]) && !empty($row[13]) && !empty($row[14]))
        {
            return true;
        }
        return false;
    }
    public function checkDuplicate($student_name,$father_name,$birthday)
    {
       $birth = is_string($birthday) ? Carbon::parse((string)$birthday) : Date::excelToDateTimeObject($birthday);
       $count = User::join('student_infos','users.id','=', 'student_infos.user_id')
                ->where('users.name',$student_name)
                ->where('student_infos.father_name',$father_name)
                ->whereDate('student_infos.birthday',$birth)
                ->count();
//       dd($count);
       if ($count > 0)
       {
           return true;
       }
       return false;
    }
}
