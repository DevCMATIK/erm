<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToMapLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('map_lines', function (Blueprint $table) {
            $table->decimal('one_lng', 10, 8)->nullable();
            $table->decimal('one_lat', 11, 8)->nullable();
            $table->decimal('two_lng', 10, 8)->nullable();
            $table->decimal('two_lat', 11, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('map_lines', function (Blueprint $table) {
            //
        });
    }
}
