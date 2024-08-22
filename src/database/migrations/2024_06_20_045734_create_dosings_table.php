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
        Schema::create('dosing_units', function (Blueprint $table) {
            $table->bigIncrements('unit_id'); // Primary Key
            $table->unsignedBigInteger('project_id'); // Foreign Key to projects table
            $table->unsignedBigInteger('location_id'); // Foreign Key to locations table
            $table->string('dosing_type');
            $table->date('installation_date');
            $table->enum('status', ['Active', 'Inactive']);
            $table->timestamps(); // This will add created_at and updated_at columns

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
        Schema::dropIfExists('dosings');
    }
};
