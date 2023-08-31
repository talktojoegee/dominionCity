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
        Schema::create('posts', function (Blueprint $table) {
            $table->id('p_id');
            $table->bigInteger('p_posted_by')->nullable();
            $table->integer('p_branch_id')->nullable();
            $table->string('p_title')->nullable();
            $table->string('p_content')->nullable();
            $table->tinyInteger('p_type')->nullable()->default(1)->comment('1=message,2=memo,3=announcement,4=directive,5=project,6=expenseRequest,7=expenseReport,8=attendance,9=event');
            $table->double('p_amount')->nullable()->default(0);
            $table->dateTime('p_start_date')->nullable();
            $table->dateTime('p_end_date')->nullable();
            $table->string('p_slug')->nullable();
            $table->tinyInteger('p_status')->nullable()->default(0)->comment('0=pending,1=processing,2=approved,3=declined');
            $table->integer('p_max_score_rating')->default(100);
            $table->integer('p_score_rating')->default(0);
            $table->string('p_color')->nullable();
            $table->tinyInteger('p_authorization')->default(0)->comment('Require any form of authorization? 0=No,1=Yes');
            $table->tinyInteger('p_scope')->default(0)->comment('0=global,1=Region,2=branch');
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
        Schema::dropIfExists('posts');
    }
};
