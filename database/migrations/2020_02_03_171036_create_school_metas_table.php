<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolMetasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_metas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('school_id');
            $table->float('sms_charge', 8, 2);
            $table->float('per_student_charge', 8, 2);
            $table->integer('invoice_generation_date');
            $table->string('email');
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
        Schema::dropIfExists('school_metas');
    }
}
