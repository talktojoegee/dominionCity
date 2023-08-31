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
        Schema::table('transaction_categories', function (Blueprint $table) {
            $table->tinyInteger('tc_remittable')->default(0);
            $table->double('tc_proposed_rate')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_categories', function (Blueprint $table) {
            //
        });
    }
};
