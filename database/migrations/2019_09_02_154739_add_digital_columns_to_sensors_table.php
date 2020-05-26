<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDigitalColumnsToSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_element_sensors', function (Blueprint $table) {
            $table->integer('means_up')->nullable();
            $table->integer('means_down')->nullable();
            $table->integer('use_as_digital_chart')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_element_sensors', function (Blueprint $table) {
            $table->dropColumn('means_up');
            $table->dropColumn('means_down');
            $table->dropColumn('use_as_digital_chart');
        });
    }
}
