<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalibrationIntervalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $intervals = [
            ['name' => 'Once a week', 'months' => 0.23],
            ['name' => 'Twice a month', 'months' => 0.5],
            ['name' => 'Once a month', 'months' => 1],
            ['name' => 'Once every 3 months', 'months' => 3],
            ['name' => 'Once every 6 months', 'months' => 6],
            ['name' => 'Once a year', 'months' => 12],
        ];

        DB::table('calibration_intervals')->insert($intervals);
    }
}
