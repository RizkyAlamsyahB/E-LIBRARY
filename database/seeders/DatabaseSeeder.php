<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Call other seeders
        $this->call([
            DivSubSeeder::class,
            PersonsInChargeSeeder::class,
            DocumentStatusSeeder::class,
            UsersSeeder::class,
            ClassificationCodesSeeder::class,
        ]);
    }
}
