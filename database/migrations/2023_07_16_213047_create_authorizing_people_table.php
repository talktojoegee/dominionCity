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
        Schema::create('authorizing_people', function (Blueprint $table) {
            $table->id('ap_id');
            $table->bigInteger('ap_post_id');
            $table->bigInteger('ap_user_id');
            $table->tinyInteger('ap_status')->default(0)->comment('0=pending,1=Approved,2=Declined');
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
        Schema::dropIfExists('authorizing_people');
    }
};
