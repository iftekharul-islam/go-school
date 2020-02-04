<?php

namespace App\Imports;

use App\StudentInfo;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DateTime;

class UsersImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function __construct($section)
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
        foreach ($rows as $key => $row) {

            if (!$this->validateHeaderRow($row)) {
                session()->put('headerwarining', true);
                session()->put('error_head', $this->error_head);
                break;
            }

            if (!$this->validateSheet($row)) {
                session()->put('importWarning', true);
                $error_rows[] = $key + 1;
                continue;
            }

            if ($this->checkDuplicate($row['name'], $row['guardian_name'], $row['birthday'])) {
                session()->put('duplicateWarning', true);
                continue;
            }

            $code = auth()->user()->school_id . date('y')
                . substr(time() * mt_rand() + pow(mt_rand(),2), -4)
                . substr(mt_rand(), -1);
            $name = explode(" ", $row['name']);

            $username = array_last($name) . $code;
            $pass = $username;

            $user = User::create([
                'name' => $row['name'],
                'email' => $username,
                'password' => bcrypt($pass),
                'role' => 'student',
                'active' => 1,
                'blood_group'=> isset($row['blood_group']) ? $row['blood_group'] : 'N/A',
                'school_id' => auth()->user()->school_id,
                'code' => auth()->user()->code,
                'student_code' => $code,
                'gender' => $row['gender'],
                'nationality' => $row['nationality'] ? $row['nationality'] : 'Bangladeshi',
                'address' => $row['address'],
                'section_id' => $this->section,
            ]);

            StudentInfo::create([
                'student_id' => $code,
                'session' => date("Y"),
                'student_indentification' => isset($row['student_indentification']) ? $row['student_indentification'] : '',
                'roll_number' => isset($row['roll_number']) ? $row['roll_number'] : null,
                'version' => $row['version'],
                'shift' => isset($row['shift']) ? $row['shift'] : '',
                'group' => isset($row['group']) ? $row['group'] : '',
                'birthday' => is_string($row['birthday']) ? Carbon::createFromFormat('d/m/Y', $row['birthday']) : Date::excelToDateTimeObject($row['birthday']),
                'guardian_name' => $row['guardian_name'],
                'guardian_phone_number' => $row['guardian_phone_number'],
                'father_name' => $row['father_name'],
                'father_phone_number' => $row['father_phone_number'],
                'father_national_id' => $row['father_national_id'],
                'father_occupation' => $row['father_occupation'],
                'mother_name' => $row['mother_name'],
                'religion' => $row['religion'],
                'user_id' => $user->id,
            ]);

        }
        session()->put('error_rows', $error_rows);
    }

    public function validateHeaderRow($row)
    {
        $all = $row->toArray();
        $validhead = [
            'name',
            'gender',
            'address',
            'version',
            'birthday',
            'guardian_name',
            'guardian_phone_number',
            'religion',
        ];
        foreach ($validhead as $item)
        {
            if (!array_key_exists($item, $all))
            {
             $this->error_head[] = $item;
            }
        }
        return (array_key_exists('name', $all)
            && array_key_exists('gender', $all)
            && array_key_exists('address', $all)
            && array_key_exists('version', $all)
            && array_key_exists('birthday', $all)
            && array_key_exists('guardian_name', $all)
            && array_key_exists('guardian_phone_number', $all)
            && array_key_exists('religion', $all));
    }

    public function validateSheet($row)
    {
        return (isset($row['name']) && !empty($row['name'])
            && isset($row['gender']) && !empty($row['gender'])
            && isset($row['address']) && !empty($row['address'])
            && isset($row['version']) && !empty($row['version'])
            && isset($row['birthday']) && !empty($row['birthday']) && $this->datecheck($row['birthday']) == true
            && isset($row['guardian_name']) && !empty($row['guardian_name'])
            && isset($row['guardian_phone_number']) && !empty($row['guardian_phone_number'])
            && isset($row['religion']) && !empty($row['religion']));


    }

    public function checkDuplicate($student_name, $guardian_name, $birthday)
    {
        $birth = is_string($birthday) ? Carbon::createFromFormat('d/m/Y', (string)$birthday) : Date::excelToDateTimeObject($birthday);
        $count = User::join('student_infos', 'users.id', '=', 'student_infos.user_id')
            ->where('users.name', $student_name)
            ->where('student_infos.guardian_name', $guardian_name)
            ->whereDate('student_infos.birthday', $birth)
            ->count();
        if ($count > 0) {
            return true;
        }
        return false;
    }
    public function datecheck($row)
    {
        $status = false;
        if (preg_match("/[a-z]/i",$row))
        {
            $status = true;
        }
        $status = $this->validateDate($row);
        return $status;
    }
    public function validateDate($date, $format = 'd/m/Y')
    {
        if(is_string($date)){
            $d = DateTime::createFromFormat($format, $date);
            return $d && $d->format($format) === $date;
        }
        return true;
    }
}
