<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRoleSeeder::class);
        $this->call(AcademicDegreesSeeder::class);
        $this->call(PostsSeeder::class);
        $this->call(FacultesSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(EmployeesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(TypeWorksSeeder::class);
        $this->call(WorkKindsSeeder::class);
        $this->call(WorksSeeder::class);
        $this->call(CategoryNameSeeder::class);
        $this->call(CategotyWorkSeeder::class);
    }
}
