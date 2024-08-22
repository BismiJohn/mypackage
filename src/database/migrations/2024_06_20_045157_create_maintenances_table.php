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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->bigIncrements('maintenance_id'); // Primary Key
            $table->unsignedBigInteger('sensor_id'); // Foreign Key to sensors table
            $table->unsignedBigInteger('team_id'); // Foreign Key to service_teams table
            $table->text('description');
            $table->date('maintenance_date');
            $table->enum('status', ['Completed', 'Pending']);
            $table->timestamps(); // This will add created_at and updated_at columns

            // Foreign Key Constraints
            $table->foreign('sensor_id')->references('sensor_id')->on('sensors')->onDelete('cascade');
            $table->foreign('team_id')->references('team_id')->on('service_teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
