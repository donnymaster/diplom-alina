<?php

use App\Models\CategoryName;
use Illuminate\Database\Seeder;

class CategoryNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryName::create([
            'name' => 'Научна робота'
        ]);
    }
}
