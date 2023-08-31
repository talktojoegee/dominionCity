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
        Schema::table('cash_books', function (Blueprint $table) {
            $table->string('cashbook_remittance_ref_no')->nullable()->after('cashbook_remittance_paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cashbooks', function (Blueprint $table) {
            //
        });
    }
};
