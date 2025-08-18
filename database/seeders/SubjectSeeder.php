<?php 
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = ['Math', 'English', 'Science', 'Filipino', 'Araling Panlipunan', 'MAPEH'];

        foreach ($subjects as $subject) {
            Subject::create(['name' => $subject]);
        }
    }
}
