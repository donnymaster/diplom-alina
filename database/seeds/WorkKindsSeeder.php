<?php

use App\Models\WorkKind;
use Illuminate\Database\Seeder;

class WorkKindsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $work_kinds = [
            ['Захист дисертацій', 3],
            ['Виконання наукових досліджень за цільовим фінансуванням', 3],
            ['Міжнародна науково-технічна діяльність', 3]
        ];

        foreach($work_kinds as $kind){
            WorkKind::create([
                'kind_name' => $kind[0],
                'type_work_id' => $kind[1]
            ]);
        }
    }
}
