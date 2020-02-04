<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class AbsentExport implements FromCollection, WithMapping, WithHeadings
{
    protected  $section_id ;
    public  function __construct($section_id)
    {
        $this->section_id = $section_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $students = User::join('student_infos', 'users.id', '=', 'student_infos.user_id')
                    ->join('attendances', 'users.id', '=', 'attendances.student_id' )
                    ->whereDate('attendances.created_at', Carbon::today())
                    ->where('attendances.present', 0)
                    ->where('attendances.section_id', $this->section_id)
                    ->select('users.name', 'student_infos.guardian_name', 'student_infos.father_name', 'student_infos.father_phone_number', 'student_infos.guardian_phone_number', 'student_infos.roll_number')
                    ->get();
         return $students;
    }


    public function map($student): array
    {
        return [
            isset($student['name']) ?  $student->name : '',
            isset($student['roll_number']) ? $student->roll_number : 'N/A',
            isset($student['guardian_name']) ? $student->guardian_name : $student->father_name,
            isset($student['guardian_phone_number']) ? $student->guardian_phone_number : $student->father_phone_number,
        ];
    }

    public function headings(): array
    {
        return [
            'Student Name',
            'Roll Number',
            'Guardian\'s Name',
            'Guardian\'s Phone Number'
        ];
    }
}
