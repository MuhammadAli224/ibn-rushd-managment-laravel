<?php

use App\Models\Center;
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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(model: Center::class)->constrained()->onDelete('cascade');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('address');
            $table->string('national_id')->nullable()->unique();
            $table->enum('gender',['male','female'])->default('male');
            $table->date('date_of_birth');
            $table->string('qualification');
            $table->string('specialization');
            $table->string('experience');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('profile_picture')->nullable();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignIdFor(User::class, 'created_by')->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(User::class, 'updated_by')->nullable()->constrained()->onDelete('cascade');
            $table->string('fcm_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
