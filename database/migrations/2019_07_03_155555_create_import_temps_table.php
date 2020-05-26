<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('import_file_id')->unsigned();
            $table->integer('row_num');
            $table->text('data');
            $table->boolean('processed');
            $table->string('feedback')->nullable();
            $table->foreign("import_file_id")->references("id")->on("import_files");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('import_temps');
    }
}
