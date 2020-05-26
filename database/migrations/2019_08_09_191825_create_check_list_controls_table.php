<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckListControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_list_controls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sub_module_id')->unsigned();
            $table->string('name');
            $table->string('type');
            $table->string('values')->nullable();
            $table->string('metric')->nullable();
            $table->boolean('is_required');

            $table->foreign('sub_module_id')->references('id')->on('check_list_sub_modules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('check_list_controls');
    }
}
