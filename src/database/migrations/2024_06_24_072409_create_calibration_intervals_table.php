<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalibrationIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('calibration_intervals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('months')->nullable();
            $table->timestamps();
        });

        // Insert default calibration intervals
        $this->insertDefaultCalibrationIntervals();
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('calibration_intervals');
    }

    /**
     * Seed default calibration intervals data.
     */
    private function insertDefaultCalibrationIntervals()
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
