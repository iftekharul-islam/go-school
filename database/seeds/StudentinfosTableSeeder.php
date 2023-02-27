<?php

use App\StudentInfo;
use Illuminate\Database\Seeder;

class StudentinfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(StudentInfo::class, 5)->states('without_group')->create();
        factory(StudentInfo::class, 2)->states('science')->create();
        factory(StudentInfo::class, 1)->states('commerce')->create();
        factory(StudentInfo::class, 1)->states('arts')->create();
    }
}
