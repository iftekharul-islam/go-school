<?php

use Illuminate\Database\Seeder;

class FeeTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'January', 'code' => 'january', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'February', 'code' => 'february', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'March', 'code' => 'march', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'April', 'code' => 'april', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'May', 'code' => 'may', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'June', 'code' => 'june', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'July', 'code' => 'july', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'August', 'code' => 'august', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'September', 'code' => 'september', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'October', 'code' => 'october', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'November', 'code' => 'november', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
            ['name' => 'December', 'code' => 'december', 'school_id' => 1, 'description' => 'Test month', 'year'=> '2019', 'type' => 'recurrent'],
        ];

        foreach ($items as $item) {
            \App\FeeType::create($item);
        }
    }
}
