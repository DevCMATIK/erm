<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('import_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('file');
            $table->char('extension',40);
            $table->tinyInteger('imported');
            $table->boolean('before_function');
            $table->boolean('after_function');
            $table->timestamps();

            $table->foreign('import_id')->references('id')->on('imports');
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
        Schema::dropIfExists('import_files');
    }
}
