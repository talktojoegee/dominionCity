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
        Schema::table('post_attachments', function (Blueprint $table) {
            $table->string('pa_name')->nullable()->after('pa_attachments');
            $table->double('pa_size')->nullable()->after('pa_attachments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_attachments', function (Blueprint $table) {
            //
        });
    }
};
