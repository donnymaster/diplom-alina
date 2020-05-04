<?php

use App\Models\TypeWork;
use Illuminate\Database\Seeder;

class TypeWorksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type_works = [
            'Навчальна робота',
            'Методична робота',
            'Наукова робота',
            'Організаційна робота',
            'Культурно-виховна'
        ];

        foreach($type_works as $type){
            TypeWork::create([
                'name_type_work' => $type
            ]);
        }
    }
}
