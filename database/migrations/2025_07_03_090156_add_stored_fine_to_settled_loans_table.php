<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('settled_loans', function (Blueprint $table) {
            $table->decimal('stored_fine_total', 10, 2)->nullable()->after('balance_left');
            $table->decimal('stored_balance_left', 10, 2)->nullable()->after('stored_fine_total');
        });
    }

    public function down(): void
    {
        Schema::table('settled_loans', function (Blueprint $table) {
            $table->dropColumn(['stored_fine_total', 'stored_balance_left']);
        });
    }
};
