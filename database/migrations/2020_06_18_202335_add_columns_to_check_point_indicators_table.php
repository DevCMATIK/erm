<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToCheckPointIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_point_indicators', function (Blueprint $table) {
            $table->dropForeign('check_point_indicators_sensor_id_foreign');
            $table->dropForeign('check_point_indicators_to_compare_sensor_foreign');
            $table->dropColumn('sensor_id', 'to_compare_sensor');

            $table->integer('chronometer_id')->unsigned()->after('id');
            $table->integer('chronometer_to_compare')->unsigned()->nullable()->after('chronometer_id');
            $table->foreign('chronometer_id')->references('id')->on('sensor_chronometers')->onDelete('cascade');
            $table->foreign('chronometer_to_compare')->references('id')->on('sensor_chronometers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_point_indicators', function (Blueprint $table) {
            //
        });
    }
}
