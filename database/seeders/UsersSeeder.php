<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => (string) Str::uuid(), // Generate UUID
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'photo' => null,
                'gender' => null,
                'date_of_birth' => null,
                'phone' => null,
                'division_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(), // Generate UUID
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => Hash::make('user123'),
                'email_verified_at' => now(),
                'role' => 'user',
                'photo' => null,
                'gender' => null,
                'date_of_birth' => null,
                'phone' => null,
                'division_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
