<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceSchedulesTable extends Migration
{
    public function up()
    {
        Schema::create('maintenance_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->foreign('device_id')->references('sensor_id')->on('sensors')->onDelete('cascade');
            $table->unsignedBigInteger('calibration_id');
            $table->foreign('calibration_id')->references('id')->on('calibration_intervals')->onDelete('cascade');
            $table->date('maintenance_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintenance_schedules');
    }
}

