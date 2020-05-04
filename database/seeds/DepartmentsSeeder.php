<?php

use App\Models\Departments;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departaments = [
            ['Кафедра автоматизації і комп’ютерних технологій', 7, 'Сімкін Олександр Ісакович'],
            ['Кафедра біомедичної інженерії', 7, 'Азархов Олександр Юрійович'],
            ['Кафедра вищої та прикладної математики', 7, 'Холькін Олександр Михайлович'],
            ['Кафедра інформатики', 7, 'Міроненко Дмитро Сергійович'],
            ['Кафедра комп’ютерних наук', 7, 'Федосова Ірина Василівна'],
            ['Кафедра фізики', 7, 'Єфременко Василь Георгієвич']
        ];

        foreach($departaments as $department){
            Departments::create([
                'departament_name' => $department[0],
                'faculty_id' => $department[1],
                'head_departament' => $department[2]
            ]);
        }
    }
}
