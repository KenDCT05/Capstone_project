<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Score;
use App\Models\Subject;
use App\Models\MaxScore;
use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\SmsLog;
use App\Models\EngagementLog;
use Illuminate\Support\Facades\DB;
use App\Services\EmailService;
use App\Models\EmailLog;


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
public function riskAlerts(Request $request, SmsService $sms, EmailService $emailService)
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

    $allStudentsForFilter = User::whereIn('id', $studentIds)
       ->where('role', 'student')
       ->select('id', 'name')
       ->orderBy('name')
       ->get();

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

            $recentScores = $scoresWithTransmutation->where('created_at', '>=', now()->subWeeks(3));
            $olderScores = $scoresWithTransmutation->where('created_at', '<', now()->subWeeks(3));
            
            $trend = 'stable';
            if ($recentScores->count() >= 2 && $olderScores->count() >= 2) {
                $recentAvg = $recentScores->avg('transmuted_grade');
                $olderAvg = $olderScores->avg('transmuted_grade');
                $difference = $recentAvg - $olderAvg;
                
                if ($difference >= 5) $trend = 'improving';
                elseif ($difference <= -5) $trend = 'declining';
            }

            $avgTransmuted = round($scoresWithTransmutation->avg('transmuted_grade'), 2);
            $avgPercentage = round($scoresWithTransmutation->avg('percentage'), 2);

            $allFailedScores = $scoresWithTransmutation->filter(fn($s) => $s->transmuted_grade < 75);
            $recentFailedScores = $allFailedScores->where('created_at', '>=', now()->subWeeks(2));
            $failedCount = $allFailedScores->count();
            $recentFailedCount = $recentFailedScores->count();

            $riskSeverity = $this->calculateRiskSeverity(
                $failedCount, 
                $recentFailedCount, 
                $avgTransmuted, 
                $trend,
                $scoresWithTransmutation->count()
            );

            $studentData->push([
                'student_id'        => $student->id,
                'student_name'      => $student->name,
                'guardian_contact'  => $student->guardian_contact,
                'guardian_email'    => $student->guardian_email,
                'subject_id'        => $subjectId,
                'subject_name'      => $subjects->firstWhere('id', $subjectId)->name ?? 'Unknown',
                'average_transmuted'=> $avgTransmuted,
                'average_percentage'=> $avgPercentage,
                'total_assessments' => $scoresWithTransmutation->count(),
                'failed_count'      => $failedCount,
                'recent_failed_count' => $recentFailedCount,
                'failed_scores'     => $allFailedScores,
                'trend'             => $trend,
                'risk_severity'     => $riskSeverity,
                'risk_level'        => $this->getTransmutedRiskLevel($avgTransmuted),
                'performance_level' => $this->getTransmutedGrade($avgPercentage)['performance'],
            ]);
        }
    }

    $criticalRisk = $studentData->filter(fn($s) => $s['risk_severity'] === 'critical');
    $highRisk = $studentData->filter(fn($s) => $s['risk_severity'] === 'high');
    $atRisk = $studentData->filter(fn($s) => $s['average_transmuted'] < 75)
        ->sortByDesc(fn($s) => [$s['risk_severity'] === 'critical' ? 3 : ($s['risk_severity'] === 'high' ? 2 : 1), $s['failed_count']]);

    $safeStudents = $studentData->filter(fn($s) => $s['average_transmuted'] >= 75)
        ->sortByDesc('average_transmuted');

    $allStudentsForAlerts = $studentData->filter(fn($s) => $s['failed_count'] >= 3);
    
    foreach ($allStudentsForAlerts as $student) {
        $daysSinceLastSms = $this->getDaysSinceLastAlert($student['student_id'], 'sms', $student['guardian_contact']);
        $daysSinceLastEmail = $this->getDaysSinceLastAlert($student['student_id'], 'email', $student['guardian_email']);
        
        $requiredGap = match($student['risk_severity']) {
            'critical' => 7,  
            'high' => 10,      
            default => 12,      
        };

// Send SMS
if (!empty($student['guardian_contact']) && $daysSinceLastSms >= $requiredGap) {
    $urgencyLevel = match($student['risk_severity']) {
        'critical' => "URGENT: ",
        'high' => "High Priority: ",
        default => ""
    };

    $message = "{$urgencyLevel}Parent/Guardian of {$student['student_name']}: "
        . "Current {$student['subject_name']} average is {$student['average_transmuted']}%. "
        . "Please contact teacher for support.";

    $smsResult = $sms->send($student['guardian_contact'], $message);

    // Log both successful and failed attempts
    SmsLog::create([
        'student_id'       => $student['student_id'],
        'guardian_contact' => $student['guardian_contact'],
        'message'          => $message,
        'status'           => $smsResult['status'],
        'error_message'    => $smsResult['error'],
        'sent_at'          => now(),
        'risk_severity'    => $student['risk_severity'],
        'failed_count'     => $student['failed_count'],
        'trend'            => $student['trend'],
    ]);
}

// Send Email
if (!empty($student['guardian_email']) && $daysSinceLastEmail >= $requiredGap) {
    $failedScoresList = $student['failed_scores']->take(5)->map(function($s) {
        return [
            'label' => $s->label ?? 'Assessment',
            'score' => $s->score ?? 0,
            'max_score' => $s->max_score ?? 100,
            'transmuted_grade' => $s->transmuted_grade ?? 0,
            'date' => $s->created_at->format('M d, Y')
        ];
    })->toArray();

    $emailResult = $emailService->sendRiskAlert(
        $student['guardian_email'],
        $student['student_name'],
        $student['subject_name'],
        $student['average_transmuted'],
        $student['average_percentage'],
        $student['failed_count'],
        $student['risk_severity'],
        $student['trend'],
        $failedScoresList
    );

    // Log both successful and failed attempts
    EmailLog::create([
        'student_id'       => $student['student_id'],
        'guardian_email'   => $student['guardian_email'],
        'message'          => json_encode($failedScoresList),
        'subject'          => match($student['risk_severity']) {
            'critical' => "URGENT: Academic Alert for {$student['student_name']}",
            'high' => "Important: Academic Performance Notice",
            default => "Academic Update for {$student['student_name']}"
        },
        'status'           => $emailResult['status'],
        'error_message'    => $emailResult['error'],
        'sent_at'          => now(),
        'risk_severity'    => $student['risk_severity'],
        'failed_count'     => $student['failed_count'],
        'trend'            => $student['trend'],
    ]);
}
    }

    return view('analytics.risk-alerts', compact(
        'atRisk', 'safeStudents', 'subjects', 'selectedSubject', 'selectedStudent',
        'criticalRisk', 'highRisk', 'allStudentsForFilter'
    ));
}

// Risk severity calculation

private function calculateRiskSeverity($totalFailed, $recentFailed, $avgGrade, $trend, $totalAssessments)
{
    $score = 0;
    
    // Factor 1: Total failures relative to total assessments
    $failureRate = $totalAssessments > 0 ? ($totalFailed / $totalAssessments) : 0;
    if ($failureRate >= 0.6) $score += 3;
    elseif ($failureRate >= 0.4) $score += 2;
    elseif ($failureRate >= 0.2) $score += 1;
    
    // Factor 2: Recent failure pattern 
    if ($recentFailed >= 3) $score += 3;
    elseif ($recentFailed >= 2) $score += 2;
    elseif ($recentFailed >= 1) $score += 1;
    
    // Factor 3: Overall grade
    if ($avgGrade < 60) $score += 3;
    elseif ($avgGrade < 70) $score += 2;
    elseif ($avgGrade < 75) $score += 1;
    
    // Factor 4: Trend direction
    if ($trend === 'declining') $score += 2;
    elseif ($trend === 'improving') $score -= 1;
    
    // Classify severity
    if ($score >= 7) return 'critical';
    if ($score >= 4) return 'high';
    if ($score >= 2) return 'moderate';
    return 'low';
}
 public function insights($studentId)
    {
        $student = User::findOrFail($studentId);
        $teacher = auth()->user();
        
$subjects = Subject::where('teacher_id', $teacher->id)
    ->whereHas('students', function ($query) use ($studentId) {
        $query->where('subject_user.user_id', $studentId);
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

        // Group scores by student and calculate their average
        $studentAverages = $scoresWithTransmutation->groupBy('student_id')
            ->map(function ($studentScores) {
                return round($studentScores->avg('transmuted_grade'), 2);
            });

        // Count students who passed (avg >= 75) and failed (avg < 75)
        $passedCount = $studentAverages->filter(fn($avg) => $avg >= 75)->count();
        $failedCount = $studentAverages->filter(fn($avg) => $avg < 75)->count();

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
            'passing_rate' => ($passedCount / $studentAverages->count()) * 100,
            'passed_count' => $passedCount,
            'failed_count' => $failedCount,
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
    
public function engagementAnalytics(Request $request) 
{
    $subjectId = $request->get('subject_id');
    $dateFrom = $request->get('date_from');
    $dateTo = $request->get('date_to');

    // Get students enrolled in this teacher's subjects
    $students = User::where('role', 'student')
        ->when($subjectId, function ($query) use ($subjectId) {
            $query->whereHas('subjects', function ($q) use ($subjectId) {
                $q->where('subjects.id', $subjectId);
            });
        })
        ->whereHas('subjects', function ($q) {
            $q->where('teacher_id', auth()->id());
        })
        ->pluck('id');

    // Build engagement query with hybrid subject filtering
    $engagementQuery = EngagementLog::whereIn('user_id', $students);
    
    // Apply date filters
    if ($dateFrom) {
        $engagementQuery->where('created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
    }
    
    if ($dateTo) {
        $engagementQuery->where('created_at', '<=', Carbon::parse($dateTo)->endOfDay());
    }

    // HYBRID FILTERING: login and course_enrollment are global
    if ($subjectId) {
        $engagementQuery->where(function($q) use ($subjectId) {
            $q->where('action', 'login') // Global
              ->orWhere('action', 'course_enrollment') // Global
              ->orWhere('subject_id', $subjectId); // Subject-specific
        });
    }

    // Aggregate engagement data
    $engagementSummary = $engagementQuery
        ->select(
            'user_id',
            'action',
            DB::raw("COUNT(DISTINCT id) as total"),
            DB::raw("SUM(COALESCE(value, 0)) as total_value")
        )
        ->groupBy('user_id', 'action')
        ->with(['user' => function($query) {
            $query->where('role', 'student');
        }])
        ->get()
        ->filter(function($record) {
            return $record->user && $record->user->role === 'student';
        })
        ->groupBy('user_id')
        ->sortByDesc(function ($records) {
            return $records->sum('total');
        });

    // Activity statistics with hybrid filtering
    $activityStats = [
        'logins' => $this->getActivityCount('login', $students, $subjectId, $dateFrom, $dateTo, true),
        'quizzes' => $this->getActivityCount('quiz_attempt', $students, $subjectId, $dateFrom, $dateTo),
        'uploads' => $this->getActivityCount('activity_upload', $students, $subjectId, $dateFrom, $dateTo),
        'enrollments' => $this->getActivityCount('course_enrollment', $students, $subjectId, $dateFrom, $dateTo, true), // NOW GLOBAL
        'downloads' => $this->getActivityCount('material_download', $students, $subjectId, $dateFrom, $dateTo),
    ];

    // Generate heatmap data with hybrid filtering
    $heatmapData = $this->generateHeatmapData($students, $subjectId, $dateFrom, $dateTo);

    // Get all subjects for filter dropdown
    $subjects = Subject::where('teacher_id', auth()->id())
        ->with('teacher:id,name')
        ->get();

    return view('analytics.engagement', compact(
        'engagementSummary', 
        'activityStats', 
        'subjects', 
        'subjectId',
        'heatmapData',
        'dateFrom',
        'dateTo'
    ));
}


private function generateHeatmapData($students, $subjectId, $dateFrom, $dateTo)
{
    $query = EngagementLog::whereIn('user_id', $students);

    // Apply date filters
    if ($dateFrom) {
        $query->where('created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
    }
    if ($dateTo) {
        $query->where('created_at', '<=', Carbon::parse($dateTo)->endOfDay());
    }

    // Apply hybrid subject filtering - login and course_enrollment are global
    if ($subjectId) {
        $query->where(function($q) use ($subjectId) {
            $q->where('action', 'login')
              ->orWhere('action', 'course_enrollment')
              ->orWhere('subject_id', $subjectId);
        });
    }

    // Daily activity heatmap
    $dailyActivity = $query->clone()
        ->select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total'),
            'action'
        )
        ->groupBy('date', 'action')
        ->orderBy('date')
        ->get()
        ->groupBy('date')
        ->map(function($records, $date) {
            return [
                'date' => $date,
                'total' => $records->sum('total'),
                'activities' => [
                    'login' => $records->where('action', 'login')->sum('total'),
                    'quiz_attempt' => $records->where('action', 'quiz_attempt')->sum('total'),
                    'activity_upload' => $records->where('action', 'activity_upload')->sum('total'),
                    'course_enrollment' => $records->where('action', 'course_enrollment')->sum('total'),
                    'material_download' => $records->where('action', 'material_download')->sum('total'),
                ]
            ];
        })->values();

    // Weekly pattern heatmap
    $weeklyPattern = $query->clone()
        ->select(
            DB::raw('IF(DAYOFWEEK(created_at) = 1, 6, DAYOFWEEK(created_at) - 2) as day'),  
            DB::raw('HOUR(created_at) as hour'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('day', 'hour')
        ->get()
        ->map(function($record) {
            return [
                'day' => $record->day,
                'hour' => $record->hour,
                'count' => $record->count
            ];
        });

    // Student activity matrix
    $studentMatrix = $query->clone()
        ->select(
            'user_id',
            'action',
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('user_id', 'action')
        ->with('user:id,name')
        ->get()
        ->groupBy('user_id')
        ->map(function($records, $userId) {
            $user = $records->first()->user;
            return [
                'student_name' => $user ? $user->name : 'Unknown',
                'activities' => [
                    'login' => $records->where('action', 'login')->sum('count'),
                    'quiz_attempt' => $records->where('action', 'quiz_attempt')->sum('count'),
                    'activity_upload' => $records->where('action', 'activity_upload')->sum('count'),
                    'course_enrollment' => $records->where('action', 'course_enrollment')->sum('count'),
                    'material_download' => $records->where('action', 'material_download')->sum('count'),
                ]
            ];
        })->values();

    return [
        'daily_activity' => $dailyActivity,
        'weekly_pattern' => $weeklyPattern,
        'student_matrix' => [
            'matrix' => $studentMatrix,
            'activities' => ['login', 'quiz_attempt', 'activity_upload', 'course_enrollment', 'material_download']
        ]
    ];
}

private function formatDailyActivityData($data, $startDate, $endDate)
{
    $formatted = [];
    $current = $startDate->copy();
    
    // Initialize all dates with zero counts
    while ($current->lte($endDate)) {
        $dateStr = $current->format('Y-m-d');
        $formatted[$dateStr] = [
            'date' => $dateStr,
            'total' => 0,
            'activities' => [
                'login' => 0,
                'quiz_attempt' => 0,
                'activity_upload' => 0,
                'course_enrollment' => 0,
                'material_download' => 0
            ]
        ];
        $current->addDay();
    }
    
    // FIXED: Properly aggregate data by date and action
    foreach ($data as $record) {
        $date = $record->date;
        $action = $record->action;
        $count = (int) $record->count;
        
        if (isset($formatted[$date]) && isset($formatted[$date]['activities'][$action])) {
            $formatted[$date]['activities'][$action] += $count; // Sum the counts
        }
    }
    
    // Calculate totals for each date
    foreach ($formatted as $date => &$dayData) {
        $dayData['total'] = array_sum($dayData['activities']);
        
        // DEBUG: Log daily calculations
        \Log::info("FIXED - Date {$date} - Activities: " . json_encode($dayData['activities']) . " - Total: " . $dayData['total']);
    }
    
    return array_values($formatted);
}

private function formatWeeklyPatternData($data)
{
    $formatted = [];
    
    // Initialize 24 hours x 7 days grid
    for ($day = 1; $day <= 7; $day++) {
        for ($hour = 0; $hour < 24; $hour++) {
            $formatted[] = [
                'day' => $day - 1, // 0-6 for Monday-Sunday
                'hour' => $hour,
                'count' => 0
            ];
        }
    }
    
    // FIXED: Properly aggregate activity data by day/hour
    $aggregatedData = [];
    foreach ($data as $record) {
        $key = $record->day_of_week . '-' . $record->hour;
        if (!isset($aggregatedData[$key])) {
            $aggregatedData[$key] = [
                'day_of_week' => $record->day_of_week,
                'hour' => $record->hour,
                'count' => 0
            ];
        }
        $aggregatedData[$key]['count'] += (int)$record->count; // Sum all activity types
    }
    
    // Fill formatted array with aggregated data
    foreach ($aggregatedData as $record) {
        $dayIndex = ($record['day_of_week'] == 1) ? 6 : $record['day_of_week'] - 2;
        $hourIndex = (int)$record['hour'];
        
        $index = ($dayIndex * 24) + $hourIndex;
        if (isset($formatted[$index])) {
            $formatted[$index]['count'] = (int)$record['count'];
        }
    }
    
    return $formatted;
}

private function formatStudentMatrixData($data)
{
    $matrix = [];
    $students = [];
    $activities = ['login', 'quiz_attempt', 'activity_upload', 'course_enrollment', 'material_download'];
    
    // FIXED: Ensure we only process student data
    $groupedData = $data->filter(function($item) {
        return $item->user && $item->user->role === 'student';
    })->groupBy('user_id');
    
    \Log::info('Matrix Debug - Processing ' . $groupedData->count() . ' students');
    
    foreach ($groupedData as $userId => $records) {
        $student = $records->first()->user;
        
        // Additional safety check
        if (!$student || $student->role !== 'student') {
            \Log::warning('Matrix Debug - Skipping non-student user: ' . $userId);
            continue;
        }
        
        $students[] = [
            'id' => $userId,
            'name' => $student->name
        ];
        
        $studentActivities = [];
        foreach ($activities as $activity) {
            $activityRecord = $records->where('action', $activity)->first();
            $studentActivities[$activity] = $activityRecord ? (int)$activityRecord->count : 0;
        }
        
        $matrix[] = [
            'student_id' => $userId,
            'student_name' => $student->name,
            'activities' => $studentActivities,
            'total' => array_sum($studentActivities)
        ];
        
        \Log::info("Matrix Debug - Student: {$student->name}, Activities: " . json_encode($studentActivities) . ", Total: " . array_sum($studentActivities));
    }
    
    // Sort by total activity
    usort($matrix, function($a, $b) {
        return $b['total'] - $a['total'];
    });
    
    \Log::info('Matrix Debug - Final matrix has ' . count($matrix) . ' students');
    
    return [
        'matrix' => $matrix,
        'activities' => $activities,
        'students' => $students
    ];
}

public function logTimeSpent(Request $request) 
{
    $validated = $request->validate([
        'time_spent' => 'required|integer|min:1|max:7200',
        'page' => 'required|string|max:255',
    ]);

    EngagementLog::create([
        'user_id' => auth()->id(),
        'action' => 'time_spent',
        'context' => 'page:' . $validated['page'],
        'value' => $validated['time_spent'],
    ]);

    return response()->json(['status' => 'success']);
}
private function getActivityCount($action, $students, $subjectId, $dateFrom, $dateTo, $isGlobal = false)
{
    $query = EngagementLog::whereIn('user_id', $students)
        ->where('action', $action);

    // Apply date filters
    if ($dateFrom) {
        $query->where('created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
    }
    if ($dateTo) {
        $query->where('created_at', '<=', Carbon::parse($dateTo)->endOfDay());
    }

    // For non-global actions, filter by subject_id
    if ($subjectId && !$isGlobal) {
        $query->where('subject_id', $subjectId);
    }

    return $query->count();
}
/**
 * Display communication logs (SMS & Email)
 */
public function communicationLogs(Request $request)
{
    $teacher = auth()->user();
    $type = $request->input('type');
    $studentId = $request->input('student_id');
    $riskSeverity = $request->input('risk_severity');
    $dateFrom = $request->input('date_from');

    // Get teacher's students
    $students = User::where('role', 'student')
        ->whereHas('subjects', function ($q) use ($teacher) {
            $q->where('teacher_id', $teacher->id);
        })
        ->orderBy('name')
        ->get();

    $studentIds = $students->pluck('id');

    // Fetch SMS logs
    $smsQuery = \App\Models\SmsLog::whereIn('student_id', $studentIds)
        ->when($studentId, fn($q) => $q->where('student_id', $studentId))
        ->when($riskSeverity, fn($q) => $q->where('risk_severity', $riskSeverity))
        ->when($dateFrom, fn($q) => $q->whereDate('sent_at', '>=', $dateFrom));

    // Fetch Email logs
    $emailQuery = \App\Models\EmailLog::whereIn('student_id', $studentIds)
        ->when($studentId, fn($q) => $q->where('student_id', $studentId))
        ->when($riskSeverity, fn($q) => $q->where('risk_severity', $riskSeverity))
        ->when($dateFrom, fn($q) => $q->whereDate('sent_at', '>=', $dateFrom));

    $smsLogs = collect();
    $emailLogs = collect();

    if (!$type || $type === 'sms') {
        $smsLogs = $smsQuery->with('student')->latest('sent_at')->get();
    }

    if (!$type || $type === 'email') {
        $emailLogs = $emailQuery->with('student')->latest('sent_at')->get();
    }

    // Combine and format logs
    $combinedLogs = collect();

    foreach ($smsLogs as $log) {
    $combinedLogs->push([
        'id' => $log->id,
        'type' => 'sms',
        'student_id' => $log->student_id,
        'student_name' => $log->student->name ?? 'Unknown',
        'contact' => $log->guardian_contact,
        'message' => $log->message,
        'subject' => null,
        'risk_severity' => $log->risk_severity,
        'failed_count' => $log->failed_count,
        'trend' => $log->trend,
        'status' => $log->status ?? 'sent', // NEW
        'error_message' => $log->error_message ?? null, // NEW
        'sent_at' => $log->sent_at,
        'sent_at_human' => $log->sent_at->diffForHumans(),
    ]);
}

foreach ($emailLogs as $log) {
    $combinedLogs->push([
        'id' => $log->id,
        'type' => 'email',
        'student_id' => $log->student_id,
        'student_name' => $log->student->name ?? 'Unknown',
        'contact' => $log->guardian_email,
        'message' => $log->message,
        'subject' => $log->subject,
        'risk_severity' => $log->risk_severity,
        'failed_count' => $log->failed_count,
        'trend' => $log->trend,
        'status' => $log->status ?? 'sent', // NEW
        'error_message' => $log->error_message ?? null, // NEW
        'sent_at' => $log->sent_at,
        'sent_at_human' => $log->sent_at->diffForHumans(),
    ]);
}

    // Sort by sent_at descending
    $combinedLogs = $combinedLogs->sortByDesc('sent_at');

    // Calculate statistics
    $totalCount = $combinedLogs->count();
    $criticalCount = $combinedLogs->where('risk_severity', 'critical')->count();
    $uniqueParents = $combinedLogs->unique(function ($log) {
        return $log['student_id'] . '-' . $log['contact'];
    })->count();

    return view('analytics.communication-logs', compact(
        'combinedLogs',
        'smsLogs',
        'emailLogs',
        'students',
        'totalCount',
        'criticalCount',
        'uniqueParents'
    ));
}

/**
 * View individual email log details
 */
public function viewEmailLog($id)
{
    $teacher = auth()->user();
    
    $emailLog = \App\Models\EmailLog::with('student')
        ->findOrFail($id);
    
    // Verify teacher has access to this student
    $hasAccess = $emailLog->student->subjects()
        ->where('teacher_id', $teacher->id)
        ->exists();
    
    if (!$hasAccess) {
        abort(403, 'Unauthorized access to email log');
    }
    
    $failedScores = json_decode($emailLog->message, true) ?? [];
    
    return view('analytics.email-log-detail', compact('emailLog', 'failedScores'));
}

/**
 * Helper method to get days since last alert
 */
private function getDaysSinceLastAlert($studentId, $type, $contact)
{
    if ($type === 'sms') {
        $lastAlert = SmsLog::where('student_id', $studentId)
            ->where('guardian_contact', $contact)
            ->latest('sent_at')
            ->first();
    } else {
        $lastAlert = EmailLog::where('student_id', $studentId)
            ->where('guardian_email', $contact)
            ->latest('sent_at')
            ->first();
    }

    return $lastAlert ? Carbon::parse($lastAlert->sent_at)->diffInDays(now()) : 999;
}
/**
 * Retry failed SMS
 */
public function retrySms(Request $request, SmsService $sms)
{
    $logId = $request->input('log_id');
    $log = \App\Models\SmsLog::findOrFail($logId);
    
    // Verify teacher has access to this student
    $teacher = auth()->user();
    $hasAccess = $log->student->subjects()->where('teacher_id', $teacher->id)->exists();
    
    if (!$hasAccess) {
        return response()->json([
            'success' => false, 
            'message' => 'Unauthorized access'
        ], 403);
    }

    // Retry sending SMS
    $result = $sms->send($log->guardian_contact, $log->message);

    // Update the log with new status
    $log->update([
        'status' => $result['status'],
        'error_message' => $result['error'],
        'sent_at' => $result['success'] ? now() : $log->sent_at,
    ]);

    return response()->json([
        'success' => $result['success'],
        'message' => $result['success'] 
            ? 'SMS sent successfully!' 
            : 'Failed to send SMS: ' . $result['error'],
        'status' => $result['status']
    ]);
}

/**
 * Retry failed email
 */
public function retryEmail(Request $request, \App\Services\EmailService $emailService)
{
    $logId = $request->input('log_id');
    $log = \App\Models\EmailLog::findOrFail($logId);
    
    // Verify teacher has access to this student
    $teacher = auth()->user();
    $hasAccess = $log->student->subjects()->where('teacher_id', $teacher->id)->exists();
    
    if (!$hasAccess) {
        return response()->json([
            'success' => false, 
            'message' => 'Unauthorized access'
        ], 403);
    }

    // Parse the stored data
    $failedScores = json_decode($log->message, true) ?? [];
    
    // Get fresh student data for accurate info
    $scoresWithTransmutation = $this->getScoresWithTransmutation(
        $log->student->subjects()->where('teacher_id', $teacher->id)->first()->id ?? 0,
        $log->student_id
    );
    
    $avgTransmuted = $scoresWithTransmutation->isNotEmpty() 
        ? round($scoresWithTransmutation->avg('transmuted_grade'), 2)
        : 0;
    
    $avgPercentage = $scoresWithTransmutation->isNotEmpty()
        ? round($scoresWithTransmutation->avg('percentage'), 2)
        : 0;
    
    // Get subject name
    $subject = $log->student->subjects()->where('teacher_id', $teacher->id)->first();
    $subjectName = $subject ? $subject->name : 'Subject';
    
    // Retry sending email
    $result = $emailService->sendRiskAlert(
        $log->guardian_email,
        $log->student->name,
        $subjectName,
        $avgTransmuted,
        $avgPercentage,
        $log->failed_count ?? 0,
        $log->risk_severity ?? 'moderate',
        $log->trend ?? 'stable',
        $failedScores
    );

    // Update the log with new status
    $log->update([
        'status' => $result['status'],
        'error_message' => $result['error'],
        'sent_at' => $result['success'] ? now() : $log->sent_at,
    ]);

    return response()->json([
        'success' => $result['success'],
        'message' => $result['success'] 
            ? 'Email sent successfully!' 
            : 'Failed to send email: ' . $result['error'],
        'status' => $result['status']
    ]);
}
}