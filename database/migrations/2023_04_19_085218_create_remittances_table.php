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
        Schema::create('remittances', function (Blueprint $table) {
            $table->id('r_id');
            $table->unsignedBigInteger('r_branch_id');
            $table->dateTime('r_transaction_date');
            $table->integer('r_month');
            $table->integer('r_year');
            $table->double('r_amount')->default(0);
            $table->tinyInteger('r_paid')->default(2)->comment('1=Yes,2=No,3=waived');
            $table->string('r_ref_code')->nullable();
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
        Schema::dropIfExists('remittances');
    }
};
