<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi UserSeeder
        $this->call([
            UserSeeder::class,
            // Gọi các Seeder khác nếu có ở đây
            // PackageSeeder::class,
            // LocationSeeder::class,
        ]);

        // Hoặc tạo user trực tiếp ở đây nếu chỉ cần vài record
        // \App\Models\User::factory(10)->create();
    }
}
