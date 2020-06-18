<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToChronometerTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chronometer_trackings', function (Blueprint $table) {
            $table->float('diff_in_seconds',255,6)->nullable()->after('end_date');
            $table->float('diff_in_minutes',255,6)->nullable()->after('diff_in_seconds');
            $table->float('diff_in_hours',255,6)->nullable()->after('diff_in_minutes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chronometer_trackings', function (Blueprint $table) {
            $table->dropColumn('diff_in_seconds', 'diff_in_minutes', 'diff_in_hours');
        });
    }
}
