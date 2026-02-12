<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('guardian_email');
            $table->text('message');
            $table->string('subject');
            $table->string('risk_severity')->nullable();
            $table->integer('failed_count')->nullable();
            $table->string('trend')->nullable();
            $table->timestamp('sent_at')->useCurrent();
            $table->timestamps();

            $table->index('student_id');
            $table->index('guardian_email');
            $table->index('sent_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_logs');
    }
};