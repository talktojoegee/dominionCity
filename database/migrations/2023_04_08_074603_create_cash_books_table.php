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
        Schema::create('cash_books', function (Blueprint $table) {
            $table->id('cashbook_id');
            $table->unsignedBigInteger('cashbook_user_id');
            $table->unsignedBigInteger('cashbook_branch_id');
            $table->unsignedBigInteger('cashbook_category_id')->nullable()->comment('from transaction_category');
            $table->unsignedBigInteger('cashbook_transaction_type')->default(1)->comment('1=Income,2=Expense');
            $table->unsignedBigInteger('cashbook_currency_id')->nullable();
            $table->unsignedBigInteger('cashbook_account_id')->nullable();
            $table->unsignedBigInteger('cashbook_actioned_by')->nullable();
            $table->dateTime('cashbook_transaction_date')->nullable();
            $table->integer('cashbook_month')->nullable();
            $table->integer('cashbook_year')->nullable();
            $table->string('cashbook_ref_code')->nullable();
            $table->text('cashbook_description')->nullable();
            $table->text('cashbook_narration')->nullable();
            $table->double('cashbook_debit')->default(0);
            $table->double('cashbook_credit')->default(0);
            $table->tinyInteger('cashbook_status')->default(0)->comment('0=new submission,1=posted,2=discarded');
            $table->tinyInteger('cashbook_level')->default(0)->comment('0=Branch,1=Region,2=Global');
            $table->tinyInteger('cashbook_remit_table')->default(0)->comment('1=Yes,0=No');
            $table->tinyInteger('cashbook_remittance_paid')->default(2)->comment('1=Yes,2=No,3=waived');
            $table->dateTime('cashbook_date_actioned')->nullable();
            $table->text('cashbook_actioned_comment')->nullable();
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
        Schema::dropIfExists('cash_books');
    }
};
