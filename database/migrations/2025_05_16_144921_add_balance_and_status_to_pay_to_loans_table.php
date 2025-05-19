<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->decimal('balance_to_pay', 12, 2)->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active')->after('balance_to_pay');
        });
    }

    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['balance_to_pay', 'status']);
        });
    }
};
