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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('key')->unique();
        $table->text('value')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
public function down()
{
    Schema::table('settings', function (Blueprint $table) {
        if (Schema::hasColumn('settings', 'user_id')) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        }
    });
}

};
