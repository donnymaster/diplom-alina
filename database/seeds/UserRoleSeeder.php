<?php

use Illuminate\Database\Seeder;
use App\Models\UserRole;
class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'user',
            'moderator',
            'admin'
        ];
    
        foreach($roles as $role){
            UserRole::create([
                'role_name' => $role
            ]);
        }
    }
}
