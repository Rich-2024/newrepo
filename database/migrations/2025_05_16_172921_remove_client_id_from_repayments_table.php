<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('repayments', function (Blueprint $table) {
            $table->dropForeign(['client_id']); // Drop the foreign key first
            $table->dropColumn('client_id');    // Then drop the column
        });
    }

    public function down(): void
    {
        Schema::table('repayments', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id')->nullable();

            // Optionally re-add the foreign key
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }
};
