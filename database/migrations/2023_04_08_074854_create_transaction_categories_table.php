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
        Schema::create('transaction_categories', function (Blueprint $table) {
            $table->id('tc_id');
            $table->unsignedBigInteger('tc_branch_id');
            $table->unsignedBigInteger('tc_created_by');
            $table->string('tc_name')->nullable();
            $table->string('tc_type')->default(1)->comment('1=Income,2=Expenses');
            $table->tinyInteger('tc_status')->default(1)->comment('1=Active,2=Inactive');
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
        Schema::dropIfExists('transaction_categories');
    }
};
