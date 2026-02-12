<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add user_id column (SGSSM/TGSSM format)
            $table->string('user_id', 20)->unique()->after('id')->nullable();
            
            // Add separated name fields
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('middle_initial', 10)->after('last_name')->nullable();
            
            // Add guardian name fields
            $table->string('guardian_first_name')->after('guardian_name')->nullable();
            $table->string('guardian_last_name')->after('guardian_first_name')->nullable();
            $table->string('guardian_middle_initial', 10)->after('guardian_last_name')->nullable();
        });
        
        // Migrate existing data (split the 'name' field)
        DB::statement("
            UPDATE users 
            SET 
                last_name = SUBSTRING_INDEX(name, ',', 1),
                first_name = TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(name, ',', -1), ' ', 1)),
                middle_initial = TRIM(SUBSTRING_INDEX(name, ' ', -1))
            WHERE name IS NOT NULL
        ");
        
        // Migrate guardian names
        DB::statement("
            UPDATE users 
            SET 
                guardian_last_name = SUBSTRING_INDEX(guardian_name, ',', 1),
                guardian_first_name = TRIM(SUBSTRING_INDEX(SUBSTRING_INDEX(guardian_name, ',', -1), ' ', 1)),
                guardian_middle_initial = TRIM(SUBSTRING_INDEX(guardian_name, ' ', -1))
            WHERE guardian_name IS NOT NULL
        ");
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_id', 
                'first_name', 
                'last_name', 
                'middle_initial',
                'guardian_first_name',
                'guardian_last_name',
                'guardian_middle_initial'
            ]);
        });
    }
};