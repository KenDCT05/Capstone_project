<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('engagement_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('action', [
                'login',
                'quiz_attempt',
                'activity_upload',
                'course_enrollment',
                'time_spent',
                'material_download'
            ]);
            $table->string('context')->nullable(); // e.g., "Math Module", "Quiz 1"
            $table->integer('value')->nullable();  // e.g., seconds spent, file size
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('engagement_logs');
    }
};