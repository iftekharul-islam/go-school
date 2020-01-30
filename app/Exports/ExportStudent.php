<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportStudent implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $students = User::with(['studentInfo', 'section.class'])->where('role', 'student')->get();
        return $students;
    }

    public function map($student): array
    {
        return [
            $student->student_code,
            $student->name,
            $student->email,
            $student->gender,
            isset($student['section']) ? $student->section->section_number : '',
            isset($student['section']) ? $student->section->class->class_number : '',
            isset($student['section']) ? $student->roll_number : '',
            $student->blood_group,
            $student->address,
            isset($student['studentInfo']) ? $student->studentInfo->father_name : '',
            isset($student['studentInfo']) ? $student->studentInfo->father_phone_number : '',
            isset($student['studentInfo']) ? $student->studentInfo->father_national_id : '',
            isset($student['studentInfo']) ? $student->studentInfo->father_occupation : '',
            isset($student['studentInfo']) ? $student->studentInfo->mother_name : '',
            isset($student['studentInfo']) ? $student->studentInfo->mother_occupation : '',
            isset($student['studentInfo']) ? $student->studentInfo->mother_phone_number : '',
            isset($student['studentInfo']) ? $student->studentInfo->mother_national_id : '',
        ];
    }

    public function headings(): array
    {
        return [
            'Student Code',
            'Student Name',
            'Email',
            'Gender',
            'Section',
            'Class',
            'Roll Number',
            'Blood Group',
            'Address',
            'Father\'s Name',
            'Father\'s Phone',
            'Father\'s NID',
            'Father\'s Occupation',
            'Mother\'s Name',
            'Mother\'s Occupation',
            'Mother\'s Phone',
            'Mother\'s NID',
        ];
    }
}
