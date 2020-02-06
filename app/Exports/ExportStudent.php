<?php

namespace App\Exports;

use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportStudent implements FromCollection, WithMapping, WithHeadings
{
    protected $keys;

    public function __construct($keys)
    {
        $this->keys = $keys;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $students = User::with(['studentInfo', 'section.class'])
            ->where( 'role', 'student' )
            ->where( 'school_id', Auth::user()->school_id )
            ->when(!empty($this->keys['section_id']), function($query) {
                return $query->where('section_id', $this->keys['section_id']);
            })
            ->when( !empty($this->keys['student_name']), function($query) {
                return $query->where('name', 'like',"%{$this->keys['student_name']}%");
            })
            ->get();

        return $students;
    }

    public function map($student): array {
        return [
            isset($student['student_code']) ? $student['student_code']  : '',
            isset($student['name']) ?  $student['name'] : '',
            isset($student['email']) ?  $student['email']  : '',
            isset($student['gender']) ?  $student['gender']  : '',
            isset($student['section']) ? $student->section['section_number'] : '',
            isset($student['section']) ? $student->section->class['class_number'] : '',
            isset($student['section']) ? $student['roll_number'] : '',
            isset($student['blood_group']) ? $student['blood_group'] : '',
            isset($student['address']) ? $student['address'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['father_name'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['father_phone_number'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['father_national_id'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['father_occupation'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['mother_name'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['mother_occupation'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['mother_phone_number'] : '',
            isset($student['studentInfo']) ? $student->studentInfo['mother_national_id'] : '',
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
