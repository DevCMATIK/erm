<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDeviceDataCheckTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('device_data_checks',function(Blueprint $table){
            $table->dropColumn('data');
            $table->string('address')->after('device_id');
            $table->boolean('check')->after('address')->default(0);
            $table->integer('month')->after('check');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('device_data_checks',function(Blueprint $table){
            $table->text('data')->nullable();
            $table->dropColumn('address');
            $table->dropColumn('check');
            $table->dropColumn('month');
        });
    }
}
