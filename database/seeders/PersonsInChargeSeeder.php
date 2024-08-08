<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonsInChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define the number of persons in charge
        $numberOfPersons = 50;

        // Seed persons in charge
        $personsInCharge = [];
        for ($i = 1; $i <= $numberOfPersons; $i++) {
            $personsInCharge[] =
                [
                    'id' => Str::uuid(),
                    'name' => 'person ' . $i
                ];
        }
        DB::table('persons_in_charge')->insert($personsInCharge);
    }
}
