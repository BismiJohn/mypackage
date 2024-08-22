<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->bigIncrements('sensor_id'); 
            $table->unsignedBigInteger('project_id');
            $table->string('sensor_type');
            $table->unsignedBigInteger('location_id');
            $table->date('installation_date');
            $table->date('last_calibration_date')->nullable();
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->foreign('location_id')->references('location_id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
