<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarm_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('alarm_id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('mail_id')->unsigned()->nullable();
            $table->foreign('alarm_id')->references('id')->on('sensor_alarms');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('mail_id')->references('id')->on('mails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alarm_notifications');
    }
}
