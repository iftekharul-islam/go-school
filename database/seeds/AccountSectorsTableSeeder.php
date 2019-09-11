<?php

use Illuminate\Database\Seeder;

class AccountSectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AccountSector::class, 5)->create();
    }
}
