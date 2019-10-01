<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeeMasterFeeTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fee_master_fee_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_master_id')->unsigned();
            $table->integer('fee_transaction_id')->unsigned();
            $table->foreign('fee_master_id')->references('id')->on('fee_masters')->onDelete('cascade');
            $table->foreign('fee_transaction_id')->references('id')->on('fee_transactions')->onDelete('cascade');
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
        Schema::dropIfExists('fee_master_fee_transaction');
    }
}
