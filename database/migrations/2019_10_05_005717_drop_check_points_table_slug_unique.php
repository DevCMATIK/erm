<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropCheckPointsTableSlugUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_points', function(Blueprint $table)
        {
            $table->dropUnique('check_points_slug_unique');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_points', function(Blueprint $table)
        {
            //Put the index back when the migration is rolled back
            $table->unique('slug');

        });
    }
}
