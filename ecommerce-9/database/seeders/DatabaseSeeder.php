<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Menggunakan updateOrCreate agar aman dijalankan berkali-kali
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Pengecekan unik berdasarkan email
            [
                'name' => 'Admin',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User Biasa',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        // Panggil seeder lain jika ada
        // $this->call([
        //     ProductCategorySeeder::class,
        // ]);
    }
}