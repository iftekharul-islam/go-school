<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeSystemInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_system_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grade');
            $table->float('grade_points');
            $table->integer('marks_from');
            $table->integer('marks_to');
            $table->integer('gradesystem_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grade_system_infos');
    }
}
