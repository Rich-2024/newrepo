<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact');
            $table->decimal('amount', 12, 2);
            $table->date('loan_date');
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->integer('loan_duration')->nullable();
            $table->timestamps();

            // Computed columns (Laravel doesn't support virtual/generated columns natively)
            // So you'll calculate total_amount and daily_repayment in the model or database triggers
            // OR if your DB supports it (e.g. MySQL 5.7+), you can run a raw statement manually later

            $table->foreign(['interest_rate', 'loan_duration'])
                  ->references(['interest_rate', 'loan_duration'])
                  ->on('interest_setups')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
