<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderColumnToFeeTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fee_types', function (Blueprint $table) {
            $table->bigInteger('order')->nullable();
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fee_types', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->text('description')->nullable(false)->change();
        });
    }
}
