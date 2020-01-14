<?php

namespace App\Imports;

use App\StudentInfo;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
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
        Validator::make($rows->toArray(), [
            '*.0' => 'required',
            '*.1' => 'required',
            '*.2' => 'required',
            '*.3' => 'required',
            '*.4' => 'required',
            '*.6' => 'required',
            '*.7' => 'required',
            '*.8' => 'required',
            '*.10' => 'required',
            '*.11' => 'required',
            '*.12' => 'required',
        ],[
            '*.0.required' => 'name is required',
            '*.1.required' => 'Gender is required',
            '*.2.required' => 'Nationality is required',
            '*.3.required' => 'Address is required',
            '*.4.required' => 'Version is required',
            '*.6.required' => 'Birthday is required',
            '*.7.required' => 'Father Name is required',
            '*.8.required' => 'Father Phone number is required',
            '*.10.required' => 'Father occupation is required',
            '*.11.required' => 'Mother name is required',
            '*.12.required' => 'Religion is required',
        ])->validate();

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

            StudentInfo::create([
                'student_id' => $code,
                'session' => date("Y"),
                'version' => $row[4],
                'group'  =>  $row[5] ? $row[5] : '',
                'birthday' => is_string($row[6]) ? Carbon::parse((string)$row[6]) : Date::excelToDateTimeObject($row[6]),
                'father_name' => $row[7],
                'father_phone_number' => $row[8],
                'father_national_id' => $row[9] ? $row[9] : '',
                'father_occupation' => $row[10],
                'mother_name' => $row[11],
                'religion' => $row[12],
                'user_id' => $user->id,
            ]);
        }
    }
}
