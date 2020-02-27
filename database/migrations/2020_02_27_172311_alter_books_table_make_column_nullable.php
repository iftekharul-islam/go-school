<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBooksTableMakeColumnNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('book_code',50)->nullable()->change();
            $table->integer('quantity')->nullable()->change();
            $table->string('rackNo',10)->nullable()->change();
            $table->string('rowNo',10)->nullable()->change();
            $table->string('img_path')->nullable()->change();
            $table->text('about')->nullable()->change();
            $table->string('type',10)->nullable()->change();
            $table->integer('price')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       //
    }
}
