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
        Schema::table('sensors', function (Blueprint $table) {
            $table->date('warranty_date')->nullable(); // Added warranty_date
            $table->string('maintainor')->nullable(); // Added maintainor
            $table->integer('calibration_frequency')->nullable(); // Added calibration_frequency
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sensors', function (Blueprint $table) {
            $table->dropColumn('warranty_date');
            $table->dropColumn('maintainor');
            $table->dropColumn('calibration_frequency');
        });
    }
};
