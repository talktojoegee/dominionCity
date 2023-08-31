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
        Schema::create('cash_book_account_logs', function (Blueprint $table) {
            $table->id('cbal_id');
            $table->unsignedBigInteger('cbal_cashbook_account_id');
            $table->unsignedBigInteger('cbal_user_id');
            $table->unsignedBigInteger('cbal_branch_id');
            $table->tinyInteger('cbal_type')->default(1)->comment('1=Income,2=Expense');
            $table->text('cbal_narration')->nullable();
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
        Schema::dropIfExists('cash_book_account_logs');
    }
};
