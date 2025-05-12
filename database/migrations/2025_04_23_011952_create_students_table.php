<?php

use App\Models\Center;
use App\Models\Guardian;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            // $table->foreignIdFor(User::class,'guardian_id')->nllable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(Guardian::class)->constrained('guardians')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('class');
            $table->string('phone');
            $table->string('address');
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
