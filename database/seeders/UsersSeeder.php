<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
                'role' => 'admin',
                'photo' => null,
                'gender' => null,
                'date_of_birth' => null,
                'address' => null,
                'phone' => null,
                'department' => null,
                'marital_status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('user123'),
                'role' => 'user',
                'photo' => null,
                'gender' => null,
                'date_of_birth' => null,
                'address' => null,
                'phone' => null,
                'department' => null,
                'marital_status' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}