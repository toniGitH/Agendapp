<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function createUser(string $name, string $username, string $password, $profileImg = null, bool $isAdmin = false): User
    {
        return User::create([
            'name' => $name,
            'username' => $username,
            'password' => Hash::make($password),
            'profile_img' => $profileImg ?? null,
            'is_admin' => $isAdmin
        ]);
    }
}
