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
        Schema::table('bulk_messages', function (Blueprint $table) {
            $table->date('start_date')->nullable()->after('sent_to');
            $table->date('next_schedule')->nullable()->after('sent_to');
            $table->integer('recurring')->default(0)->after('sent_to')->comment('1=Yes,0=No');
            $table->integer('recurring_active')->default(0)->after('sent_to')->comment('1=Yes,0=No');
            $table->integer('bulk_frequency')->nullable()->after('sent_to');
            $table->unsignedBigInteger('branch_id')->nullable()->after('sent_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bulk_messages', function (Blueprint $table) {
            //
        });
    }
};
