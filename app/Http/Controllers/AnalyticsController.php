<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Models\MaxScore;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    /**
     * Transmutation table as defined in your grading system
     */
    private function getTransmutationTable()
    {
        return [
            ['min' => 100.00, 'max' => 100.00, 'transmuted' => 100, 'letter' => 'A+', 'performance' => 'Excellent'],
            ['min' => 98.40, 'max' => 99.99, 'transmuted' => 99, 'letter' => 'A', 'performance' => 'Excellent'],
            ['min' => 96.80, 'max' => 98.39, 'transmuted' => 98, 'letter' => 'A', 'performance' => 'Excellent'],
            ['min' => 95.20, 'max' => 96.79, 'transmuted' => 97, 'letter' => 'A-', 'performance' => 'Excellent'],
            ['min' => 93.60, 'max' => 95.19, 'transmuted' => 96, 'letter' => 'A-', 'performance' => 'Excellent'],
            ['min' => 92.00, 'max' => 93.59, 'transmuted' => 95, 'letter' => 'B+', 'performance' => 'Very Good'],
            ['min' => 90.40, 'max' => 91.99, 'transmuted' => 94, 'letter' => 'B+', 'performance' => 'Very Good'],
            ['min' => 88.80, 'max' => 90.39, 'transmuted' => 93, 'letter' => 'B', 'performance' => 'Very Good'],
            ['min' => 87.20, 'max' => 88.79, 'transmuted' => 92, 'letter' => 'B', 'performance' => 'Very Good'],
            ['min' => 85.60, 'max' => 87.19, 'transmuted' => 91, 'letter' => 'B-', 'performance' => 'Good'],
            ['min' => 84.00, 'max' => 85.59, 'transmuted' => 90, 'letter' => 'B-', 'performance' => 'Good'],
            ['min' => 82.40, 'max' => 83.99, 'transmuted' => 89, 'letter' => 'C+', 'performance' => 'Good'],
            ['min' => 80.80, 'max' => 82.39, 'transmuted' => 88, 'letter' => 'C+', 'performance' => 'Good'],
            ['min' => 79.20, 'max' => 80.79, 'transmuted' => 87, 'letter' => 'C', 'performance' => 'Fair'],
            ['min' => 77.60, 'max' => 79.19, 'transmuted' => 86, 'letter' => 'C', 'performance' => 'Fair'],
            ['min' => 76.00, 'max' => 77.59, 'transmuted' => 85, 'letter' => 'C-', 'performance' => 'Fair'],
            ['min' => 74.40, 'max' => 75.99, 'transmuted' => 84, 'letter' => 'C-', 'performance' => 'Fair'],
            ['min' => 72.80, 'max' => 74.39, 'transmuted' => 83, 'letter' => 'D+', 'performance' => 'Passed'],
            ['min' => 71.20, 'max' => 72.79, 'transmuted' => 82, 'letter' => 'D+', 'performance' => 'Passed'],
            ['min' => 69.60, 'max' => 71.19, 'transmuted' => 81, 'letter' => 'D', 'performance' => 'Passed'],
            ['min' => 68.00, 'max' => 69.59, 'transmuted' => 80, 'letter' => 'D', 'performance' => 'Passed'],
            ['min' => 66.40, 'max' => 67.99, 'transmuted' => 79, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 64.80, 'max' => 66.39, 'transmuted' => 78, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 63.20, 'max' => 64.79, 'transmuted' => 77, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 61.60, 'max' => 63.19, 'transmuted' => 76, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 60.00, 'max' => 61.59, 'transmuted' => 75, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 56.00, 'max' => 59.99, 'transmuted' => 74, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 52.00, 'max' => 55.99, 'transmuted' => 73, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 48.00, 'max' => 51.99, 'transmuted' => 72, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 44.00, 'max' => 47.99, 'transmuted' => 71, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 40.00, 'max' => 43.99, 'transmuted' => 70, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 36.00, 'max' => 39.99, 'transmuted' => 69, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 32.00, 'max' => 35.99, 'transmuted' => 68, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 28.00, 'max' => 31.99, 'transmuted' => 67, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 24.00, 'max' => 27.99, 'transmuted' => 66, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 20.00, 'max' => 23.99, 'transmuted' => 65, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 16.00, 'max' => 19.99, 'transmuted' => 64, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 12.00, 'max' => 15.99, 'transmuted' => 63, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 8.00, 'max' => 11.99, 'transmuted' => 62, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 4.00, 'max' => 7.99, 'transmuted' => 61, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 0.00, 'max' => 3.99, 'transmuted' => 60, 'letter' => 'F', 'performance' => 'Failed'],
        ];
    }

    /**
     * Convert raw percentage to transmuted grade
     */
    private function getTransmutedGrade($percentage)
    {
        $table = $this->getTransmutationTable();
        
        foreach ($table as $row) {
            if ($percentage >= $row['min'] && $percentage <= $row['max']) {
                return [
                    'transmuted' => $row['transmuted'],
                    'letter' => $row['letter'],
                    'performance' => $row['performance']
                ];
            }
        }
        
        // Default for very low scores
        return [
            'transmuted' => 60,
            'letter' => 'F',
            'performance' => 'Failed'
        ];
    }

    /**
     * Dashboard Overview with Transmuted Grades - Updated for student filtering
     */
    public function dashboard(Request $request)
    {
        $teacher = auth()->user();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();

        // Get selected filters
        $selectedSubject = $request->subject_id ?? $subjects->first()?->id;
        $selectedStudent = $request->student_id;

        if (!$selectedSubject) {
            return view('analytics.dashboard', [
                'subjects' => $subjects,
                'selectedSubject' => null,
                'subjectAverages' => collect(),
                'distribution' => ['excellent' => 0, 'very_good' => 0, 'good' => 0, 'fair' => 0, 'passed' => 0, 'failed' => 0],
                'progress' => collect(),
                'columnPerformance' => collect(),
                'students' => collect(),
                'selectedStudent' => null,
                'totalAssessments' => 0
            ]);
        }

        // Fetch students for this subject
        $students = User::where('role', 'student')
            ->whereHas('scores', function ($q) use ($selectedSubject) {
                $q->where('subject_id', $selectedSubject);
            })
            ->orderBy('name')
            ->get();

        // Get scores with transmuted grades (filtered by student if selected)
        $scoresWithTransmutation = $this->getScoresWithTransmutation($selectedSubject, $selectedStudent);

        // Calculate total unique assessments (excluding attendance)
        $totalAssessments = $this->getTotalAssessmentsForSubject($selectedSubject);

        // Average transmuted grade per subject - filtered by student if needed
        $subjectAverages = collect();
        if ($selectedStudent) {
            // Show student's averages across all subjects they have scores for
            foreach ($subjects as $subject) {
                $studentScores = $this->getScoresWithTransmutation($subject->id, $selectedStudent);
                if ($studentScores->isNotEmpty()) {
                    $subjectAverages[$subject->id] = round($studentScores->avg('transmuted_grade'), 2);
                }
            }
        } else {
            // Show class averages for all subjects
            foreach ($subjects as $subject) {
                $subjectScores = $this->getScoresWithTransmutation($subject->id);
                if ($subjectScores->isNotEmpty()) {
                    $subjectAverages[$subject->id] = round($subjectScores->avg('transmuted_grade'), 2);
                }
            }
        }

        // Score distribution based on performance levels
        $distribution = [
            'excellent' => $scoresWithTransmutation->where('performance', 'Excellent')->count(),
            'very_good' => $scoresWithTransmutation->where('performance', 'Very Good')->count(),
            'good' => $scoresWithTransmutation->where('performance', 'Good')->count(),
            'fair' => $scoresWithTransmutation->where('performance', 'Fair')->count(),
            'passed' => $scoresWithTransmutation->where('performance', 'Passed')->count(),
            'failed' => $scoresWithTransmutation->where('performance', 'Failed')->count(),
        ];

        // Progress over time using transmuted grades
        $progress = $scoresWithTransmutation->groupBy(function ($item) {
            return $item->created_at->format('Y-m-d');
        })->map(function ($dayScores) {
            return round($dayScores->avg('transmuted_grade'), 2);
        })->sortKeys();

        // Column performance analysis using transmuted grades
$columnPerformance = $scoresWithTransmutation->groupBy('label')
    ->map(function ($columnScores, $columnName) use ($selectedStudent) {
        // count passed/failed per assessment
        $passedCount = $columnScores->filter(fn($s) => $s->transmuted_grade >= 75)->count();
        $failedCount = $columnScores->count() - $passedCount;

        return [
            'column_name' => $columnName,
            'avg_transmuted' => round($columnScores->avg('transmuted_grade'), 2),
            'avg_percentage' => round($columnScores->avg('percentage'), 2),
            'student_count' => $selectedStudent
                ? $columnScores->count()
                : $columnScores->pluck('student_id')->unique()->count(),
            'max_possible' => $columnScores->first()->max_score ?? 0,
            'dominant_performance' => $columnScores->groupBy('performance')
                ->sortByDesc(fn($group) => $group->count())
                ->keys()
                ->first(),
            'passed_count' => $passedCount,
            'failed_count' => $failedCount,
        ];
    })
    ->sortByDesc('avg_transmuted')
    ->values();

        return view('analytics.dashboard', compact(
            'subjects',
            'selectedSubject',
            'subjectAverages',
            'distribution',
            'progress',
            'columnPerformance',
            'students',
            'selectedStudent',
            'totalAssessments'
        ));
    }

    /**
     * Get total unique assessments for a subject (excluding attendance) - IMPROVED
     */
    private function getTotalAssessmentsForSubject($subjectId)
    {
        return MaxScore::where('subject_id', $subjectId)
            ->excludeAttendance()
            ->count();
    }

    /**
     * Risk Alerts using transmuted grades - Updated for better filtering
     */
    public function riskAlerts(Request $request)
    {
        $teacher = auth()->user();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();

        $selectedSubject = $request->input('subject_id');
        $selectedStudent = $request->input('student_id');

        $subjectIds = $selectedSubject
            ? [$selectedSubject]
            : $subjects->pluck('id')->toArray();

        if (empty($subjectIds)) {
            return view('analytics.risk-alerts', [
                'atRisk' => collect(),
                'safeStudents' => collect(),
                'subjects' => $subjects,
                'selectedSubject' => $selectedSubject,
                'selectedStudent' => $selectedStudent,
            ]);
        }

        $studentIds = DB::table('subject_user')
            ->whereIn('subject_id', $subjectIds)
            ->pluck('user_id')
            ->unique();

        $students = User::whereIn('id', $studentIds)
            ->where('role', 'student')
            ->when($selectedStudent, fn($q) => $q->where('id', $selectedStudent))
            ->get();

        $studentData = collect();

        foreach ($students as $student) {
            foreach ($subjectIds as $subjectId) {
                $scoresWithTransmutation = $this->getScoresWithTransmutation($subjectId, $student->id);

                if ($scoresWithTransmutation->isEmpty()) {
                    continue;
                }

                $avgTransmuted = round($scoresWithTransmutation->avg('transmuted_grade'), 2);
                $avgPercentage = round($scoresWithTransmutation->avg('percentage'), 2);

                $studentData->push([
                    'student_id' => $student->id,
                    'student_name' => $student->name,
                    'subject_id' => $subjectId,
                    'subject_name' => $subjects->firstWhere('id', $subjectId)->name ?? 'Unknown',
                    'average_transmuted' => $avgTransmuted,
                    'average_percentage' => $avgPercentage,
                    'total_assessments' => $scoresWithTransmutation->count(),
                    'risk_level' => $this->getTransmutedRiskLevel($avgTransmuted),
                    'performance_level' => $this->getTransmutedGrade($avgPercentage)['performance']
                ]);
            }
        }

        // Split based on transmuted grades (75 is the passing threshold)
        $atRisk = $studentData->filter(fn($s) => $s['average_transmuted'] < 75)
                              ->sortBy('average_transmuted');

        $safeStudents = $studentData->filter(fn($s) => $s['average_transmuted'] >= 75)
                                    ->sortByDesc('average_transmuted');

        return view('analytics.risk-alerts', compact(
            'atRisk', 'safeStudents', 'subjects', 'selectedSubject', 'selectedStudent'
        ));
    }

    /**
     * Performance Insights with transmuted grades - Enhanced
     */
    public function insights($studentId)
    {
        $student = User::findOrFail($studentId);
        $teacher = auth()->user();
        
        $subjects = Subject::where('teacher_id', $teacher->id)
            ->whereHas('students', function ($query) use ($studentId) {
                $query->where('user_id', $studentId);
            })
            ->get();

        $studentPerformance = [];

        foreach ($subjects as $subject) {
            $scoresWithTransmutation = $this->getScoresWithTransmutation($subject->id, $studentId);
            
            if ($scoresWithTransmutation->isNotEmpty()) {
                $studentPerformance[$subject->name] = [
                    'subject_id' => $subject->id,
                    'overall_average_transmuted' => round($scoresWithTransmutation->avg('transmuted_grade'), 2),
                    'overall_average_percentage' => round($scoresWithTransmutation->avg('percentage'), 2),
                    'total_assessments' => $scoresWithTransmutation->count(),
                    'highest_transmuted' => $scoresWithTransmutation->max('transmuted_grade'),
                    'lowest_transmuted' => $scoresWithTransmutation->min('transmuted_grade'),
                    'performance_distribution' => $scoresWithTransmutation->groupBy('performance')
                        ->map(fn($group) => $group->count()),
                    'assessments' => $scoresWithTransmutation->map(function ($score) {
                        return [
                            'column_name' => $score->label,
                            'score' => $score->score,
                            'max_score' => $score->max_score,
                            'percentage' => $score->percentage,
                            'transmuted_grade' => $score->transmuted_grade,
                            'letter_grade' => $score->letter_grade,
                            'performance' => $score->performance,
                            'date' => $score->created_at->format('Y-m-d')
                        ];
                    })->sortByDesc('created_at')
                ];
            }
        }

        // Overall statistics using transmuted grades
        $overallStats = [
            'total_subjects' => count($studentPerformance),
            'overall_average_transmuted' => count($studentPerformance) > 0 ? 
                round(collect($studentPerformance)->avg('overall_average_transmuted'), 2) : 0,
            'overall_average_percentage' => count($studentPerformance) > 0 ? 
                round(collect($studentPerformance)->avg('overall_average_percentage'), 2) : 0,
            'strengths' => collect($studentPerformance)
                ->where('overall_average_transmuted', '>=', 90)
                ->keys()
                ->toArray(),
            'needs_improvement' => collect($studentPerformance)
                ->where('overall_average_transmuted', '<', 75)
                ->keys()
                ->toArray()
        ];

        return view('analytics.insights', compact(
            'student', 
            'studentPerformance', 
            'overallStats'
        ));
    }

    /**
     * Subject Comparison using transmuted grades
     */
    public function subjectComparison()
    {
        $teacher = auth()->user();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();

        $comparison = $subjects->map(function ($subject) {
            $scoresWithTransmutation = $this->getScoresWithTransmutation($subject->id);
            
            if ($scoresWithTransmutation->isEmpty()) {
                return null;
            }

            return [
                'subject_name' => $subject->name,
                'subject_id' => $subject->id,
                'average_transmuted' => round($scoresWithTransmutation->avg('transmuted_grade'), 2),
                'average_percentage' => round($scoresWithTransmutation->avg('percentage'), 2),
                'total_students' => $scoresWithTransmutation->pluck('student_id')->unique()->count(),
                'total_assessments' => $this->getTotalAssessmentsForSubject($subject->id),
                'total_submissions' => $scoresWithTransmutation->count(),
                'highest_transmuted' => $scoresWithTransmutation->max('transmuted_grade'),
                'lowest_transmuted' => $scoresWithTransmutation->min('transmuted_grade'),
                'passing_rate' => $scoresWithTransmutation->where('transmuted_grade', '>=', 75)->count() / $scoresWithTransmutation->count() * 100
            ];
        })->filter()->sortByDesc('average_transmuted');

        return view('analytics.subject-comparison', compact('comparison'));
    }

    /**
     * Helper method to get scores with transmuted grades - Enhanced
     */
    private function getScoresWithTransmutation($subjectId, $studentId = null)
    {
        $scoresWithPercentages = $this->getScoresWithPercentages($subjectId, $studentId);

        return $scoresWithPercentages->map(function ($score) {
            $transmutedData = $this->getTransmutedGrade($score->percentage);
            
            $score->transmuted_grade = $transmutedData['transmuted'];
            $score->letter_grade = $transmutedData['letter'];
            $score->performance = $transmutedData['performance'];

            return $score;
        });
    }

    /**
     * Helper method to get scores with proper percentage calculations - Enhanced
     */
    private function getScoresWithPercentages($subjectId, $studentId = null)
    {
        $query = Score::where('subject_id', $subjectId)
            ->excludeAttendance(); // Exclude attendance by default for analytics
        
        if ($studentId) {
            $query->where('student_id', $studentId);
        }

        $scores = $query->get();

        // Get max scores map from MaxScore table
        $maxScoresMap = MaxScore::where('subject_id', $subjectId)
            ->pluck('max_score', 'label')
            ->map(function ($v) {
                return (float) $v;
            })->toArray();

        return $scores->map(function ($score) use ($maxScoresMap) {
            $label = $score->label ?? '';
            $labelLower = strtolower($label);
            $typeLower = strtolower($score->type ?? '');

            // Priority: score's max_score -> MaxScore table -> fallback
            if (!empty($score->max_score) && $score->max_score > 0) {
                $effectiveMax = (float) $score->max_score;
            } elseif (isset($maxScoresMap[$score->label]) && $maxScoresMap[$score->label] > 0) {
                $effectiveMax = (float) $maxScoresMap[$score->label];
            } else {
                // Fallback based on type/label
                if ($typeLower === 'attendance' || str_contains($labelLower, 'attendance')) {
                    $effectiveMax = 10.0;
                } elseif ($typeLower === 'activity' || str_contains($labelLower, 'activity')) {
                    $effectiveMax = 100.0;
                } elseif ($typeLower === 'quiz') {
                    $effectiveMax = 20.0;
                } elseif ($typeLower === 'exam') {
                    $effectiveMax = 50.0;
                } else {
                    $effectiveMax = 100.0;
                }
            }

            $rawScore = is_numeric($score->score) ? (float) $score->score : 0.0;
            $percentage = $effectiveMax > 0 ? round(($rawScore / $effectiveMax) * 100, 2) : 0;

            $score->percentage = $percentage;
            $score->max_score = $effectiveMax;

            if (!$score->created_at) {
                $score->created_at = now();
            }

            return $score;
        });
    }

    /**
     * Helper method to determine risk level based on transmuted grade
     */
    private function getTransmutedRiskLevel($transmutedGrade)
    {
        if ($transmutedGrade >= 90) return 'low';
        if ($transmutedGrade >= 75) return 'moderate';
        if ($transmutedGrade >= 70) return 'high';
        return 'critical';
    }

    /**
     * Export analytics data with transmuted grades - Enhanced
     */
    public function exportData(Request $request)
    {
        $teacher = auth()->user();
        $subjectId = $request->subject_id;
        $studentId = $request->student_id;
        
        if (!$subjectId) {
            return redirect()->back()->with('error', 'Please select a subject to export.');
        }

        $subject = Subject::where('id', $subjectId)
            ->where('teacher_id', $teacher->id)
            ->firstOrFail();

        $scoresWithTransmutation = $this->getScoresWithTransmutation($subjectId, $studentId);

        $exportData = $scoresWithTransmutation->groupBy('student_id')
            ->map(function ($studentScores, $studentId) {
                $student = User::find($studentId);
                return [
                    'student_name' => $student ? $student->name : 'Unknown',
                    'average_percentage' => round($studentScores->avg('percentage'), 2),
                    'average_transmuted' => round($studentScores->avg('transmuted_grade'), 2),
                    'total_assessments' => $studentScores->count(),
                    'performance_distribution' => [
                        'excellent' => $studentScores->where('performance', 'Excellent')->count(),
                        'very_good' => $studentScores->where('performance', 'Very Good')->count(),
                        'good' => $studentScores->where('performance', 'Good')->count(),
                        'fair' => $studentScores->where('performance', 'Fair')->count(),
                        'passed' => $studentScores->where('performance', 'Passed')->count(),
                        'failed' => $studentScores->where('performance', 'Failed')->count(),
                    ],
                    'assessments' => $studentScores->map(function ($score) {
                        return [
                            'assessment' => $score->label,
                            'score' => $score->score,
                            'max_score' => $score->max_score,
                            'percentage' => $score->percentage,
                            'transmuted_grade' => $score->transmuted_grade,
                            'letter_grade' => $score->letter_grade,
                            'performance' => $score->performance,
                            'date' => $score->created_at->format('Y-m-d H:i:s')
                        ];
                    })
                ];
            });

        return response()->json([
            'subject' => $subject->name,
            'export_date' => now()->format('Y-m-d H:i:s'),
            'filtered_by_student' => $studentId ? User::find($studentId)->name : 'All Students',
            'total_assessments_available' => $this->getTotalAssessmentsForSubject($subjectId),
            'data' => $exportData
        ]);
    }

    /**
     * Get student list for a subject - Helper method for AJAX requests
     */
    public function getStudentsForSubject(Request $request)
    {
        $subjectId = $request->subject_id;
        
        if (!$subjectId) {
            return response()->json(['students' => []]);
        }

        $students = User::where('role', 'student')
            ->whereHas('scores', function ($q) use ($subjectId) {
                $q->where('subject_id', $subjectId);
            })
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['students' => $students]);
    }

    /**
     * Get quick analytics summary for a subject/student combination
     */
    public function getQuickSummary(Request $request)
    {
        $subjectId = $request->subject_id;
        $studentId = $request->student_id;

        if (!$subjectId) {
            return response()->json(['error' => 'Subject ID required'], 400);
        }

        $scoresWithTransmutation = $this->getScoresWithTransmutation($subjectId, $studentId);

        if ($scoresWithTransmutation->isEmpty()) {
            return response()->json([
                'message' => 'No scores found',
                'data' => [
                    'total_submissions' => 0,
                    'average_transmuted' => 0,
                    'performance_level' => 'No Data'
                ]
            ]);
        }

        $avgTransmuted = round($scoresWithTransmutation->avg('transmuted_grade'), 2);
        $performanceLevel = $this->getTransmutedGrade($scoresWithTransmutation->avg('percentage'))['performance'];

        return response()->json([
            'data' => [
                'total_submissions' => $scoresWithTransmutation->count(),
                'average_transmuted' => $avgTransmuted,
                'average_percentage' => round($scoresWithTransmutation->avg('percentage'), 2),
                'performance_level' => $performanceLevel,
                'risk_level' => $this->getTransmutedRiskLevel($avgTransmuted),
                'distribution' => [
                    'excellent' => $scoresWithTransmutation->where('performance', 'Excellent')->count(),
                    'very_good' => $scoresWithTransmutation->where('performance', 'Very Good')->count(),
                    'good' => $scoresWithTransmutation->where('performance', 'Good')->count(),
                    'fair' => $scoresWithTransmutation->where('performance', 'Fair')->count(),
                    'passed' => $scoresWithTransmutation->where('performance', 'Passed')->count(),
                    'failed' => $scoresWithTransmutation->where('performance', 'Failed')->count(),
                ]
            ]
        ]);
    }
}