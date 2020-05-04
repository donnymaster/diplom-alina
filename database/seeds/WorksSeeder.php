<?php

use App\Models\Work;
use Illuminate\Database\Seeder;

class WorksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $works = [
            ['number_indicator' => '1.1',
            'indicator' => 'Захист кандидатської дисертації',
            'norm_desc' => '-',
            'description' => '-',
            'works_kinds_id' => '1',
            'norm-hour' => '500'],

            ['number_indicator' => '1.2',
            'indicator' => 'Захист докторської дисертації',
            'norm_desc' => '-',
            'description' => '-',
            'works_kinds_id' => '1',
            'norm-hour' => '800'],

            ['number_indicator' => '1.3',
            'indicator' => 'Керівництво підготовкою кандидатської дисертації',
            'norm_desc' => '-',
            'description' => '-',
            'works_kinds_id' => '1',
            'norm-hour' => '200'],

            ['number_indicator' => '1.4',
            'indicator' => 'Керівництво підготовкою докторської дисертації',
            'norm_desc' => '-',
            'description' => '-',
            'works_kinds_id' => '1',
            'norm-hour' => '300']
        ];

        foreach($works as $work){
            Work::create($work);
        }
    }
}
