<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckListModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_list_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('check_list_id')->unsigned();
            $table->string('name');
            $table->integer('position');

            $table->foreign('check_list_id')->references('id')->on('check_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_list_modules');
    }
}
