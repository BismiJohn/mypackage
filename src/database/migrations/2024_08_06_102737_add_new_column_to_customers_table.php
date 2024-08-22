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
        Schema::table('customers', function (Blueprint $table) {
            // Add the new integer column after the 'name' column
            $table->integer('project_count')
                  ->after('name')
                  ->default(0)
                  ->check('project_count >= 0 AND project_count <= 3000');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop the column if rolling back
            $table->dropColumn('project_count');
        });
    }
};
