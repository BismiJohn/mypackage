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
            // Add indexing
            $table->index('device_id');
            $table->index('date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down()
    {
        Schema::table('device_api_data', function (Blueprint $table) {
            // Drop the indexes
            $table->dropIndex(['device_id']);
            $table->dropIndex(['date_time']);
        });
    }
};
