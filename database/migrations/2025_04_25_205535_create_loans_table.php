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

            
$table->foreignId('user_id')->constrained()->onDelete('cascade');



        });
    }

    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
