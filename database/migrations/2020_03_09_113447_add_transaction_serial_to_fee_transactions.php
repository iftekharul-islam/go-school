<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionSerialToFeeTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('transaction_serial')->after('id')->nullable();
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
            $table->dropColumn('transaction_serial');
        });
    }
}
