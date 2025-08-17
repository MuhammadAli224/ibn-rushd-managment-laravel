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
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->morphs('balanceable'); // teacher, driver, guardian
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('month', 7); // YYYY-MM
            $table->unique(['balanceable_id', 'balanceable_type', 'month']); // unique per user per month

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('balances');
    }
};
