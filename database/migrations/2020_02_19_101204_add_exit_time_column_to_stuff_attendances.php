<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExitTimeColumnToStuffAttendances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stuff_attendances', function (Blueprint $table) {
            $table->timestamp('exit_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stuff_attendances', function (Blueprint $table) {
            $table->dropColumn('exit_time');
        });
    }
}
