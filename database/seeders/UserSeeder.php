<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => env('ADMIN_USERNAME', 'admin')], // Criteria to avoid duplicities
            [
                'name' => env('ADMIN_NAME', 'Administrator'),
                'username' => env('ADMIN_USERNAME', 'admin'),
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin')),
                'is_admin' => true,
                'profile_img' => null,
            ]
        );
    }
}
