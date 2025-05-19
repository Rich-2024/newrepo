<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRepaymentFieldsToLoansTable extends Migration
{
    public function up()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->after('amount')->nullable();
            $table->decimal('daily_repayment', 12, 2)->after('total_amount')->nullable();
        });
    }

    public function down()
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'daily_repayment']);
        });
    }
}
