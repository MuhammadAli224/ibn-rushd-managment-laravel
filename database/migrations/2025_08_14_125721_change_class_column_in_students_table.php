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
        Schema::table('students', function (Blueprint $table) {
           $table->dropColumn('class');
        });
         Schema::table('students', function (Blueprint $table) {
            $table->enum('class', [
                'grade_1',
                'grade_2',
                'grade_3',
                'grade_4',
                'grade_5',
                'grade_6',
                'grade_7',
                'grade_8',
                'grade_9',
                'grade_10',
                'grade_11',
                'grade_12',
                'diploma',
                'university'
            ])->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('class');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->string('class')->after('name');
        });
    }
};
