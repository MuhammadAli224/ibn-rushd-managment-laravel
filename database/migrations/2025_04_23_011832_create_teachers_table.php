<?php

use App\Enums\QualificationEnum;
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
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->date('date_of_birth')->nullable();
            $table->enum('qualification', array_column(QualificationEnum::cases(), 'value'))
                ->default(QualificationEnum::Bachelor->value);
        
            $table->integer('commission')->default(40);
            $table->string('specialization');
            $table->string('experience');
            
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
        Schema::dropIfExists('teachers');
    }
};
