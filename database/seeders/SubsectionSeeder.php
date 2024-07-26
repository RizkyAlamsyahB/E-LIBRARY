<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubsectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $subsections = [];

        // Menggunakan loop untuk membuat data
        for ($i = 1; $i <= 20; $i++) {
            $subsections[] = ['name' => 'Subbagian ' . $i];
        }

        // Insert data ke tabel
        DB::table('subsections')->insert($subsections);
    }
}
