<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_book_accounts', function (Blueprint $table) {
            $table->id('cba_id');
            $table->unsignedBigInteger('cba_branch_id');
            $table->unsignedBigInteger('cba_created_by');
            $table->dateTime('cba_date_created');
            $table->tinyInteger('cba_scope')->default(0)->comment('0=Branch,1=Region,2=Global');
            $table->tinyInteger('cba_type')->default(1)->comment('1=Normal,2=Virtual');
            $table->string('cba_name')->nullable();
            $table->string('cba_account_no')->nullable();
            $table->double('cba_amount')->default(0)->comment('opening balance|not in use');
            $table->text('cba_note')->nullable();
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
        Schema::dropIfExists('cash_book_accounts');
    }
};
