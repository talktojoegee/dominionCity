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
        Schema::table('authorizing_people', function (Blueprint $table) {
            $table->tinyInteger('ap_final')->default(0)->comment('1=Marked as final,0=not')->after('ap_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authorizing_persons', function (Blueprint $table) {
            //
        });
    }
};
