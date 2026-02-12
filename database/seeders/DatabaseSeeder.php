<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run other seeders first
        $this->call([
            AdminSeeder::class,
            DemoSeeder::class,
        ]);

        // --- Fixed Test Users (optional) ---
        User::create([
            'name' => 'Teacher Kenn',
            'email' => 'Kenardducut05@gmail.com',
            'first_login' => 0,
            'role' => 'teacher',
            'contact_number' => '09757378980',
            'password' => Hash::make('GSSM2025'),
        ]
    );

        // --- Generate 20 Random Students ---
        // User::factory()->count(20)->create([
        //     'role' => 'student',
        //     'first_login' => 0,
        //     'password' => Hash::make('GSSM2025'),
        // ])->each(function ($student, $index) {
        //     $student->update([
        //         'name' => 'Test ' . fake()->firstName(),
        //         'email' => 'test' . ($index + 2) . '@example.com', // start from test2
        //         'guardian_name' => 'Test Guardian ' . fake()->firstName(),
        //         'guardian_email' => 'testmail' . ($index + 2) . '@example.com',
        //         'guardian_contact' => '09' . rand(100000000, 999999999),
        //     ]);
        // });

        // --- Generate 5 Teachers ---
        // User::factory()->count(5)->create([
        //     'role' => 'teacher',
        //     'first_login' => 0,
        //     'password' => Hash::make('GSSM2025'),
        // ])->each(function ($teacher, $index) {
        //     $teacher->update([
        //         'name' => 'Teacher ' . fake()->firstName(),
        //         'email' => 'teacher' . ($index + 1) . '@example.com',
        //         'contact_number' => '09' . rand(100000000, 999999999),
        //     ]);
        // });
    }
}
