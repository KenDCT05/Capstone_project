<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActivityFieldsToMaterialsTable extends Migration
{
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->boolean('is_activity')->default(false)->after('description');
            $table->datetime('due_date')->nullable()->after('is_activity');
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn(['is_activity', 'due_date']);
        });
    }
}
