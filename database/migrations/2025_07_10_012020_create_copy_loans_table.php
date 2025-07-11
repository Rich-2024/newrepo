<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('copy_loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('name');
            $table->string('contact');
            $table->decimal('amount', 15, 2);
            $table->date('loan_date');
            $table->date('end_date');
            $table->float('interest_rate');
            $table->integer('loan_duration');
            $table->decimal('total_amount', 15, 2);
            $table->decimal('balance_to_pay', 15, 2);
            $table->decimal('daily_repayment', 15, 2);
            $table->string('status')->default('active');

            $table->timestamps();

          
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('copy_loans');
    }
};
