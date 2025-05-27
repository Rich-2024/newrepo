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
    Schema::table('settled_loans', function (Blueprint $table) {
        $table->decimal('repayment_made', 10, 2)->nullable()->after('balance_left');
        $table->date('last_repayment_date')->nullable()->after('repayment_made');

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settled_loans', function (Blueprint $table) {
            //
        });
    }
};
