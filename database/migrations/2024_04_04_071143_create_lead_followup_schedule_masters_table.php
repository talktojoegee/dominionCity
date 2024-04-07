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
        Schema::create('lead_followup_schedule_masters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('scheduled_by')->nullable();
            $table->date('entry_date')->nullable();
            $table->integer('period_month')->nullable();
            $table->integer('period_year')->nullable();
            $table->string('title')->nullable();
            $table->text('objective')->nullable();
            $table->string('ref_code')->nullable();
            $table->integer('status')->default(0)->comment('0=New,1=Open,2=Closed');
            $table->unsignedBigInteger('actioned_by')->nullable();
            $table->date('action_date')->nullable();
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
        Schema::dropIfExists('lead_followup_schedule_masters');
    }
};
