<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSchools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schools', function(Blueprint $table)
        {
            $table->string('district')->nullable();
            $table->float('sms_charge', 8, 2)->nullable();
            $table->float('per_student_charge', 8, 2)->nullable();
            $table->integer('invoice_generation_date')->nullable();
            $table->string('email')->nullable();
            $table->date('singup_date')->nullable();
            $table->integer('due_date')->nullable();
            $table->tinyInteger('is_sms_enable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schools', function(Blueprint $table)
        {
            $table->dropColumn('district');
            $table->dropColumn('sms_charge');
            $table->dropColumn('per_student_charge');
            $table->dropColumn('invoice_generation_date');
            $table->dropColumn('email');
            $table->dropColumn('singup_date');
            $table->dropColumn('due_date');
            $table->dropColumn('is_sms_enable');
        });
    }
}
