<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Bắt buộc phải import cái này để mã hóa mật khẩu

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo tài khoản Admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('admin123456789'), // Mã hóa mật khẩu
            'role'     => 'admin', // Cấp quyền admin để qua được middleware
        ]);

    }
}