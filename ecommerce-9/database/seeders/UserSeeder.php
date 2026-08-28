<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createUser('Admin', 'admin@example.com', 'adminpassword', 'admin');
        $this->createUser('User', 'user@example.com', 'userpassword', 'user');
    }

    private function createUser(
        string $name,
        string $email,
        string $password,
        string $role
    ){
        $checkUser = User::where('email', $email)->first();
        if ($checkUser) {
            return;
        }
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);
    }
}