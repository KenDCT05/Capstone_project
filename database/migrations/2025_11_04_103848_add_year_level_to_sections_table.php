<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->integer('year_level')->after('name')->nullable();
        });
    }

    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropColumn('year_level');
        });
    }
};