<?php

namespace App\Imports;

use App\StudentInfo;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

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
        foreach ($rows as $key => $row)
        {
            if ($key == 0) {
                continue;
            }

            if (!$row[1]) {
                $code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
                $name = explode(" ", $row[0]);

                $username = array_last($name) . $code;
                $row[1] = $username;
            }

            $user = User::create([
                'name' => $row[0],
                'email' => $row[1],
                'password'=> bcrypt($row[2]),
                'role'     => 'student',
                'active'   => 1,
                'school_id'=> auth()->user()->school_id,
                'code'     => auth()->user()->code,
                'student_code' => $code,
                'gender' => $row[3],
                'nationality'=> $row[4],
                'address' => $row[5],
                'section_id' => $this->section

            ]);

            $student = StudentInfo::create([
                'student_id' => $code,
                'session' => now('y'),
                'version' => $row[6],
                'group'  =>  $row[7] ? $row[7] : '',
                'birthday' => Carbon::parse($row[8]),
                'father_name' => $row[9],
                'father_phone_number' => $row[10],
                'father_national_id' => $row[11] ? $row[11] : '',
                'father_occupation' => $row[12],
                'mother_name' => $row[13],
                'religion' => $row[14],
                'user_id' => $user->id,
            ]);
        }
    }
}
