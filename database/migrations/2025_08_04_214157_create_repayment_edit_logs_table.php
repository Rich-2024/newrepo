<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
     Schema::create('repayment_edit_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('repayment_id')->constrained('settled_repayments')->onDelete('cascade');
    $table->foreignId('edited_by')->constrained('users')->onDelete('cascade');
    $table->json('changes'); // store changed fields and old values
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayment_edit_logs');
    }
};
