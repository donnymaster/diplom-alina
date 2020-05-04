<?php

use App\Models\CategoryWork;
use Illuminate\Database\Seeder;

class CategotyWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'державний бюджет',
            'друга половина дня',
            'господарський договір'
        ];

        foreach($categories as $category){
            CategoryWork::create([
                'category_name' => $category,
                'category_id' => 1
            ]);
        }
    }
}
