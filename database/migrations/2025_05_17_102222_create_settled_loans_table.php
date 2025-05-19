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
    Schema::create('settled_loans', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('contact');
        $table->decimal('amount', 12, 2);
        $table->decimal('interest_rate', 5, 2);
        $table->decimal('total_amount', 12, 2);
            $table->decimal('balance_left', 12, 2)->default(0);
        $table->date('loan_date');
        $table->date('settled_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settled_loans');
    }
};
