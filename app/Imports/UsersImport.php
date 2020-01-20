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

            if ($this->checkDuplicate($row['name'], $row['father_name'], $row['birthday'])) {
                session()->put('duplicateWarning', true);
                continue;
            }

            $code = auth()->user()->school_id . date('y') . substr(number_format(time() * mt_rand(), 0, '', ''), 0, 5);
            $name = explode(" ", $row['name']);

            $username = array_last($name) . $code;
            $pass = $username;

            $user = User::create([
                'name' => $row['name'],
                'email' => $username,
                'password' => bcrypt($pass),
                'role' => 'student',
                'active' => 1,
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
                'birthday' => is_string($row['birthday']) ? Carbon::parse((string)$row['birthday']) : Date::excelToDateTimeObject($row['birthday']),
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
            'father_name',
            'father_phone_number',
            'father_occupation',
            'father_national_id',
            'mother_name',
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
            && array_key_exists('father_name', $all)
            && array_key_exists('father_phone_number', $all)
            && array_key_exists('father_occupation', $all)
            && array_key_exists('father_national_id', $all)
            && array_key_exists('mother_name', $all)
            && array_key_exists('religion', $all));
    }

    public function validateSheet($row)
    {
        return (isset($row['name']) && !empty($row['name'])
            && isset($row['gender']) && !empty($row['gender'])
            && isset($row['address']) && !empty($row['address'])
            && isset($row['version']) && !empty($row['version'])
            && isset($row['birthday']) && !empty($row['birthday'])
            && isset($row['father_name']) && !empty($row['father_name'])
            && isset($row['father_phone_number']) && !empty($row['father_phone_number'])
            && isset($row['father_occupation']) && !empty($row['father_occupation'])
            && isset($row['father_national_id']) && !empty($row['father_national_id'])
            && isset($row['mother_name']) && !empty($row['mother_name'])
            && isset($row['religion']) && !empty($row['religion']));
    }

    public function checkDuplicate($student_name, $father_name, $birthday)
    {
        $birth = is_string($birthday) ? Carbon::parse((string)$birthday) : Date::excelToDateTimeObject($birthday);
        $count = User::join('student_infos', 'users.id', '=', 'student_infos.user_id')
            ->where('users.name', $student_name)
            ->where('student_infos.father_name', $father_name)
            ->whereDate('student_infos.birthday', $birth)
            ->count();
        if ($count > 0) {
            return true;
        }
        return false;
    }
}
