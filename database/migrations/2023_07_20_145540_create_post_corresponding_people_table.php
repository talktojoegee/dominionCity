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
        Schema::create('post_corresponding_people', function (Blueprint $table) {
            $table->id('pcp_id');
            $table->unsignedBigInteger('pcp_post_id');
            $table->tinyInteger('pcp_type')->default(1)->comment('1=Everyone, 2=Branch,3=Region,4=Individuals');
            $table->json('pcp_target')->nullable()->comment('This holds array values for branch,regions,individuals');
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
        Schema::dropIfExists('post_corresponding_people');
    }
};
