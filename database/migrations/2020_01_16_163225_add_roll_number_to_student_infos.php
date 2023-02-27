<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRollNumberToStudentInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_infos', function(Blueprint $table)
        {
            $table->integer('roll_number')->nullable();
            $table->index(['roll_number']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_infos', function(Blueprint $table)
        {
            $table->dropIndex(['roll_number']);
            $table->dropColumn('roll_number');
        });
    }
}
