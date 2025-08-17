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
         Schema::table('balances', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });
         DB::table('balances')->update([
            'user_id' => DB::raw('balanceable_id')
        ]);
        Schema::table('balances', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();

            $table->dropMorphs('balanceable');

            $table->dropUnique(['balanceable_id', 'balanceable_type', 'month']);
            $table->unique(['user_id', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('balances', function (Blueprint $table) {
             $table->morphs('balanceable');

            // Drop new unique index
            $table->dropUnique(['user_id', 'month']);

            // Drop user_id column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // Restore old unique index
            $table->unique(['balanceable_id', 'balanceable_type', 'month']);
        });
    }
};
