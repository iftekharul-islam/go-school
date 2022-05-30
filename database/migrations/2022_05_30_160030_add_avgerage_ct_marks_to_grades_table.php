<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAvgerageCtMarksToGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->float('final_quiz_mark', 8, 2)->default(0);
            $table->float('final_assignment_mark', 8, 2)->default(0);
            $table->float('final_ct_mark', 8, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn('final_quiz_mark');
            $table->dropColumn('final_assignment_mark');
            $table->dropColumn('final_ct_mark');
        });
    }
}
