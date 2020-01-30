<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStudentInfosChangeFatherMotherField extends Migration
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
            $table->string('father_name')->nullable()->change();
            $table->string('father_phone_number')->nullable()->change();
            $table->string('father_national_id')->nullable()->change();
            $table->string('mother_name')->nullable()->change();
            $table->string('mother_phone_number')->nullable()->change();
            $table->string('mother_national_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_infos', function(Blueprint $table) {
            $table->string('father_name')->nullable(false)->change();
            $table->string('father_phone_number')->nullable(false)->change();
            $table->string('father_national_id')->nullable(false)->change();
            $table->string('mother_name')->nullable(false)->change();
            $table->string('mother_phone_number')->nullable(false)->change();
            $table->string('mother_national_id')->nullable(false)->change();
        });
    }
}
