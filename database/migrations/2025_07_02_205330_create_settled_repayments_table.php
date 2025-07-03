<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettledRepaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('settled_repayments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settled_loan_id')->constrained('settled_loans')->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->date('payment_date');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('settled_repayments');
    }
}
