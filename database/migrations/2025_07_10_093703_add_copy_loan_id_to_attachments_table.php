<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->unsignedBigInteger('copy_loan_id')->nullable()->after('id');

            $table->foreign('copy_loan_id')->references('id')->on('copy_loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropForeign(['copy_loan_id']);
            $table->dropColumn('copy_loan_id');
        });
    }
};
