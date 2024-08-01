<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClassificationCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the number of classification codes
        $numberOfCodes = 100; // Anda bisa menyesuaikan jumlah ini sesuai kebutuhan

        // Prepare the data to insert
        $classificationCodes = [];
        for ($i = 1; $i <= $numberOfCodes; $i++) {
            $classificationCodes[] = ['name' => 'Code ' . $i];
        }

        // Seed classification codes
        DB::table('classification_codes')->insert($classificationCodes);
    }
}
