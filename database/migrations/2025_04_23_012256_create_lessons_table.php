<?php

use App\Models\Drivers;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Subject::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Teacher::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Drivers::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Student::class)->constrained()->onDelete('cascade');
            $table->date('lesson_date');
            $table->time('lesson_start_time');
            $table->time('lesson_end_time');
            $table->string('lesson_location');
            $table->text('lesson_notes')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled'])->default('scheduled');
            $table->unsignedInteger('lesson_duration')->nullable();
            $table->datetime('check_in_time')->nullable();
            $table->datetime('check_out_time')->nullable();
            $table->decimal('uber_charge', 8, 2)->nullable();
            $table->decimal('lesson_price', 8, 2)->nullable();
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('lessons');
    }
};
