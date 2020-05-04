<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->name(),
        'surname' => $faker->lastName(),
        'patronymic' => $faker->lastName(),
        'post_id' => rand(1,7),
        'degree_id' => rand(1,2),
        'department_id' => rand(1,6)
    ];
});
