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
            // Drop the chloro_setpoint column
            $table->dropColumn('chloro_setpoint');

            // Rename hypo_setpoint to setpoint
            $table->renameColumn('hypo_setpoint', 'setpoint');

            // Change mode and status to specific strings
            $table->enum('mode', ['A', 'M'])->change();
            $table->enum('status', ['ON', 'OFF'])->change();

            // Change fault_status to integers 0 to 7
            $table->tinyInteger('fault_status')->unsigned()->change();

            // Change network_status to integers 0 to 31
            $table->tinyInteger('network_status')->unsigned()->change();

            // Add new columns
            $table->tinyInteger('alerts')->after('network_status');
            $table->string('option1', 255)->after('alerts');
            $table->string('option2', 255)->after('option1');
            $table->string('option3', 255)->after('option2');
            $table->string('option4', 255)->after('option3');
            $table->string('special_text', 255)->after('option4');
            $table->tinyInteger('new_settings')->unsigned()->default(0)->after('special_text');
            $table->timestamp('date_time')->after('new_settings');

            // Change level_sensor to specific strings
            $table->enum('level_sensor', ['N', 'F'])->change();

            // Change tank_level_sensor to 0 or 1
            $table->tinyInteger('tank_level')->unsigned()->change();

            // Change working_pump to specific strings
            $table->enum('working_pump', ['M', 'S'])->change();
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
            // Add the chloro_setpoint column back
            $table->smallInteger('chloro_setpoint');

            // Rename setpoint back to hypo_setpoint
            $table->renameColumn('setpoint', 'hypo_setpoint');

            // Change mode and status back to strings
            $table->string('mode')->change();
            $table->string('status')->change();

            // Change fault_status back to integers
            $table->integer('fault_status')->change();

            // Change network_status back to varchar
            $table->string('network_status')->change();

            // Drop the new columns
            $table->dropColumn(['alerts', 'option1', 'option2', 'option3', 'option4', 'special_text', 'new_settings', 'date_time']);


            // Change level_sensor back to decimal
            $table->decimal('level_sensor', 8, 2)->change();

            // Change tank_level_sensor back to enum
            $table->enum('tank_level', ['ok', 'empty'])->change();

            // Change working_pump back to enum
            $table->enum('working_pump', ['M', 'S'])->change();
        });
    }
};
