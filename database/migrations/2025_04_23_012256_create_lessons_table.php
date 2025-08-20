<?php

use App\Enums\LessonStatusEnum;
use App\Models\Center;
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

            $table->foreignIdFor(Center::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Subject::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'driver_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();

            $table->date('lesson_date');
            $table->time('lesson_start_time')->nullable();
            $table->time('lesson_end_time')->nullable();
            $table->string('lesson_location')->nullable();
            $table->text('lesson_notes')->nullable();

            $table->enum('status', collect(LessonStatusEnum::cases())->pluck('value')->toArray())
                ->default(LessonStatusEnum::SCHEDULED->value);

            $table->unsignedInteger('lesson_duration')->nullable();
            $table->datetime('check_in_time')->nullable();
            $table->datetime('check_out_time')->nullable();
            $table->decimal('uber_charge', 8, 2)->nullable();
            $table->decimal('lesson_price', 8, 2)->nullable();
            $table->decimal('commission_rate', 5, 2)->nullable();

            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('lessons');
    }
};
