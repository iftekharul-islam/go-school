<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableStudentInfosGuardianField extends Migration
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
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone_number')->nullable();
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
            $table->dropColumn('guardian_name');
            $table->dropColumn('guardian_phone_number');
        });
    }
}
