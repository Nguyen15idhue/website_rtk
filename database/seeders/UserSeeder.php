<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB Facade
use Illuminate\Support\Facades\Hash; // Import Hash Facade
use App\Models\User; // Import User model nếu bạn muốn dùng Eloquent

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- Tạo người dùng Super Admin ---

        // Cách 1: Dùng DB Facade (Đơn giản)
        DB::table('users')->insert([
            'name' => 'Super Admin Demo',
            'email' => 'super.admin.demo@system.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Đặt mật khẩu là 'password' (Nên đổi sau)
            'created_at' => now(),
            'updated_at' => now(),
            // Thêm các trường khác nếu bảng users của bạn có (ví dụ: role)
            // 'role' => 'SuperAdmin' // Giả sử bạn có cột 'role'
        ]);

        // Cách 2: Dùng Model Factory (Nếu bạn đã định nghĩa Factory)
        // User::factory()->create([
        //     'name' => 'Super Admin Demo',
        //     'email' => 'super.admin.demo@system.com',
        //     'password' => Hash::make('password'),
        //     // 'role' => 'SuperAdmin'
        // ]);

        // --- Tạo thêm người dùng Demo thông thường (tùy chọn) ---
        DB::table('users')->insert([
            'name' => 'Người dùng Demo',
            'email' => 'demo@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
            // 'role' => 'User'
        ]);

        // User::factory()->create([
        //     'name' => 'Người dùng Demo',
        //     'email' => 'demo@example.com',
        //     'password' => Hash::make('password'),
        //     // 'role' => 'User'
        // ]);
    }
}
