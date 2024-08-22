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
        Schema::create('alerts', function (Blueprint $table) {
            $table->bigIncrements('alert_id'); // Primary Key
            $table->unsignedBigInteger('sensor_id'); // Foreign Key to sensors table
            $table->string('alert_type');
            $table->text('alert_message');
            $table->timestamp('timestamp');
            $table->enum('status', ['Active', 'Resolved'])->default('Active');
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
        Schema::dropIfExists('alerts');
    }
};
