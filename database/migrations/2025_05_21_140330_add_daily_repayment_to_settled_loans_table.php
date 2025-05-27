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
        $table->decimal('daily_repayment', 10, 2)->nullable();
    });
}

public function down()
{
    Schema::table('settled_loans', function (Blueprint $table) {
        $table->dropColumn('daily_repayment');
    });
}

};
