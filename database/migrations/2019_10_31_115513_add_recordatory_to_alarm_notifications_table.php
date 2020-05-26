<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecordatoryToAlarmNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('alarm_notifications', function (Blueprint $table) {
            $table->integer('reminder_id')->unsigned()->nullable();
            $table->foreign('reminder_id')->references('id')->on('mails');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alarm_notifications', function (Blueprint $table) {
            $table->dropForeign('alarm_notifications_mails_reminder_id_foreign');
            $table->dropColumn('reminder_id');
        });
    }
}
