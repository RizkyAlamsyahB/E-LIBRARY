<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the document statuses
        $documentStatuses = [
            ['status' => 'Confidential'],
            ['status' => 'Public'],
            ['status' => 'Restricted']
        ];

        // Seed document statuses
        DB::table('document_status')->insert($documentStatuses);
    }
}
