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
        Schema::table('remittances', function (Blueprint $table) {
            $table->unsignedBigInteger('r_remitted_by')->nullable();
            $table->integer('r_category_id')->nullable()->comment('transaction category. e.g tithe, offering');
            $table->tinyInteger('r_type')->default(1)->comment('1=local, 0=forex');
            $table->string('r_narration')->nullable();
            $table->double('r_rate')->default(0)->after('r_amount');
            $table->date('r_from')->nullable()->comment('start date');
            $table->date('r_to')->nullable()->comment('end date');
            $table->tinyInteger('r_status')->nullable()->default(0)->comment('0=pending,1=confirmed,2=declined');
            $table->unsignedBigInteger('r_acted_by')->nullable()->comment('the person who either confirmed or declined the submission');
            $table->string('r_comment')->nullable()->comment('a note for the action taken');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('remittances', function (Blueprint $table) {
            //
        });
    }
};
