<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_settings', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->enum('mode', ['A', 'M']);
            $table->enum('device_status', ['ON', 'OFF']);
            $table->integer('setpoint')->unsigned()->default(0)->check(function ($column) {
                return $column >= 0 && $column <= 1400;
            });
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_settings');
    }
};
