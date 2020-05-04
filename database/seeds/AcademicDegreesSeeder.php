<?php

use App\Models\AcademicDegree;
use Illuminate\Database\Seeder;

class AcademicDegreesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $degrees = [
            'Кандидат наук',
            'Доктор наук'
        ];

        foreach($degrees as $degree){
            AcademicDegree::create([
                'degree_name' => $degree
            ]);
        }
    }
}
