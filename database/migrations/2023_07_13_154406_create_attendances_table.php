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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id('a_id');
            $table->unsignedBigInteger('a_taken_by');
            $table->integer('a_branch_id');
            $table->string('a_program_name')->nullable();
            $table->date('a_program_date')->nullable();
            $table->integer('a_no_men')->default(0);
            $table->integer('a_no_women')->default(0);
            $table->integer('a_no_children')->default(0);
            $table->string('a_narration')->nullable();
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
        Schema::dropIfExists('attendances');
    }
};
