<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            // Add missing columns
            if (!Schema::hasColumn('scores', 'quiz_id')) {
                $table->foreignId('quiz_id')->nullable()->constrained('quizzes')->cascadeOnDelete()->after('subject_id');
            }
            if (!Schema::hasColumn('scores', 'max_score')) {
                $table->unsignedInteger('max_score')->nullable()->after('score');
            }
            if (!Schema::hasColumn('scores', 'percentage')) {
                $table->float('percentage')->nullable()->after('max_score');
            }
            if (!Schema::hasColumn('scores', 'label')) {
                $table->string('label')->nullable()->after('type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('scores', function (Blueprint $table) {
            $table->dropColumn(['quiz_id', 'max_score', 'percentage', 'label']);
        });
    }
};
