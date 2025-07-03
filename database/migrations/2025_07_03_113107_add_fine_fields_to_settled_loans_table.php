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
        Schema::table('settled_loans', function (Blueprint $table) {
        $table->integer('overdue_days')->nullable();
        $table->decimal('fine_total', 10, 2)->nullable();
        $table->date('fine_end_date')->nullable();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settled_loans', function (Blueprint $table) {
        $table->dropColumn(['overdue_days', 'fine_total', 'fine_end_date']);
    });
    }
};
