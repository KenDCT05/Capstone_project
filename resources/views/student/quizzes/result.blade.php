<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One:wght@400&family=Nunito:wght@400;600;700;800&display=swap');
        
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #ff6b6b, #ffd93d, #6bcf7f, #4ecdc4);
            background-size: 400% 400%;
            animation: rainbowBackground 8s ease infinite;
            min-height: 100vh;
        }

        @keyframes rainbowBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .results-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
        }

        /* Floating decorative elements */
        .floating-emoji {
            position: absolute;
            font-size: 3rem;
            animation: float 6s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-25px) rotate(10deg); }
        }

        .emoji-1 { top: 5%; left: 5%; animation-delay: 0s; }
        .emoji-2 { top: 10%; right: 5%; animation-delay: -1s; }
        .emoji-3 { bottom: 15%; left: 8%; animation-delay: -2s; }
        .emoji-4 { bottom: 5%; right: 8%; animation-delay: -3s; }
        .emoji-5 { top: 30%; left: 2%; animation-delay: -4s; }

        /* Header Section */
        .results-header {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 30px;
            box-shadow: 
                0 20px 40px rgba(220, 38, 38, 0.3),
                0 10px 20px rgba(0, 0, 0, 0.1);
            border: 6px solid #dc2626;
            overflow: hidden;
            margin-bottom: 40px;
            position: relative;
            animation: slideInDown 1s ease-out;
        }

        @keyframes slideInDown {
            from { transform: translateY(-100px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .results-hero {
            background: linear-gradient(135deg, #dc2626, #ef4444, #f97316);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .results-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><radialGradient id="a"><stop offset="20%" stop-color="%23fff" stop-opacity="0.1"/><stop offset="100%" stop-color="%23fff" stop-opacity="0"/></radialGradient></defs><circle fill="url(%23a)" cx="10" cy="10" r="10"/><circle fill="url(%23a)" cx="50" cy="5" r="8"/><circle fill="url(%23a)" cx="90" cy="15" r="6"/></svg>') repeat;
            animation: sparkle 4s linear infinite;
        }

        @keyframes sparkle {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100px); }
        }

        .quiz-title {
            font-family: 'Fredoka One', cursive;
            font-size: 3rem;
            margin-bottom: 15px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-15px); }
            60% { transform: translateY(-8px); }
        }

        .quiz-subtitle {
            font-size: 1.5rem;
            opacity: 0.9;
            font-weight: 600;
        }

        .score-circle {
            width: 150px;
            height: 150px;
            background: rgba(255,255,255,0.2);
            border: 6px solid rgba(255,255,255,0.5);
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 20px auto 0;
            backdrop-filter: blur(10px);
            animation: pulse 3s infinite;
            position: relative;
        }

        @keyframes pulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255,255,255,0.4); }
            50% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(255,255,255,0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255,255,255,0); }
        }

        .score-percentage {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1;
        }

        .score-label {
            font-size: 1rem;
            font-weight: 600;
            opacity: 0.9;
        }

        /* Score Summary Cards */
        .score-summary {
            padding: 40px 30px;
            background: rgba(255,255,255,0.95);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            padding: 25px;
            border-radius: 20px;
            text-align: center;
            border: 4px solid;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
            transition: left 0.8s ease;
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-card:hover {
            transform: translateY(-8px) scale(1.03);
        }

        .stat-card.points { border-color: #16a34a; }
        .stat-card.total { border-color: #2563eb; }
        .stat-card.correct { border-color: #dc2626; }
        .stat-card.grade { border-color: #7c3aed; }

        .stat-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            display: block;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 8px;
            font-family: 'Fredoka One', cursive;
        }

        .stat-label {
            font-size: 1.1rem;
            font-weight: 600;
            opacity: 0.8;
        }

        .points .stat-value { color: #16a34a; }
        .total .stat-value { color: #2563eb; }
        .correct .stat-value { color: #dc2626; }
        .grade .stat-value { color: #7c3aed; }

        /* Performance Status */
        .performance-status {
            text-align: center;
            margin: 40px 0;
            animation: slideInUp 1s ease-out 0.5s both;
        }

        @keyframes slideInUp {
            from { transform: translateY(50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 20px 40px;
            border-radius: 50px;
            font-size: 1.8rem;
            font-weight: 700;
            font-family: 'Fredoka One', cursive;
            border: 4px solid;
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            position: relative;
            overflow: hidden;
        }

        .status-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .status-passed {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border-color: #15803d;
            animation: celebration 2s ease-in-out infinite;
        }

        .status-failed {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            border-color: #b91c1c;
        }

        @keyframes celebration {
            0%, 100% { transform: scale(1) rotate(0deg); }
            25% { transform: scale(1.05) rotate(2deg); }
            75% { transform: scale(1.05) rotate(-2deg); }
        }

        .status-icon {
            font-size: 2.5rem;
            margin-right: 15px;
        }

        /* Question Review Section */
        .question-review {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 30px;
            box-shadow: 
                0 20px 40px rgba(220, 38, 38, 0.2),
                0 10px 20px rgba(0, 0, 0, 0.1);
            border: 6px solid #dc2626;
            overflow: hidden;
            margin-bottom: 40px;
            animation: slideInLeft 1s ease-out 0.8s both;
        }

        @keyframes slideInLeft {
            from { transform: translateX(-100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .review-header {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            padding: 30px;
            color: white;
            text-align: center;
        }

        .review-title {
            font-family: 'Fredoka One', cursive;
            font-size: 2.5rem;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .review-subtitle {
            font-size: 1.3rem;
            opacity: 0.9;
            font-weight: 600;
        }

        /* Individual Question Cards */
        .question-item {
            padding: 35px;
            border-bottom: 3px dashed #dc2626;
            position: relative;
            background: rgba(255,255,255,0.8);
        }

        .question-item:last-child {
            border-bottom: none;
        }

        .question-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .question-badges {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .question-number {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 8px 15px rgba(220, 38, 38, 0.3);
        }

        .result-badge {
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }

        .result-badge.correct {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
        }

        .result-badge.incorrect {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: white;
        }

        .points-display {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: white;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 8px 15px rgba(124, 58, 237, 0.3);
        }

        .question-text {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        /* Answer Options */
        .options-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-bottom: 25px;
        }

        .option-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-radius: 20px;
            border: 3px solid;
            font-size: 1.2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .option-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s ease;
        }

        .option-item:hover::before {
            left: 100%;
        }

        .option-correct {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            border-color: #16a34a;
            color: #15803d;
        }

        .option-incorrect {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            border-color: #dc2626;
            color: #b91c1c;
        }

        .option-neutral {
            background: linear-gradient(135deg, #f9fafb, #f3f4f6);
            border-color: #d1d5db;
            color: #374151;
        }

        .option-icon {
            font-size: 1.8rem;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .option-label {
            margin-left: auto;
            font-size: 1rem;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 15px;
            background: rgba(255,255,255,0.8);
        }

        /* Explanation Box */
        .explanation {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border: 3px solid #3b82f6;
            border-radius: 20px;
            padding: 25px;
            margin-top: 25px;
        }

        .explanation-title {
            font-weight: 700;
            font-size: 1.3rem;
            color: #1e40af;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .explanation-text {
            color: #1e40af;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Action Buttons */
        .actions-section {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 30px;
            box-shadow: 
                0 20px 40px rgba(220, 38, 38, 0.2),
                0 10px 20px rgba(0, 0, 0, 0.1);
            border: 6px solid #dc2626;
            padding: 40px;
            text-align: center;
            animation: slideInRight 1s ease-out 1s both;
        }

        @keyframes slideInRight {
            from { transform: translateX(100px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .actions-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .action-btn {
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            padding: 18px 35px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
            border: 3px solid transparent;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: all 0.4s ease;
            transform: translate(-50%, -50%);
        }

        .action-btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .action-btn:hover {
            transform: translateY(-5px) scale(1.05);
        }

        .btn-back {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: white;
            border-color: #1d4ed8;
        }

        .btn-retake {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border-color: #15803d;
            animation: wiggle 4s infinite;
        }

        @keyframes wiggle {
            0%, 7% { transform: rotateZ(0); }
            15% { transform: rotateZ(-15deg); }
            20% { transform: rotateZ(10deg); }
            25% { transform: rotateZ(-10deg); }
            30% { transform: rotateZ(6deg); }
            35% { transform: rotateZ(-4deg); }
            40%, 100% { transform: rotateZ(0); }
        }

        .btn-print {
            background: linear-gradient(135deg, #6b7280, #9ca3af);
            color: white;
            border-color: #4b5563;
        }

        .btn-share {
            background: linear-gradient(135deg, #7c3aed, #a855f7);
            color: white;
            border-color: #6d28d9;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .quiz-title { font-size: 2.5rem; }
            .score-circle { width: 120px; height: 120px; }
            .score-percentage { font-size: 2.5rem; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .stat-icon { font-size: 3rem; }
            .stat-value { font-size: 2rem; }
            .status-badge { font-size: 1.4rem; padding: 15px 30px; }
            .question-header { flex-direction: column; text-align: center; }
        }

        @media print {
            .no-print, .floating-emoji { display: none !important; }
            body { background: white !important; }
            .results-hero { background: #dc2626 !important; }
            * { box-shadow: none !important; animation: none !important; }
        }
    </style>

    <div class="results-container">
        <!-- Floating decorative emojis -->
        <div class="floating-emoji emoji-1">🎉</div>
        <div class="floating-emoji emoji-2">⭐</div>
        <div class="floating-emoji emoji-3">🏆</div>
        <div class="floating-emoji emoji-4">🎯</div>
        <div class="floating-emoji emoji-5">🚀</div>

        <!-- Header Section -->
        <div class="results-header">
            <div class="results-hero">
                <h1 class="quiz-title">🎊 Quiz Results! 🎊</h1>
                <p class="quiz-subtitle">{{ $quiz->title }}</p>
                <div class="score-circle">
                    <div class="score-percentage">{{ $attempt->percentage }}%</div>
                    <div class="score-label">Your Score</div>
                </div>
            </div>

            <!-- Score Summary -->
            <div class="score-summary">
                <div class="stats-grid">
                    <div class="stat-card points">
                        <span class="stat-icon">🌟</span>
                        <div class="stat-value">{{ $attempt->score ?? $attempt->answers()->sum('awarded_points') }}</div>
                        <div class="stat-label">Points Earned</div>
                    </div>
                    <div class="stat-card total">
                        <span class="stat-icon">💎</span>
                        <div class="stat-value">{{ $attempt->max_score }}</div>
                        <div class="stat-label">Total Points</div>
                    </div>
                    <div class="stat-card correct">
                        <span class="stat-icon">✅</span>
                        <div class="stat-value">{{ $attempt->getCorrectAnswersCount() }}/{{ $attempt->getTotalQuestionsCount() }}</div>
                        <div class="stat-label">Correct Answers</div>
                    </div>
                    <div class="stat-card grade">
                        <span class="stat-icon">🎯</span>
                        <div class="stat-value">{{ $attempt->getGrade() }}</div>
                        <div class="stat-label">Grade</div>
                    </div>
                </div>

                <!-- Performance Status -->
                <div class="performance-status">
                    @if($attempt->isPassed())
                        <div class="status-badge status-passed">
                            <span class="status-icon">🎉</span>
                            <span>Awesome! You Passed!</span>
                        </div>
                    @else
                        <div class="status-badge status-failed">
                            <span class="status-icon">💪</span>
                            <span>Keep Trying! You Can Do It!</span>
                        </div>
                    @endif
                </div>

                <!-- Quiz Details -->
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; font-size: 1.1rem; color: #4b5563; font-weight: 600;">
                    <div><strong>🕐 Started:</strong> {{ $attempt->started_at->format('M j, Y \a\t g:i A') }}</div>
                    <div><strong>✅ Completed:</strong> {{ $attempt->submitted_at->format('M j, Y \a\t g:i A') }}</div>
                    <div><strong>⏱️ Duration:</strong> {{ $attempt->duration ? $attempt->duration . ' minutes' : 'N/A' }}</div>
                    <div><strong>❓ Questions:</strong> {{ $attempt->getTotalQuestionsCount() }}</div>
                </div>
            </div>
        </div>

        <!-- Detailed Question Review -->
        <div class="question-review">
            {{-- Add this debug section to your results.blade.php --}}

            <div class="review-header">
                <h2 class="review-title">📝 Question Review</h2>
                <p class="review-subtitle">Let's see how you did on each question!</p>
            </div>

            <div>
                @foreach($attempt->answers as $index => $answer)
                    <div class="question-item">
                        <div class="question-header">
                            <div class="question-badges">
                                <span class="question-number">
                                    Question {{ $index + 1 }}
                                </span>
                                @if($answer->is_correct)
                                    <span class="result-badge correct">
                                        <span>✅</span>
                                        <span>Correct!</span>
                                    </span>
                                @else
                                    <span class="result-badge incorrect">
                                        <span>❌</span>
                                        <span>Oops!</span>
                                    </span>
                                @endif
                            </div>
                            <div class="points-display">
                                🏆 {{ $answer->awarded_points }}/{{ $answer->question->points }} pts
                            </div>
                        </div>

                        <h3 class="question-text">{{ $answer->question->question_text }}</h3>

                        <!-- Answer Options -->
                        <div class="options-list">
                            @foreach($answer->question->options as $option)
                                @php
                                    $isUserAnswer = $option->id == $answer->option_id;
                                    $isCorrectAnswer = $option->is_correct;
                                    $userGotItRight = $isUserAnswer && $answer->is_correct;
                                    $userGotItWrong = $isUserAnswer && !$answer->is_correct;
                                    
                                    if ($userGotItRight || ($isCorrectAnswer && !$isUserAnswer)) {
                                        $optionClass = 'option-correct';
                                    } elseif ($userGotItWrong) {
                                        $optionClass = 'option-incorrect';
                                    } else {
                                        $optionClass = 'option-neutral';
                                    }
                                @endphp
                                <div class="option-item {{ $optionClass }}">
                                    <div class="option-icon">
                                        @if($option->id == $answer->option_id)
                                            <!-- User's selected answer -->
                                            @if($answer->is_correct)
                                                ✅
                                            @else
                                                ❌
                                            @endif
                                        @elseif($option->is_correct)
                                            <!-- Correct answer -->
                                            ⭐
                                        @else
                                            <!-- Other options -->
                                            ⚪
                                        @endif
                                    </div>
                                    
                                    <span style="flex: 1;">
                                        {{ $option->option_text }}
                                    </span>

                                    @if($isUserAnswer)
                                        <span class="option-label" style="color: {{ $userGotItRight ? '#15803d' : '#b91c1c' }};">
                                            Your Answer
                                        </span>
                                    @elseif($isCorrectAnswer && !$answer->is_correct)
                                        <span class="option-label" style="color: #15803d;">Correct Answer</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Explanation if available -->
                        @if(isset($answer->question->explanation) && $answer->question->explanation)
                            <div class="explanation">
                                <h4 class="explanation-title">
                                    <span>💡</span>
                                    <span>Explanation:</span>
                                </h4>
                                <p class="explanation-text">{{ $answer->question->explanation }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="actions-section no-print">
            <div class="actions-grid">
                <a href="{{ route('student.quizzes.index') }}" class="action-btn btn-back">
                    <span>🔙</span>
                    <span>Back to Quizzes</span>
                </a>
                
                <button onclick="window.print()" class="action-btn btn-print">
                    <span>🖨️</span>
                    <span>Print Results</span>
                </button>
                
            </div>
        </div>
    </div>

    <script>
        function shareResults() {
            if (navigator.share) {
                navigator.share({
                    title: 'Quiz Results - {{ $quiz->title }}',
                    text: 'I scored {{ $attempt->percentage }}% on {{ $quiz->title }}! 🎉',
                    url: window.location.href
                });
            } else {
                // Fallback - copy to clipboard
                const text = `I scored {{ $attempt->percentage }}% on {{ $quiz->title }}! 🎉 ${window.location.href}`;
                navigator.clipboard.writeText(text).then(() => {
                    // Create a fun notification
                    const notification = document.createElement('div');
                    notification.innerHTML = '📋 Results copied to clipboard! 🎉';
                    notification.style.cssText = `
                        position: fixed;
                        top: 20px;
                        right: 20px;
                        background: linear-gradient(135deg, #16a34a, #22c55e);
                        color: white;
                        padding: 15px 25px;
                        border-radius: 25px;
                        font-weight: 600;
                        font-size: 1.1rem;
                        box-shadow: 0 10px 25px rgba(22, 163, 74, 0.4);
                        z-index: 1000;
                        animation: slideInRight 0.5s ease-out;
                    `;
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.style.animation = 'slideOutRight 0.5s ease-in';
                        setTimeout(() => notification.remove(), 500);
                    }, 3000);
                }).catch(() => {
                    alert('🎯 Results ready to share! 🎉');
                });
            }
        }

        // Add celebration animations for passing grades
        @if($attempt->isPassed())
        document.addEventListener('DOMContentLoaded', function() {
            // Create multiple celebration emojis
            const celebrationEmojis = ['🎉', '🎊', '⭐', '🏆', '🌟', '✨', '🎯', '🚀'];
            
            // Function to create floating celebration emoji
            function createCelebrationEmoji() {
                const emoji = document.createElement('div');
                emoji.innerHTML = celebrationEmojis[Math.floor(Math.random() * celebrationEmojis.length)];
                emoji.style.cssText = `
                    position: fixed;
                    font-size: 2rem;
                    z-index: 1000;
                    pointer-events: none;
                    left: ${Math.random() * 100}%;
                    top: 100%;
                    animation: celebrationFloat 3s ease-out forwards;
                `;
                document.body.appendChild(emoji);
                
                setTimeout(() => emoji.remove(), 3000);
            }
            
            // Create celebration animation keyframes
            if (!document.getElementById('celebrationStyles')) {
                const style = document.createElement('style');
                style.id = 'celebrationStyles';
                style.textContent = `
                    @keyframes celebrationFloat {
                        0% {
                            transform: translateY(0) rotate(0deg);
                            opacity: 1;
                        }
                        100% {
                            transform: translateY(-100vh) rotate(360deg);
                            opacity: 0;
                        }
                    }
                    @keyframes slideInRight {
                        from { transform: translateX(100%); }
                        to { transform: translateX(0); }
                    }
                    @keyframes slideOutRight {
                        from { transform: translateX(0); }
                        to { transform: translateX(100%); }
                    }
                `;
                document.head.appendChild(style);
            }
            
            // Start celebration after page loads
            setTimeout(() => {
                // Create multiple celebration emojis
                for (let i = 0; i < 15; i++) {
                    setTimeout(() => createCelebrationEmoji(), i * 200);
                }
                
                // Add success sound simulation (visual feedback)
                const successMessage = document.createElement('div');
                successMessage.innerHTML = '🎊 CONGRATULATIONS! YOU PASSED! 🎊';
                successMessage.style.cssText = `
                    position: fixed;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background: linear-gradient(135deg, #16a34a, #22c55e);
                    color: white;
                    padding: 25px 40px;
                    border-radius: 25px;
                    font-family: 'Fredoka One', cursive;
                    font-size: 1.8rem;
                    font-weight: 700;
                    box-shadow: 0 20px 40px rgba(22, 163, 74, 0.4);
                    z-index: 1001;
                    animation: successPulse 0.6s ease-out;
                    border: 4px solid #ffffff;
                `;
                document.body.appendChild(successMessage);
                
                // Add success pulse animation
                const successStyle = document.createElement('style');
                successStyle.textContent = `
                    @keyframes successPulse {
                        0% { transform: translate(-50%, -50%) scale(0.5); opacity: 0; }
                        50% { transform: translate(-50%, -50%) scale(1.1); }
                        100% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
                    }
                `;
                document.head.appendChild(successStyle);
                
                setTimeout(() => {
                    successMessage.style.animation = 'successPulse 0.6s ease-out reverse';
                    setTimeout(() => successMessage.remove(), 600);
                }, 2000);
                
            }, 1000);
        });
        @endif

        // Add interactive effects when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Animate stat cards with staggered delays
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px) scale(0.8)';
                card.style.transition = 'all 0.8s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0) scale(1)';
                }, (index + 1) * 200);
            });
            
            // Animate question items with staggered delays
            const questionItems = document.querySelectorAll('.question-item');
            questionItems.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-50px)';
                item.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, 1500 + (index * 100));
            });
            
            // Add hover effects for action buttons
            const actionBtns = document.querySelectorAll('.action-btn');
            actionBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('div');
                    ripple.style.cssText = `
                        position: absolute;
                        border-radius: 50%;
                        background: rgba(255,255,255,0.6);
                        width: 100px;
                        height: 100px;
                        left: ${e.offsetX - 50}px;
                        top: ${e.offsetY - 50}px;
                        animation: rippleEffect 0.6s ease-out;
                        pointer-events: none;
                    `;
                    this.appendChild(ripple);
                    
                    setTimeout(() => ripple.remove(), 600);
                });
            });
            
            // Add ripple effect animation
            if (!document.getElementById('rippleStyles')) {
                const rippleStyle = document.createElement('style');
                rippleStyle.id = 'rippleStyles';
                rippleStyle.textContent = `
                    @keyframes rippleEffect {
                        0% {
                            transform: scale(0);
                            opacity: 1;
                        }
                        100% {
                            transform: scale(2);
                            opacity: 0;
                        }
                    }
                `;
                document.head.appendChild(rippleStyle);
            }
            
            // Add fun interactions to floating emojis
            const floatingEmojis = document.querySelectorAll('.floating-emoji');
            floatingEmojis.forEach(emoji => {
                emoji.addEventListener('click', function() {
                    this.style.animation = 'none';
                    this.style.transform = 'scale(2) rotate(360deg)';
                    this.style.transition = 'all 0.5s ease';
                    
                    setTimeout(() => {
                        this.style.transform = 'scale(1) rotate(0deg)';
                        setTimeout(() => {
                            this.style.animation = 'float 6s ease-in-out infinite';
                        }, 500);
                    }, 500);
                });
            });
        });

        // Add some fun sound effect simulation when hovering over elements
        document.addEventListener('DOMContentLoaded', function() {
            const interactiveElements = document.querySelectorAll('.stat-card, .action-btn, .question-item');
            
            interactiveElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    // Visual feedback for "sound"
                    this.style.filter = 'brightness(1.1)';
                });
                
                element.addEventListener('mouseleave', function() {
                    this.style.filter = 'brightness(1)';
                });
            });
        });
    </script>
</x-app-layout>