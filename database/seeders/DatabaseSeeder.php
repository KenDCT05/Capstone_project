<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\ScoreSeeder;
use Database\Seeders\SubjectSeeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\GradebookSeeder;




class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
        AdminSeeder::class,
        // SubjectSeeder::class,
          GradebookSeeder::class,
         ]);

    $users = [
        [
            'name' => 'Test User Kenn',
            'email' => 'test1@example.com',
            'first_login' => 0,
            'password' => Hash::make('GSSM2025'),        ],
        [
            'name' => 'Test User Yesha',
            'email' => 'test2@example.com',
            'first_login' => 0,
            'password' => Hash::make('GSSM2025'),        ],
        [
            'name' => 'Test User Jam',
            'email' => 'test3@example.com',
            'first_login' => 0,
            'password' => Hash::make('GSSM2025'),
        ],
        [
            'name' => 'Teacher Ken',
            'email' => 'kenardducut05@gmail.com',
            'role' => 'teacher',
            'first_login' => 0,
            'password' => Hash::make('GSSM2025'),            
        ]
    ];

    foreach ($users as $userData) {
        User::factory()->create($userData);
    }
    }
}
