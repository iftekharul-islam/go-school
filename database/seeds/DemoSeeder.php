<?php

use Illuminate\Database\Seeder;
use App\School;
use App\User;
use App\AccountSector;
use App\StudentInfo;
use App\Myclass;
use App\Section;
use App\Book;

use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $school =  School::create([
            'name'      => 'Demo School',
            'about'     => 'This is a demo school',
            'medium'    => 'bangla',
            'code'      => date("y").substr(number_format(time() * mt_rand(),0,'',''),0,6),
            'theme'     => 'flatly',
            'school_address' => 'House#39, Road#7, Block-C, Mirpur-12, Dhaka',

       ]);

       $admin = User::create([
               'name'     => "Admin",
               'email'    => 'admin@shoroborno.com',
               'password' => bcrypt('admin'),
               'role'     => 'admin',
               'phone_number' => '+8801711541641',
               'active'   => 1,
               'verified' => 1,
               'school_id' => $school->id,
               'code' => rand(100000,999999),
               'student_code' => rand(10000,99999),
           ]);

        User::create([
            'name'     => "Teacher",
            'email'    => 'teacher@shoroborno.com',
            'password' => bcrypt('teacher'),
            'role'     => 'teacher',
            'phone_number' => '+8801711541222',
            'active'   => 1,
            'verified' => 1,
            'school_id' => $school->id,
            'code'     => rand(100000,999999),
            'student_code' => rand(10000,99999),
        ]);

       $accountant = User::create([
           'name'     => "Accountant",
           'email'    => 'accountant@shoroborno.com',
           'password' => bcrypt('accountant'),
           'role'     => 'accountant',
           'phone_number' => '+880171154333',
           'active'   => 1,
           'verified' => 1,
           'school_id' => $school->id,
           'code'     => rand(100000,999999),
           'student_code' => rand(10000,99999),
       ]);
       $librarian =  User::create([
            'name'     => "Librarian",
            'email'    => 'librarian@shoroborno.com',
            'password' => bcrypt('librarian'),
            'role'     => 'librarian',
           'phone_number' => '+8801711541555',
            'active'   => 1,
            'verified' => 1,
            'school_id' => $school->id,
            'code'     => rand(100000,999999),
            'student_code' => rand(10000,99999),
        ]);

           AccountSector::create([
               'name' => 'demoaccountsector',
               'type' => 'income',
               'school_id' => $school->id,
               'user_id' => $accountant->id,


           ]);
                       $class = Myclass::create([
                    'class_number' => '1',
                    'school_id' => $school->id,
                    'group' =>'A',

           ]);
           $section = Section::create([
               'section_number' => 'A',
               'room_number' => '1',
               'class_id' =>$class->id,
               'user_id' => $admin->id,

           ]);
           Book::create([
               'book_code' => str_random('4'),
               'title'     => 'demo book',
               'author'     => 'Mr demo',
               'quantity'  => 10,
               'rackNo'    => 4,
               'rowNo'     => 5,
               'type'      => 'Academic',
               'price'     => 1000,
               'class_id'  => $class->id,
               'school_id' => $school->id,
               'user_id'   => $librarian->id,
               'img_path' => 'https://images.tandf.co.uk/common/jackets/amazon/978143981/9781439813263.jpg',
               'about' => 'demo book',


           ]);
        $student = User::create([
            'name'       => "Student",
            'email'      => 'student@shoroborno.com',
            'password'   => bcrypt('student'),
            'role'       => 'student',
            'phone_number' => '+8801711541111',
            'active'     => 1,
            'verified'   => 1,
            'school_id'  => $school->id,
            'section_id' => $section->id,
            'student_code' => rand(10000,99999),


        ]);
        StudentInfo::create([
            'student_id'           => $student->id,
            'session'              => '2018',
            'version'              => 'bangla',
            'group'                => 'science',
            'birthday'             => date('Y-m-d H:i:s'),
            'religion'             => 'islam',
            'father_name'          => 'Jhon Doe',
            'father_phone_number'  => str_random(7),
            'father_national_id'   => "SA0218IBYZVZJSEC8536V4XC",
            'father_occupation'    => 'Police',
            'father_designation'   => 'Officer',
            'father_annual_income' => '1000000',
            'mother_name'          => 'marik',
            'mother_phone_number'  => str_random(7),
            'mother_national_id'   => 'SA0218IBYZVZJSEC8536V4XC',
            'mother_occupation'    => 'collector',
            'mother_designation'   => 'officer',
            'user_id'              => $student->id

        ]);





    }
}
