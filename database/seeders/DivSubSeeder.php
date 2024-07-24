<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DivSubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the number of divisions and subsections
        $numberOfDivisions = 20;
        $numberOfSubsections = 20;

        // Seed divisions
        $divisions = [];
        for ($i = 1; $i <= $numberOfDivisions; $i++) {
            $divisions[] = ['name' => 'Division ' . $i];
        }
        DB::table('divisions')->insert($divisions);

        // Seed subsections
        $subsections = [];
        for ($i = 1; $i <= $numberOfSubsections; $i++) {
            $subsections[] = ['name' => 'Subsection ' . chr(64 + $i)];
        }
        DB::table('subsections')->insert($subsections);

        // Retrieve IDs of inserted divisions and subsections
        $divisionIds = DB::table('divisions')->pluck('id');
        $subsectionIds = DB::table('subsections')->pluck('id');

        // Create relationships between divisions and subsections
        $divisionSubsectionData = [];
        foreach ($divisionIds as $index => $divisionId) {
            // Ensure that each division is associated with one subsection
            $subsectionId = $subsectionIds[$index % count($subsectionIds)];

            $divisionSubsectionData[] = [
                'division_id' => $divisionId,
                'subsection_id' => $subsectionId
            ];
        }

        // Insert division_subsection relationships
        DB::table('division_subsection')->insert($divisionSubsectionData);
    }
}
