<?php

namespace App\Imports;

use App\StudentInfo;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersImport implements ToCollection
{

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
//        dd($rows);
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

            $user = User::create([
                'name' => $row[0],
                'email' => $username,
                'password'=> bcrypt($pass),
                'role'     => 'student',
                'active'   => 1,
                'school_id'=> auth()->user()->school_id,
                'code'     => auth()->user()->code,
                'student_code' => $code,
                'gender' => $row[1],
                'nationality'=> $row[2],
                'address' => $row[3],
                'section_id' => $this->section,
            ]);


            $student = StudentInfo::create([
                'student_id' => $code,
                'session' => date("Y"),
                'version' => $row[4],
                'group'  =>  $row[5] ? $row[5] : '',
//                'birthday' => Carbon::parse($row[6])->format('dd/mm/yy'),
                'birthday' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
                'father_name' => $row[7],
                'father_phone_number' => $row[8],
                'father_national_id' => $row[9] ? $row[9] : '',
                'father_occupation' => $row[10],
                'mother_name' => $row[11],
                'religion' => $row[12],
                'user_id' => $user->id,
            ]);
            dd($student);
        }
    }
}
