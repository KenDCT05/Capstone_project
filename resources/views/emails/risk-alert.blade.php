<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            padding: 30px 20px;
            text-align: center;
            color: white;
        }
        .header-critical {
            background: linear-gradient(135deg, #dc2626, #991b1b);
        }
        .header-high {
            background: linear-gradient(135deg, #ea580c, #c2410c);
        }
        .header-moderate {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid;
        }
        .alert-critical {
            background-color: #fee2e2;
            border-color: #dc2626;
            color: #991b1b;
        }
        .alert-high {
            background-color: #ffedd5;
            border-color: #ea580c;
            color: #9a3412;
        }
        .alert-moderate {
            background-color: #fef3c7;
            border-color: #f59e0b;
            color: #92400e;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .stat-card {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .stat-label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
        }
        .trend-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .trend-improving {
            background-color: #d1fae5;
            color: #065f46;
        }
        .trend-declining {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .trend-stable {
            background-color: #e5e7eb;
            color: #374151;
        }
        .failed-scores {
            background-color: #fef2f2;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #fecaca;
        }
        .score-item {
            padding: 10px;
            margin: 8px 0;
            background-color: white;
            border-radius: 6px;
            border-left: 3px solid #dc2626;
        }
        .score-header {
            font-weight: 600;
            color: #111827;
            margin-bottom: 4px;
        }
        .score-details {
            font-size: 14px;
            color: #6b7280;
        }
        .action-section {
            background-color: #eff6ff;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border: 1px solid #dbeafe;
        }
        .action-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 10px;
        }
        .action-list {
            margin: 0;
            padding-left: 20px;
        }
        .action-list li {
            margin: 8px 0;
            color: #374151;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #6b7280;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 24px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header header-{{ $riskSeverity }}">
            @if($riskSeverity === 'critical')
                <h1>🚨 URGENT: Academic Alert</h1>
            @elseif($riskSeverity === 'high')
                <h1>⚠️ Important Academic Notice</h1>
            @else
                <h1>📊 Academic Performance Update</h1>
            @endif
            <p>Regarding: {{ $studentName }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Greeting -->
            <p style="font-size: 16px; margin-bottom: 20px;">
                Dear Parent/Guardian,
            </p>

            <!-- Alert Box -->
            <div class="alert-box alert-{{ $riskSeverity }}">
                <strong>
                    @if($riskSeverity === 'critical')
                        This is an urgent notification regarding {{ $studentName }}'s academic performance in {{ $subjectName }}.
                    @elseif($riskSeverity === 'high')
                        We are writing to inform you about {{ $studentName }}'s current performance in {{ $subjectName }}.
                    @else
                        This is an update about {{ $studentName }}'s progress in {{ $subjectName }}.
                    @endif
                </strong>
            </div>

            <!-- Performance Statistics -->
            <h3 style="color: #111827; margin-top: 20px;">Current Performance Overview</h3>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-label">Transmuted Grade</div>
                    <div class="stat-value" style="color: {{ $averageTransmuted < 60 ? '#dc2626' : ($averageTransmuted < 75 ? '#ea580c' : '#10b981') }}">
                        {{ number_format($averageTransmuted, 2) }}%
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Raw Percentage</div>
                    <div class="stat-value">{{ number_format($averagePercentage, 2) }}%</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Failed Assessments</div>
                    <div class="stat-value" style="color: #dc2626;">{{ $failedCount }}</div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Performance Trend</div>
                    <div class="stat-value" style="font-size: 18px;">
                        <span class="trend-badge trend-{{ $trend }}">
                            @if($trend === 'improving')
                                ↗ Improving
                            @elseif($trend === 'declining')
                                ↘ Declining
                            @else
                                → Stable
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Failed Scores Details -->
            @if(count($failedScores) > 0)
                <h3 style="color: #111827; margin-top: 25px;">Recent Failed Assessments</h3>
                <div class="failed-scores">
                    @foreach($failedScores as $score)
                        <div class="score-item">
                            <div class="score-header">{{ $score['label'] }}</div>
                            <div class="score-details">
                                Score: {{ $score['score'] }}/{{ $score['max_score'] }} 
                                ({{ $score['transmuted_grade'] }}% transmuted) 
                                - {{ $score['date'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Trend Analysis -->
            @if($trend === 'declining')
                <div class="alert-box alert-critical">
                    <strong>⚠️ Declining Performance Detected:</strong> 
                    {{ $studentName }}'s performance has been declining in recent weeks. 
                    Immediate intervention is recommended.
                </div>
            @elseif($trend === 'improving')
                <div class="alert-box" style="background-color: #d1fae5; border-color: #10b981; color: #065f46;">
                    <strong>📈 Positive Progress:</strong> 
                    {{ $studentName }} is showing improvement! Continue supporting their efforts.
                </div>
            @endif

            <!-- Recommended Actions -->
            <div class="action-section">
                <div class="action-title">Recommended Next Steps:</div>
                <ul class="action-list">
                    @if($riskSeverity === 'critical')
                        <li>Schedule an urgent meeting with the teacher</li>
                        <li>Review study habits and learning environment at home</li>
                        <li>Consider additional tutoring or academic support</li>
                        <li>Discuss any external factors affecting performance</li>
                        <li>Develop a comprehensive remediation plan</li>
                    @elseif($riskSeverity === 'high')
                        <li>Contact the teacher to discuss support strategies</li>
                        <li>Increase supervision of homework completion</li>
                        <li>Explore tutoring options</li>
                        <li>Review and improve study schedule</li>
                    @else
                        <li>Maintain regular communication with the teacher</li>
                        <li>Review homework assignments regularly</li>
                        <li>Encourage consistent study habits</li>
                        <li>Monitor progress closely</li>
                    @endif
                </ul>
            </div>

            <!-- Call to Action -->
            <div style="text-align: center; margin: 25px 0;">
                <p style="margin-bottom: 15px;">
                    We encourage you to contact us to discuss {{ $studentName }}'s progress and develop a support plan.
                </p>
            </div>

            <!-- Closing -->
            <p style="margin-top: 25px;">
                Thank you for your attention to this matter. Working together, we can help {{ $studentName }} succeed academically.
            </p>

            <p style="margin-top: 20px;">
                Sincerely,<br>
                <strong>{{ $subjectName }} Teacher</strong><br>
                Academic Affairs Office
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>This is an automated academic alert</strong></p>
            <p>Sent on {{ now()->format('F d, Y \a\t h:i A') }}</p>
            <p style="font-size: 12px; color: #9ca3af; margin-top: 10px;">
                If you have any questions, please contact your child's teacher directly.
            </p>
        </div>
    </div>
</body>
</html>