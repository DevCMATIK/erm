<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotificationRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_notification_reminders', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('alarm_notification_id')->unsigned();

            $table->primary(['user_id','alarm_notification_id'],'alarm_notif_user_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_notification_reminders');
    }
}
