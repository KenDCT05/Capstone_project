<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RiskAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $studentName;
    public string $subjectName;
    public float $averageTransmuted;
    public float $averagePercentage;
    public int $failedCount;
    public string $riskSeverity;
    public string $trend;
    public array $failedScores;

    public function __construct(
        string $studentName,
        string $subjectName,
        float $averageTransmuted,
        float $averagePercentage,
        int $failedCount,
        string $riskSeverity,
        string $trend,
        array $failedScores = []
    ) {
        $this->studentName = $studentName;
        $this->subjectName = $subjectName;
        $this->averageTransmuted = $averageTransmuted;
        $this->averagePercentage = $averagePercentage;
        $this->failedCount = $failedCount;
        $this->riskSeverity = $riskSeverity;
        $this->trend = $trend;
        $this->failedScores = $failedScores;
    }

    public function build()
    {
        $subject = match($this->riskSeverity) {
            'critical' => "URGENT: Academic Alert for {$this->studentName}",
            'high' => "Important: Academic Performance Notice - {$this->studentName}",
            default => "Academic Update for {$this->studentName}"
        };

        return $this->subject($subject)
                    ->view('emails.risk-alert')
                    ->with([
                        'studentName' => $this->studentName,
                        'subjectName' => $this->subjectName,
                        'averageTransmuted' => $this->averageTransmuted,
                        'averagePercentage' => $this->averagePercentage,
                        'failedCount' => $this->failedCount,
                        'riskSeverity' => $this->riskSeverity,
                        'trend' => $this->trend,
                        'failedScores' => $this->failedScores,
                    ]);
    }
}