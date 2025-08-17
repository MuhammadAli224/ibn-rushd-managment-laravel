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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
           $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2)->default(0);
            $table->enum('type', ['fixed', 'commission', 'daily'])->default('fixed');
            $table->date('salary_date')->nullable(); // monthly salary date
            $table->string('month', 7)->nullable(); // YYYY-MM format for monthly salaries
            $table->boolean('is_paid')->default(false); // whether the salary has been paid
            $table->string('payment_method')->nullable(); // e.g., bank transfer, cash
            $table->string('transaction_id')->nullable(); // for tracking payments
            $table->text('notes')->nullable(); // any additional notes about the salary
            $table->string('center_commession_value')->nullable(); // any additional notes about the salary
            $table->string('center_commession_percentage')->nullable(); // any additional notes about the salary
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
