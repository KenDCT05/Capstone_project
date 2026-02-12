<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            $table->enum('status', ['sent', 'failed', 'pending'])->default('sent')->after('message');
            $table->text('error_message')->nullable()->after('status');
        });

        Schema::table('email_logs', function (Blueprint $table) {
            $table->enum('status', ['sent', 'failed', 'pending'])->default('sent')->after('subject');
            $table->text('error_message')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('sms_logs', function (Blueprint $table) {
            $table->dropColumn(['status', 'error_message']);
        });

        Schema::table('email_logs', function (Blueprint $table) {
            $table->dropColumn(['status', 'error_message']);
        });
    }
};