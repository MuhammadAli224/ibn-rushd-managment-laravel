<?php

use App\Models\Center;
use App\Models\ExpenseCategory;
use App\Models\User;
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
        Schema::create('expenses', function (Blueprint $table) {
           
            $table->id();
            $table->foreignIdFor(ExpenseCategory::class )->constrained()->onDelete('cascade');
            $table->decimal('amount', 8, 2);
            $table->text('description')->nullable();
            $table->date('date');
            $table->foreignIdFor(Center::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained()->onDelete('cascade');
       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
