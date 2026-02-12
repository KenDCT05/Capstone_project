<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\RiskAlertMail;

class EmailService
{
    /**
     * Send risk alert email to guardian
     */
    public function sendRiskAlert(
        string $guardianEmail,
        string $studentName,
        string $subjectName,
        float $averageTransmuted,
        float $averagePercentage,
        int $failedCount,
        string $riskSeverity,
        string $trend,
        array $failedScores = []
    ): array {
        try {
            Mail::to($guardianEmail)->send(
                new RiskAlertMail(
                    $studentName,
                    $subjectName,
                    $averageTransmuted,
                    $averagePercentage,
                    $failedCount,
                    $riskSeverity,
                    $trend,
                    $failedScores
                )
            );

            return [
                'success' => true,
                'status' => 'sent',
                'error' => null
            ];
        } catch (\Exception $e) {
            Log::error('Email sending failed', [
                'email' => $guardianEmail,
                'student' => $studentName,
                'error' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status' => 'failed',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Send bulk risk alerts
     */
    public function sendBulkRiskAlerts(array $students): array
    {
        $results = [
            'sent' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($students as $student) {
            if (empty($student['guardian_email'])) {
                $results['failed']++;
                $results['errors'][] = "No email for {$student['student_name']}";
                continue;
            }

            $sent = $this->sendRiskAlert(
                $student['guardian_email'],
                $student['student_name'],
                $student['subject_name'],
                $student['average_transmuted'],
                $student['average_percentage'],
                $student['failed_count'],
                $student['risk_severity'],
                $student['trend'],
                $student['failed_scores'] ?? []
            );

            if ($sent) {
                $results['sent']++;
            } else {
                $results['failed']++;
                $results['errors'][] = "Failed to send email to {$student['guardian_email']}";
            }
        }

        return $results;
    }
}