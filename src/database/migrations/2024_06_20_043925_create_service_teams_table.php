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
        Schema::create('service_teams', function (Blueprint $table) {
            $table->bigIncrements('team_id'); // Primary Key
            $table->string('name');
            $table->string('contact_email')->unique();
            $table->string('contact_phone')->unique();
            $table->timestamps(); // This will add created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_teams');
    }
};
