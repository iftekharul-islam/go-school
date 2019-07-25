<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => "Augnitive",
            'email'    => 'admin@augnitive.com',
            'password' => bcrypt('secret'),
            'role'     => 'master',
            'active'   => 1,
            'verified' => 1,
        ]);

        factory(User::class, 20)->states('admin')->create();
        factory(User::class, 20)->states('accountant')->create();
        factory(User::class, 20)->states('librarian')->create();
        factory(User::class, 70)->states('teacher')->create();
        factory(User::class, 400)->states('student')->create();
    }
}
