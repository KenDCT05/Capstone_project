<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('engagement_logs', function (Blueprint $table) {
            $table->unsignedBigInteger('subject_id')->nullable()->after('user_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null');
            $table->index(['subject_id', 'action']);
        });
    }

    public function down()
    {
        Schema::table('engagement_logs', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropIndex(['subject_id', 'action']);
            $table->dropColumn('subject_id');
        });
    }
};