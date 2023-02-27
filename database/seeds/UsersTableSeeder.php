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

        factory(User::class, 2)->states('admin')->create();
        factory(User::class, 2)->states('accountant')->create();
        factory(User::class, 2)->states('librarian')->create();
        factory(User::class, 5)->states('teacher')->create();
        factory(User::class, 20)->states('student')->create();
    }
}
