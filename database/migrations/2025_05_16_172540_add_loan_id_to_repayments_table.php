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
    Schema::table('repayments', function (Blueprint $table) {
        $table->unsignedBigInteger('loan_id')->after('id');

        // Optional: Add foreign key constraint
        $table->foreign('loan_id')->references('id')->on('loans')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('repayments', function (Blueprint $table) {
        $table->dropForeign(['loan_id']);
        $table->dropColumn('loan_id');
    });
}

};
