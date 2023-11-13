<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Seeder
{
   
    public function run(): void
    {
        $admin_user = [

            'name' => 'admin',
            'email' => "admin@admin.com",
            'password' => Hash::make('password'),
            'is_admin' => true

        ];


        User::create($admin_user);
        
    }
}
