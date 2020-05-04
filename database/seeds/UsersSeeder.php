<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 9)->create();

        User::create([
            'role_id' => 3,
            'password' => Hash::make('sasha123'),
            'employee_id' => 10,
            'email' => 'admin@admin.com'
        ]);
    }
}
