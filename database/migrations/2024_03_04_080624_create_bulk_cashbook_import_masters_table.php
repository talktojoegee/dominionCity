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
        Schema::create('bulk_cashbook_import_masters', function (Blueprint $table) {
            $table->id('bcim_id');
            $table->unsignedBigInteger('bcim_imported_by');
            $table->unsignedBigInteger('bcim_cba_id');
            $table->string('bcim_batch_code')->nullable();
            $table->string('bcim_month')->nullable();
            $table->string('bcim_year')->nullable();
            $table->string('bcim_narration')->nullable();
            $table->string('bcim_attachment')->nullable();
            $table->string('bcim_purge_reason')->nullable();
            $table->unsignedBigInteger('bcim_purged_by')->nullable();
            $table->date('bcim_date_purged')->nullable();
            $table->tinyInteger('bcim_status')->default(0)->comment('0=comment,1=approved,2=purged');
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
        Schema::dropIfExists('bulk_cashbook_import_masters');
    }
};
