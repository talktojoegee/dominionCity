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
        Schema::create('remittance_policies', function (Blueprint $table) {
            $table->id('rp_id');
            $table->unsignedBigInteger('rp_added_by')->nullable();
            $table->unsignedBigInteger('rp_branch_id')->nullable();
            $table->unsignedBigInteger('rp_transaction_category_id')->nullable();
            $table->double('rp_rate')->default(0);
            $table->double('rp_priority');
            $table->tinyInteger('rp_status')->default(1)->comment('1=active,2=inactive');
            $table->unsignedBigInteger('rp_last_updated_by')->nullable();
            $table->dateTime('rp_last_updated_at')->nullable();
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
        Schema::dropIfExists('remittance_policies');
    }
};
