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
         Schema::table('salaries', function (Blueprint $table) {
            // Drop the morph columns
            $table->dropMorphs('salaryable');

            // Add direct user_id relation
            $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('salaries', function (Blueprint $table) {
            // Remove user_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Re-add the morph columns
            $table->morphs('salaryable');
        });
    }
};
