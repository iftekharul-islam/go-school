<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStudentIdentificationToStudentInfos extends Migration
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
            $table->string('student_indentification')->nullable();
            $table->index(['student_indentification']);
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
            $table->dropIndex(['student_indentification']);
            $table->dropColumn('student_indentification');
        });
    }
}
