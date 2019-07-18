<?php

use Faker\Generator as Faker;

$factory->define(App\Gradesystem::class, function (Faker $faker) {
    return [
      'grade_system_name' => $faker->randomElement(['Grade System 1','Grade System 2']),
      'school_id' => function () use ($faker) {
          if(App\School::count() == 0)
            return factory(App\School::class)->create()->id;
          else {
            return $faker->randomElement(App\School::pluck('id')->toArray());
          }
        },
    ];
});
