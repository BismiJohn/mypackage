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
        Schema::table('device_api_data', function (Blueprint $table) {
            $table->decimal('setpoint', 4, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('device_api_data', function (Blueprint $table) {
            $table->integer('setpoint')->unsigned()->change();
        });
    }
};
