<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterestSetupsTable extends Migration
{
    public function up()
    {
        Schema::create('interest_setups', function (Blueprint $table) {
            $table->decimal('interest_rate', 5, 2); // The interest rate, stored as a decimal (e.g., 0.05 for 5%).
            $table->integer('loan_duration'); // The loan duration in days or months, depending on your business logic.
            $table->string('business_name'); // The name of the business (e.g., "business comm").
            $table->enum('business_size', ['Small', 'Medium', 'Large']); // Enum for business size.
            $table->timestamps(); // Timestamps for creation and update.
        
            // Composite Primary Key to ensure unique combinations of interest rate and loan duration.
            $table->primary(['interest_rate', 'loan_duration']);
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('interest_setups');
    }
}
