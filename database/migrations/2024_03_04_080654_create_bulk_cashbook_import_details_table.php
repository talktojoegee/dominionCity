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
        Schema::create('bulk_cashbook_import_details', function (Blueprint $table) {
            $table->id('bcid_id');
            $table->unsignedBigInteger('bcid_master_id');
            $table->unsignedBigInteger('bcid_user_id');
            $table->unsignedBigInteger('bcid_branch_id');
            $table->unsignedBigInteger('bcid_category_id')->nullable()->comment('from transaction_category');
            $table->unsignedBigInteger('bcid_transaction_type')->default(1)->comment('1=Income,2=Expense');
            $table->unsignedBigInteger('bcid_currency_id')->nullable();
            $table->unsignedBigInteger('bcid_account_id')->nullable();
            $table->unsignedBigInteger('bcid_actioned_by')->nullable();
            $table->dateTime('bcid_transaction_date')->nullable();
            $table->integer('bcid_month')->nullable();
            $table->integer('bcid_year')->nullable();
            $table->string('bcid_ref_code')->nullable();
            $table->text('bcid_description')->nullable();
            $table->text('bcid_narration')->nullable();
            $table->double('bcid_debit')->default(0);
            $table->double('bcid_credit')->default(0);
            $table->tinyInteger('bcid_status')->default(0)->comment('0=new submission,1=posted,2=discarded');
            $table->tinyInteger('bcid_level')->default(0)->comment('0=Branch,1=Region,2=Global');
            $table->tinyInteger('bcid_remit_table')->default(0)->comment('1=Yes,0=No');
            $table->tinyInteger('bcid_remittance_paid')->default(2)->comment('1=Yes,2=No,3=waived');
            $table->dateTime('bcid_date_actioned')->nullable();
            $table->text('bcid_actioned_comment')->nullable();
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
        Schema::dropIfExists('bulk_cashbook_import_details');
    }
};
