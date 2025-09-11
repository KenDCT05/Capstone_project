<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Results - {{ $quiz->title }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #007bff;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .greeting {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .quiz-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #007bff;
        }
        .score-container {
            text-align: center;
            margin: 25px 0;
        }
        .score {
            font-size: 32px;
            font-weight: bold;
            color: #28a745;
            margin: 10px 0;
        }
        .percentage {
            font-size: 20px;
            color: #6c757d;
            background: #e9ecef;
            padding: 8px 16px;
            border-radius: 20px;
            display: inline-block;
        }
        .performance-message {
            padding: 15px;
            margin: 20px 0;
            border-radius: 6px;
            text-align: center;
            font-weight: 500;
        }
        .excellent { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .good { background: #d1ecf1; color: #0c5460; border: 1px solid #bee5eb; }
        .fair { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .needs-improvement { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 14px;
            color: #6c757d;
        }
        .signature {
            margin-top: 20px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Learning Management System</div>
            <div style="color: #6c757d;">Quiz Results Notification</div>
        </div>

        <div class="greeting">
            Dear {{ $student->name }},
        </div>

        <p>We are pleased to inform you that you have successfully completed the following assessment:</p>

        <div class="quiz-info">
            <strong>Quiz Title:</strong> {{ $quiz->title }}<br>
            <strong>Completion Date:</strong> {{ now()->format('F j, Y \a\t g:i A') }}<br>
            <strong>Time Taken:</strong> {{ $timeTaken ?? 'Not recorded' }}
        </div>

        <div class="score-container">
            <div style="font-size: 16px; color: #6c757d; margin-bottom: 10px;">Your Score</div>
            <div class="score">{{ $score }} / {{ $maxScore }}</div>
            <div class="percentage">{{ $percentage }}%</div>
        </div>

        @php
            $performanceClass = 'needs-improvement';
            $performanceMessage = 'Keep practicing to improve your understanding of the material.';
            
            if ($percentage >= 90) {
                $performanceClass = 'excellent';
                $performanceMessage = 'Excellent work! You have demonstrated outstanding mastery of the subject matter.';
            } elseif ($percentage >= 80) {
                $performanceClass = 'good';
                $performanceMessage = 'Great job! You have shown a solid understanding of the course material.';
            } elseif ($percentage >= 70) {
                $performanceClass = 'fair';
                $performanceMessage = 'Good effort! Consider reviewing the areas where you missed questions.';
            }
        @endphp

        <div class="performance-message {{ $performanceClass }}">
            {{ $performanceMessage }}
        </div>

        <p>Your quiz results have been recorded in your academic profile. You can review detailed feedback and correct answers by logging into your student dashboard.</p>

        <p>If you have any questions about your results or need additional support with the course material, please don't hesitate to contact your instructor or our academic support team.</p>

        <div class="footer">
            <p><strong>Next Steps:</strong></p>
            <ul style="text-align: left; color: #495057;">
                <li>Review your quiz feedback in the student portal</li>
                <li>Continue with the next module if available</li>
                <li>Schedule office hours if you need additional help</li>
            </ul>

            <div class="signature">
                <p>Best regards,<br>
                <strong>The Academic Team</strong><br>
                Learning Management System</p>
            </div>
        </div>
    </div>
</body>
</html>