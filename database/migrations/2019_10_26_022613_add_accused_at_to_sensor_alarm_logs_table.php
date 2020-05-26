<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccusedAtToSensorAlarmLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sensor_alarm_logs', function (Blueprint $table) {
            $table->dateTime('accused_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sensor_alarm_logs', function (Blueprint $table) {
            $table->dropColumn('accused_at');
        });
    }
}
