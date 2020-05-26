<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportReminderFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('export_reminder_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('export_reminder_id')->unsigned();
            $table->string('file');
            $table->string('display_name');
            $table->foreign('export_reminder_id')->references('id')->on('export_reminders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('export_reminder_files');
    }
}
