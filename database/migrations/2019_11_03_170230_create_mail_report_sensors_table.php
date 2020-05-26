<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailReportSensorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_report_sensors', function (Blueprint $table) {
            $table->integer('mail_report_id')->unsigned();
            $table->integer('sensor_id')->unsigned();

            $table->primary(['sensor_id','mail_report_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_report_sensors');
    }
}
