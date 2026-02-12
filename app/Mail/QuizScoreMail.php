<?php

// app/Mail/QuizScoreMail.php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizScoreMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $quiz;
    public $score;
    public $maxScore;
    public $percentage;

    public $timeTaken;

public function __construct($student, $quiz, $score, $maxScore, $percentage, $timeTaken = null)
{
    $this->student = $student;
    $this->quiz = $quiz;
    $this->score = $score;
    $this->maxScore = $maxScore;
    $this->percentage = $percentage;
    $this->timeTaken = $timeTaken;
}
    public function build()
    {
        return $this->subject('Your Quiz Score: ' . $this->quiz->title)
            ->view('emails.quiz-score');
    }
}

