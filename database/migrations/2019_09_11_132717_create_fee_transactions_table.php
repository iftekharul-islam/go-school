<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id');
            $table->integer('school_id');
            $table->double('amount');
            $table->integer('discount_id')->nullable();
            $table->double('discount');
            $table->double('fine');
            $table->string('status');
            $table->string('mode')->nullable();
            $table->integer('fee_master_id');
            $table->integer('accountant_id');
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
        Schema::dropIfExists('fee_transactions');
    }
}
