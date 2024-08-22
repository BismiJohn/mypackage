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
        Schema::create('device_api_data', function (Blueprint $table) {
            $table->id();
            $table->string('device_id');
            $table->string('mode');
            $table->string('status');
            $table->integer('fault_status');
            $table->decimal('output_injection_rate', 5, 2); // Assuming percentage with two decimal points
            $table->smallInteger('process_value'); // smallInteger supports range -32,768 to 32,767
            $table->smallInteger('hypo_setpoint'); // smallInteger supports range -32,768 to 32,767
            $table->smallInteger('chloro_setpoint'); // smallInteger supports range -32,768 to 32,767
            $table->enum('tank_level', ['ok', 'empty']);
            $table->enum('working_pump', ['M', 'S']);
            $table->decimal('flow_rate', 8, 2); // Assuming flow rate with two decimal points
            $table->decimal('weight', 5, 2); // Assuming weight with two decimal points
            $table->decimal('level_sensor', 8, 2); // Assuming level with two decimal points
            $table->string('network_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_api_data');
    }
};
