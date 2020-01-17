<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeductedAdvanceAmountColumnsToFeeTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('deducted_advance_amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('deducted_advance_amount')->default(0);
        });
    }
}
