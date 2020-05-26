<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mail_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('frequency')->nullable();
            $table->string('start_at')->nullable();
            $table->boolean('is_active');
            $table->dateTime('last_execution')->nullable();
            $table->softDeletes();
            $table->foreign('mail_id')->references('id')->on('mails');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_reports');
    }
}
