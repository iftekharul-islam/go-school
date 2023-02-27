<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStudentInfos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_infos', function (Blueprint $table) {
            $table->string('mother_national_id')->nullable()->change();
            $table->string('father_national_id')->nullable()->change();
            $table->string('version')->nullable()->change();
            $table->string('group')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
