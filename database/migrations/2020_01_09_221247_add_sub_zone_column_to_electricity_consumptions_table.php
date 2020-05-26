<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubZoneColumnToElectricityConsumptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('electricity_consumptions', function (Blueprint $table) {
            $table->integer('sub_zone_id')->unsigned()->nullable();
            $table->string('sensor_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('electricity_consumptions', function (Blueprint $table) {
            $table->dropColumn('sub_zone_id');
            $table->dropColumn('sensor_type');
        });
    }
}
