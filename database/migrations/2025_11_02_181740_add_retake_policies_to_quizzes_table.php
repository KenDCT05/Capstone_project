<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRetakePoliciesToQuizzesTable extends Migration
{
    public function up()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            // Retake policy settings
            $table->integer('max_attempts')->default(1)->after('is_published')
                ->comment('Maximum number of attempts allowed (0 = unlimited)');
            
            $table->enum('retake_scoring', ['highest', 'latest', 'average', 'first'])
                ->default('highest')->after('max_attempts')
                ->comment('Which score to use: highest, latest, average, or first');
            
            $table->integer('cooldown_minutes')->nullable()->after('retake_scoring')
                ->comment('Minutes to wait between attempts (null = no cooldown)');
            
            $table->boolean('show_previous_answers')->default(false)->after('cooldown_minutes')
                ->comment('Allow students to see their previous answers when retaking');
            
            $table->boolean('require_pass_all')->default(false)->after('show_previous_answers')
                ->comment('Student must pass (75%) to be considered complete');
        });
    }

    public function down()
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn([
                'max_attempts',
                'retake_scoring',
                'cooldown_minutes',
                'show_previous_answers',
                'require_pass_all'
            ]);
        });
    }
}