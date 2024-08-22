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
        Schema::create('sensor_data', function (Blueprint $table) {
            $table->bigIncrements('data_id'); // Primary Key
            $table->unsignedBigInteger('sensor_id'); // Foreign Key to sensors table
            $table->timestamp('timestamp');
            $table->float('value');
            $table->string('unit')->nullable();
            $table->timestamps(); // This will add created_at and updated_at columns

            // Foreign Key Constraint
            $table->foreign('sensor_id')->references('sensor_id')->on('sensors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensor_data');
    }
};
