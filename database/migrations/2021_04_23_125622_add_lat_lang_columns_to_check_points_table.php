<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatLangColumnsToCheckPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_points', function (Blueprint $table) {
            $table->decimal('lng', 10, 8)->nullable();
            $table->decimal('lat', 11, 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_points', function (Blueprint $table) {
            //
        });
    }
}
