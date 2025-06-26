<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestSetupsTable extends Migration
{
    public function up()
    {
        Schema::create('interest_setups', function (Blueprint $table) {
            $table->id();

            $table->decimal('interest_rate', 5, 2);
            $table->integer('loan_duration');
            $table->string('business_name');
            $table->enum('business_size', ['Small', 'Medium', 'Large']);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('interest_setups');
    }
}
