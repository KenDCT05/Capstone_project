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
        .fib-answer-section {
    margin-bottom: 25px;
}

.student-answer-box, .correct-answer-box {
    margin-bottom: 20px;
}

.answer-label {
    font-weight: 700;
    font-size: 1.2rem;
    margin-bottom: 10px;
    color: #374151;
}

.answer-display {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-radius: 15px;
    border: 3px solid;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.answer-display.correct-answer {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    border-color: #16a34a;
    color: #15803d;
}

.answer-display.incorrect-answer {
    background: linear-gradient(135deg, #fef2f2, #fecaca);
    border-color: #dc2626;
    color: #b91c1c;
}

.answer-icon {
    font-size: 1.8rem;
    margin-right: 15px;
    flex-shrink: 0;
}

.answer-text {
    flex: 1;
    font-family: 'Courier New', monospace;
}

.no-answer {
    color: #6b7280;
    font-style: italic;
}

.alternative-answers {
    margin-top: 15px;
    padding: 15px;
    background: rgba(34, 197, 94, 0.1);
    border-radius: 10px;
    border: 2px dashed #22c55e;
}

.alternative-answers h5 {
    font-weight: 600;
    color: #15803d;
    margin-bottom: 10px;
}

.alt-answer {
    display: inline-block;
    background: #dcfce7;
    color: #15803d;
    padding: 5px 12px;
    margin: 3px;
    border-radius: 15px;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    border: 1px solid #22c55e;
}

.answer-settings {
    display: flex;
    gap: 20px;
    margin-top: 15px;
    padding: 15px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 10px;
    border: 2px dashed #3b82f6;
}

.setting-info {
    color: #1e40af;
    font-size: 0.95rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .answer-settings {
        flex-direction: column;
        gap: 10px;
    }
    
    .answer-display {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .answer-icon {
        margin-right: 0;
    }
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.leaderboard-rank {
    display: flex;
    align-items: center;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 15px;
    border: 3px solid;
    background: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
}

.leaderboard-rank:hover {
    transform: translateX(8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.leaderboard-rank.is-current {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border-color: #3b82f6;
}

.rank-medal {
    font-size: 2.5rem;
    margin-right: 20px;
    flex-shrink: 0;
    min-width: 50px;
    text-align: center;
}

.rank-info {
    flex: 1;
}

.rank-name {
    font-weight: 700;
    font-size: 1.1rem;
    color: #1f2937;
}

.rank-score {
    font-size: 0.9rem;
    color: #6b7280;
    margin-top: 3px;
}

.rank-stats {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-left: auto;
}

.rank-percentage {
    text-align: center;
}

.rank-percentage-value {
    font-size: 1.5rem;
    font-weight: 800;
    color: #dc2626;
    font-family: 'Fredoka One', cursive;
}

.rank-percentage-label {
    font-size: 0.8rem;
    color: #6b7280;
    font-weight: 600;
}

.current-badge {
    display: inline-block;
    background: #3b82f6;
    color: white;
    padding: 5px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 15px;
}

.leaderboard-empty {
    text-align: center;
    padding: 40px;
    color: #6b7280;
}

.leaderboard-empty-icon {
    font-size: 3rem;
    margin-bottom: 15px;
}

@media (max-width: 768px) {
    .leaderboard-rank {
        padding: 15px;
        flex-wrap: wrap;
    }

    .rank-stats {
        width: 100%;
        margin-left: 0;
        margin-top: 15px;
        justify-content: space-between;
    }

    .rank-medal {
        margin-right: 15px;
    }
}
.btn-retake {
    background: linear-gradient(135deg, #16a34a, #22c55e);
    color: white;
    border-color: #15803d;
    animation: wiggle 4s infinite;
    position: relative;
    overflow: hidden;
}

.btn-retake::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-retake:hover::after {
    width: 300px;
    height: 300px;
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

/* Pulse animation for retake button */
@keyframes retakePulse {
    0% {
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.3);
    }
    50% {
        box-shadow: 0 15px 30px rgba(22, 163, 74, 0.5), 0 0 0 10px rgba(22, 163, 74, 0.1);
    }
    100% {
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.3);
    }
}

.btn-retake:hover {
    animation: wiggle 4s infinite, retakePulse 2s infinite;
}

/* Disabled button styles */
.action-btn:disabled {
    cursor: not-allowed;
    transform: none !important;
}

.action-btn:disabled::before {
    display: none;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .actions-grid {
        flex-direction: column;
    }
    
    .action-btn {
        width: 100%;
    }
}
#attemptSelector {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23f97316' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 20px;
    padding-right: 45px;
    transition: all 0.3s ease;
}

#attemptSelector:hover {
    border-color: #ea580c;
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.2);
    transform: translateY(-2px);
}

#attemptSelector:focus {
    outline: none;
    border-color: #ea580c;
    box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
}

#attemptSelector option {
    padding: 15px;
    font-size: 1rem;
    background: white;
    color: #1f2937;
}

/* Responsive */
@media (max-width: 768px) {
    #attemptSelector {
        font-size: 0.95rem;
        padding: 12px 15px;
        padding-right: 40px;
    }
}
div[style*="fef3c7"]:hover,
div[style*="dcfce7"]:hover,
div[style*="e0e7ff"]:hover,
div[style*="fce7f3"]:hover {
    transform: translateY(-5px) scale(1.02);
}

/* Responsive design for mobile */
@media (max-width: 768px) {
    div[style*="grid-template-columns"] {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 15px !important;
    }
}

@media (max-width: 480px) {
    div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
}
    </style>

    <div class="results-container">
        <!-- Floating decorative emojis -->
        <div class="floating-emoji emoji-1">&#127881;</div>
        <div class="floating-emoji emoji-2">&#11021;</div>
        <div class="floating-emoji emoji-3">&#127942;</div>
        <div class="floating-emoji emoji-4">&#127919;</div>
        <div class="floating-emoji emoji-5">&#128640;</div>

        <!-- Header Section -->
        <div class="results-header">
            <div class="results-hero">
                <h1 class="quiz-title">&#127882; Quiz Results! &#127882;</h1>
                <p class="quiz-subtitle">{{ $quiz->title }}</p>
                <div class="score-circle">
                    <div class="score-percentage">{{ $attempt->percentage }}%</div>
                    <div class="score-label">Your Score</div>
                </div>
            </div>
            <!-- Score Summary -->
<div class="score-summary">
    {{-- NEW: Attempt Selector Dropdown --}}
    @if($allAttempts->count() > 1)
    <div style="margin-bottom: 30px; background: linear-gradient(145deg, #fff7ed, #ffedd5); border: 3px solid #f97316; border-radius: 20px; padding: 25px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
            <div>
                <h4 style="font-family: 'Fredoka One', cursive; color: #ea580c; font-size: 1.3rem; margin-bottom: 8px; display: flex; align-items: center; gap: 10px;">
                    <span>&#128203;</span>
                    <span>Select Attempt to View</span>
                </h4>
                <p style="color: #9a3412; font-size: 0.95rem; font-weight: 600; margin: 0;">
                    You have completed this quiz {{ $allAttempts->count() }} time{{ $allAttempts->count() > 1 ? 's' : '' }}
                </p>
            </div>
            
            <div style="flex: 1; min-width: 300px; max-width: 500px;">
                <select id="attemptSelector" 
                        onchange="window.location.href='{{ route('student.quizzes.result', $quiz) }}?attempt=' + this.value"
                        style="width: 100%; padding: 15px 20px; border: 3px solid #f97316; border-radius: 15px; font-size: 1.1rem; font-weight: 700; background: white; cursor: pointer; font-family: 'Nunito', sans-serif; color: #1f2937;">
                    @foreach($allAttempts as $index => $attemptOption)
                    <option value="{{ $attemptOption->id }}" 
                            {{ $attemptOption->id == $attempt->id ? 'selected' : '' }}>
                        Attempt #{{ $allAttempts->count() - $index }} - 
                        {{ $attemptOption->score }}/{{ $attemptOption->max_score }} 
                        ({{ round($attemptOption->percentage, 2) }}%) - 
                        {{ $attemptOption->submitted_at->format('M j, g:i A') }}
                        @if($attemptOption->id == $attempt->id) ← Currently Viewing @endif
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        {{-- Show if this is the final recorded score --}}
        @if($finalScore && $finalScore['attempt_id'] == $attempt->id)
        <div style="margin-top: 15px; padding: 12px 20px; background: rgba(34, 197, 94, 0.2); border-radius: 12px; border: 2px solid #22c55e;">
            <div style="display: flex; align-items: center; gap: 10px; color: #15803d; font-weight: 700; font-size: 1rem;">
                <span style="font-size: 1.5rem;">&#127942;</span>
                <span>This is your FINAL RECORDED SCORE ({{ $quiz->getScoringMethodLabel() }})</span>
            </div>
        </div>
        @elseif($finalScore)
        <div style="margin-top: 15px; padding: 12px 20px; background: rgba(59, 130, 246, 0.1); border-radius: 12px; border: 2px dashed #3b82f6;">
            <div style="color: #1e40af; font-weight: 600; font-size: 0.95rem;">
                ℹ️ This is NOT your final recorded score. Your final score is 
                <strong>{{ $finalScore['score'] }}/{{ $finalScore['max_score'] }} ({{ round($finalScore['percentage'], 2) }}%)</strong>
                based on {{ $quiz->getScoringMethodLabel() }}.
            </div>
        </div>
        @endif
    </div>
    @endif

            <!-- Score Summary -->
            <div class="score-summary">
                <div class="stats-grid">
                    <div class="stat-card points">
                        <span class="stat-icon">&#127775;</span>
                        <div class="stat-value">{{ $attempt->score ?? $attempt->answers()->sum('awarded_points') }}</div>
                        <div class="stat-label">Points Earned</div>
                    </div>
                    <div class="stat-card total">
                        <span class="stat-icon">&#128142;</span>
                        <div class="stat-value">{{ $attempt->max_score }}</div>
                        <div class="stat-label">Total Points</div>
                    </div>
                    <div class="stat-card correct">
                        <span class="stat-icon">&#9989;</span>
                        <div class="stat-value">{{ $attempt->getCorrectAnswersCount() }}/{{ $attempt->getTotalQuestionsCount() }}</div>
                        <div class="stat-label">Correct Answers</div>
                    </div>
                    <div class="stat-card grade">
                        <span class="stat-icon">&#127919;</span>
                        <div class="stat-value">{{ $attempt->getGrade() }}</div>
                        <div class="stat-label">Grade</div>
                    </div>
                </div>

                <!-- Performance Status -->
                <div class="performance-status">
                    @if($attempt->isPassed())
                        <div class="status-badge status-passed">
                            <span class="status-icon">&#127881;</span>
                            <span>Awesome! You Passed!</span>
                        </div>
                    @else
                        <div class="status-badge status-failed">
                            <span class="status-icon">&#128170;</span>
                            <span>Keep Trying! You Can Do It!</span>
                        </div>
                    @endif
                </div>

<!-- Quiz Details - 4 Separate Containers -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 30px;">
    <!-- Started Time Container -->
    <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 3px solid #f59e0b; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.2); transition: transform 0.3s ease;">
        <div style="font-size: 0.9rem; color: #92400e; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Started</div>
        <div style="font-size: 1.1rem; color: #78350f; font-weight: 600;">
            {{ $attempt->started_at->format('M j, Y') }}<br>
            <span style="font-size: 1rem; opacity: 0.8;">{{ $attempt->started_at->format('g:i A') }}</span>
        </div>
    </div>

    <!-- Completed Time Container -->
    <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); border: 3px solid #22c55e; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 8px 20px rgba(34, 197, 94, 0.2); transition: transform 0.3s ease;">
        <div style="font-size: 0.9rem; color: #15803d; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Completed</div>
        <div style="font-size: 1.1rem; color: #166534; font-weight: 600;">
            {{ $attempt->submitted_at->format('M j, Y') }}<br>
            <span style="font-size: 1rem; opacity: 0.8;">{{ $attempt->submitted_at->format('g:i A') }}</span>
        </div>
    </div>

    <!-- Duration Container -->
    <div style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe); border: 3px solid #6366f1; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 8px 20px rgba(99, 102, 241, 0.2); transition: transform 0.3s ease;">
        <div style="font-size: 0.9rem; color: #3730a3; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Duration</div>
        <div style="font-size: 1.3rem; color: #312e81; font-weight: 700; font-family: 'Fredoka One', cursive;">
            @if($attempt->duration)
                @if($attempt->duration < 1)
                    {{ round($attempt->duration * 60) }} seconds
                @else
                    {{ $attempt->duration }} minute{{ $attempt->duration != 1 ? 's' : '' }}
                @endif
            @else
                N/A
            @endif
        </div>
    </div>

    {{-- <!-- Total Questions Container -->
    <div style="background: linear-gradient(135deg, #fce7f3, #fbcfe8); border: 3px solid #ec4899; border-radius: 20px; padding: 20px; text-align: center; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.2); transition: transform 0.3s ease;">
        <div style="font-size: 0.9rem; color: #9f1239; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Questions</div>
        <div style="font-size: 1.3rem; color: #831843; font-weight: 700; font-family: 'Fredoka One', cursive;">
            {{ $attempt->getTotalQuestionsCount() }}
        </div>
    </div> --}}
</div>
            </div>
        </div>

        </div>
        {{--  NEW: Retake Policy Information Card --}}
        @if($quiz->max_attempts > 1 || $quiz->hasUnlimitedAttempts())
        <div style="margin-top: 30px; margin-bottom: 60px; background: linear-gradient(145deg, #f0f9ff, #e0f2fe); border: 3px solid #3b82f6; border-radius: 20px; padding: 25px; text-align: left;">
            <h4 style="font-family: 'Fredoka One', cursive; color: #1e40af; font-size: 1.3rem; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <span>&#128260;</span>
                <span>Retake Policy</span>
            </h4>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; color: #1e40af; font-size: 1rem; font-weight: 600;">
                <div>
                    <span style="opacity: 0.8;">&#128202; Max Attempts:</span> 
                    <strong>{{ $quiz->hasUnlimitedAttempts() ? 'Unlimited' : $quiz->max_attempts }}</strong>
                </div>
                
                <div>
                    <span style="opacity: 0.8;">&#9989; Attempts Used:</span> 
                    <strong>{{ $quiz->getAttemptCount(auth()->id()) }}</strong>
                </div>
                
                <div>
                    <span style="opacity: 0.8;">&#127919; Scoring Method:</span> 
                    <strong>{{ $quiz->getScoringMethodLabel() }}</strong>
                </div>
                
                @if($quiz->cooldown_minutes)
                <div>
                    <span style="opacity: 0.8;">&#9200; Cooldown:</span> 
                    <strong>{{ $quiz->cooldown_minutes }} minutes</strong>
                </div>
                @endif
            </div>
            
            {{-- Show final score if different from current attempt --}}
            @php
                $finalScore = $quiz->getFinalScore(auth()->id());
            @endphp
            
            @if($finalScore && $finalScore['scoring_method'] !== 'latest')
            <div style="margin-top: 20px; padding: 15px; background: rgba(34, 197, 94, 0.1); border-radius: 15px; border: 2px dashed #22c55e;">
                <div style="display: flex; align-items: center; gap: 10px; color: #15803d;">
                    <span style="font-size: 1.5rem;">&#127942;</span>
                    <div>
                        <strong style="font-size: 1.1rem;">Your Final Recorded Score:</strong>
                        <div style="font-size: 1.3rem; font-family: 'Fredoka One', cursive;">
                            {{ $finalScore['score'] }}/{{ $finalScore['max_score'] }} ({{ $finalScore['percentage'] }}%)
                        </div>
                        <small style="opacity: 0.8;">Based on: {{ $finalScore['scoring_method'] }} attempt</small>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif
    
        {{-- Leaderboards --}}
        <div class="question-review" style="margin-bottom: 40px; animation: slideInLeft 1s ease-out 1.1s both;">
            <div class="review-header">
                <h2 class="review-title">&#127942; Class Leaderboard</h2>
                <p class="review-subtitle">See how you rank against your classmates!</p>
            </div>

            <div style="padding: 35px; background: rgba(255,255,255,0.8);">
                <div id="leaderboard-container">
                    <!-- Loading state -->
                    <div style="text-align: center; padding: 40px;">
                        <div style="display: inline-block; animation: spin 1s linear infinite;">
                            &#8987;
                        </div>
                        <p style="margin-top: 15px; color: #6b7280; font-weight: 600;">Loading leaderboard...</p>
                    </div>
                </div>
            </div>
        </div>
<!-- Detailed Question Review -->
@if($showQuestionReview)
<div class="question-review">
    <div class="review-header">
        <h2 class="review-title">&#128221; Question Review</h2>
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
                                <span>&#9989;</span>
                                <span>Correct!</span>
                            </span>
                        @else
                            <span class="result-badge incorrect">
                                <span> &#x274C;</span>
                                <span>Oops!</span>
                            </span>
                        @endif
                    </div>
                    <div class="points-display">
                        &#127942; {{ $answer->awarded_points }}/{{ $answer->question->points }} pts
                    </div>
                </div>

                <h3 class="question-text">{{ $answer->question->question_text }}</h3>

                <!-- ✅ ACTUAL ANSWER DISPLAY CODE -->
                @if($answer->question->question_type === 'fib')
                    <!-- Fill in the Blank Display -->
                    <div class="fib-answer-section">
                        <div class="student-answer-box">
                            <h4 class="answer-label">Your Answer:</h4>
                            <div class="answer-display {{ $answer->is_correct ? 'correct-answer' : 'incorrect-answer' }}">
                                <div class="answer-icon">
                                    @if($answer->is_correct)
                                        &#9989;
                                    @else
                                        &#10060;
                                    @endif
                                </div>
                                <div class="answer-text">
                                    @if($answer->text_answer)
                                        "{{ $answer->text_answer }}"
                                    @else
                                        <em class="no-answer">No answer provided</em>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if(!$answer->is_correct)
                            <!-- Show correct answer if student got it wrong -->
                            <div class="correct-answer-box">
                                <h4 class="answer-label">Correct Answer:</h4>
                                <div class="answer-display correct-answer">
                                    <div class="answer-icon">&#11021;</div>
                                    <div class="answer-text">"{{ $answer->question->correct_answer }}"</div>
                                </div>
                                
                                @if($answer->question->acceptableAnswers->count() > 0)
                                    <div class="alternative-answers">
                                        <h5>Also Acceptable:</h5>
                                        @foreach($answer->question->acceptableAnswers as $alt)
                                            <span class="alt-answer">"{{ $alt->answer_text }}"</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Answer Settings Info -->
                        <div class="answer-settings">
                            <div class="setting-info">
                                <strong>Case Sensitive:</strong> {{ $answer->question->case_sensitive ? 'Yes' : 'No' }}
                            </div>
                            <div class="setting-info">
                                <strong>Partial Match:</strong> {{ $answer->question->allow_partial_match ? 'Allowed' : 'Not Allowed' }}
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Multiple Choice / True-False Display -->
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
                                            &#9989;
                                        @else
                                            &#10060;
                                        @endif
                                    @elseif($option->is_correct)
                                        <!-- Correct answer -->
                                        &#11021;
                                    @else
                                        <!-- Other options -->
                                        &#x26AA;
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
                @endif

                <!-- Explanation if available -->
                @if(isset($answer->question->explanation) && $answer->question->explanation)
                    <div class="explanation">
                        <h4 class="explanation-title">
                            <span>&#128161;</span>
                            <span>Explanation:</span>
                        </h4>
                        <p class="explanation-text">{{ $answer->question->explanation }}</p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@else
<!-- Hidden Message -->
<div class="question-review" style="margin-bottom: 40px;">
    <div class="review-header">
        <h2 class="review-title">&#128274; Question Review Unavailable</h2>
        <p class="review-subtitle">Your teacher has disabled question review for this quiz</p>
    </div>
    
    <div style="padding: 50px 35px; text-align: center; background: rgba(255,255,255,0.8);">
        <div style="font-size: 5rem; margin-bottom: 20px;">&#128683;</div>
        <h3 style="font-family: 'Fredoka One', cursive; color: #6b7280; font-size: 1.8rem; margin-bottom: 15px;">
            Question Details Hidden
        </h3>
        <p style="color: #9ca3af; font-size: 1.1rem; font-weight: 600; max-width: 500px; margin: 0 auto; line-height: 1.6;">
            To maintain quiz integrity, your teacher has chosen not to display individual question answers. 
            Focus on your overall score and try again if retakes are allowed!
        </p>
        
        <div style="margin-top: 30px; padding: 20px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border: 3px solid #3b82f6; border-radius: 20px; max-width: 600px; margin-left: auto; margin-right: auto;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px; color: #1e40af; font-weight: 600;">
                <span style="font-size: 1.5rem;">&#128161;</span>
                <span>Tip: Review your study materials and try to improve your score on the next attempt!</span>
            </div>
        </div>
    </div>
</div>
@endif
       

        <!-- Action Buttons -->
<div class="actions-section no-print bg-white">
    <div class="actions-grid ">
        <a href="{{ route('student.quizzes.index') }}" class="action-btn btn-back">
            <span>&#128281;</span>
            <span>Back to Quizzes</span>
        </a>
        
        {{-- NEW: Retake Button with Logic --}}
        @php
            $canAttempt = $quiz->canStudentAttempt(auth()->id());
        @endphp
        
        @if($canAttempt['allowed'])
            <a href="{{ route('student.quizzes.take', $quiz) }}" class="action-btn btn-retake">
                <span>&#128260;</span>
                <span>
                    Retake Quiz
                    @if(!$quiz->hasUnlimitedAttempts())
                        ({{ $canAttempt['attempts_remaining'] }} left)
                    @endif
                </span>
            </a>
        @else
            {{-- Show disabled button with reason --}}
            <button class="action-btn" 
                    style="background: linear-gradient(135deg, #9ca3af, #6b7280); color: white; border-color: #4b5563; cursor: not-allowed; opacity: 0.6;"
                    title="{{ $canAttempt['reason'] }}"
                    disabled>
                <span>&#128274;</span>
                <span>Retake Unavailable</span>
            </button>
        <button onclick="window.print()" class="action-btn btn-print">
            <span>&#128424;</span>
            <span>Print Results</span>
        </button>
            {{-- Show reason below button --}}
            <div style="width: 100%; text-align: center; margin-top: -10px;">
                <small style="color: #dc2626; font-weight: 600; background: #fef2f2; padding: 8px 16px; border-radius: 20px; display: inline-block;">
                    {{ $canAttempt['reason'] }}
                    @if(isset($canAttempt['cooldown_end']))
                        <br>
                        <span style="color: #6b7280; font-size: 0.85rem;">
                            Available: {{ $canAttempt['cooldown_end']->format('M d, Y h:i A') }}
                        </span>
                    @endif
                </small>
            </div>
        @endif
        

    </div>
    
</div>

    </div>

    <script>
        function shareResults() {
            if (navigator.share) {
                navigator.share({
                    title: 'Quiz Results - {{ $quiz->title }}',
                    text: 'I scored {{ $attempt->percentage }}% on {{ $quiz->title }}! &#127881;',
                    url: window.location.href
                });
            } else {
                // Fallback - copy to clipboard
                const text = `I scored {{ $attempt->percentage }}% on {{ $quiz->title }}! &#127881; ${window.location.href}`;
                navigator.clipboard.writeText(text).then(() => {
                    // Create a fun notification
                    const notification = document.createElement('div');
                    notification.innerHTML = '&#128203; Results copied to clipboard! &#127881;';
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
                    alert('&#127919; Results ready to share! &#127881;');
                });
            }
        }

        // Add celebration animations for passing grades
        @if($attempt->isPassed())
        document.addEventListener('DOMContentLoaded', function() {
            // Create multiple celebration emojis
            const celebrationEmojis = ['&#127881;', '&#127882;', '&#11021;', '&#127942;', '&#127775;', '✨', '&#127919;', '&#128640;'];
            
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
                successMessage.innerHTML = '&#127882; CONGRATULATIONS! YOU PASSED! &#127882;';
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
                    document.addEventListener('DOMContentLoaded', function() {
                const quizId = '{{ $quiz->id }}';
                const studentId = {{ auth()->id() }};

                fetch(`/student/quizzes/${quizId}/leaderboard`)
                    .then(response => response.json())
                    .then(data => {
                        const container = document.getElementById('leaderboard-container');
                        
                        if (!data.attempts || data.attempts.length === 0) {
                            container.innerHTML = `
                                <div class="leaderboard-empty">
                                    <div class="leaderboard-empty-icon">&#128202;</div>
                                    <p style="font-weight: 600; margin-bottom: 10px;">No other submissions yet</p>
                                    <p style="font-size: 0.9rem;">You're the first to complete this quiz!</p>
                                </div>
                            `;
                            return;
                        }

                        let html = '';
                        data.attempts.forEach((attempt, index) => {
                            const isCurrent = attempt.student_id == studentId;
                            const medal = index === 0 ? '&#129351;' : index === 1 ? '&#129352;' : index === 2 ? '&#129353;' : (index + 1);
                            
                            const rankClass = isCurrent ? 'is-current' : '';
                            const badge = isCurrent ? '<span class="current-badge">You</span>' : '';

                            html += `
                                <div class="leaderboard-rank ${rankClass}">
                                    <div class="rank-medal">${medal}</div>
                                    <div class="rank-info">
                                        <div class="rank-name">
                                            ${attempt.student_name}
                                            ${badge}
                                        </div>
                                        <div class="rank-score">
                                            ${attempt.score}/${attempt.max_score} points
                                        </div>
                                    </div>
                                    <div class="rank-stats">
                                        <div class="rank-percentage">
                                            <div class="rank-percentage-value">${attempt.percentage}%</div>
                                            <div class="rank-percentage-label">Score</div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error loading leaderboard:', error);
                        document.getElementById('leaderboard-container').innerHTML = `
                            <div class="leaderboard-empty">
                                <div class="leaderboard-empty-icon">&#9888;</div>
                                <p style="color: #dc2626; font-weight: 600;">Error loading leaderboard</p>
                                <p style="font-size: 0.9rem;">Please try refreshing the page.</p>
                            </div>
                        `;
                    });
            });

            document.addEventListener('DOMContentLoaded', function() {
    const selector = document.getElementById('attemptSelector');
    
    if (selector) {
        // Add loading state when changing attempts
        selector.addEventListener('change', function() {
            // Create loading overlay
            const overlay = document.createElement('div');
            overlay.innerHTML = `
                <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                    <div style="background: white; padding: 30px 50px; border-radius: 20px; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
                        <div style="font-size: 3rem; animation: spin 1s linear infinite;">&#8987;</div>
                        <p style="margin-top: 15px; font-weight: 700; color: #1f2937; font-size: 1.2rem;">Loading attempt...</p>
                    </div>
                </div>
            `;
            document.body.appendChild(overlay);
        });
        
        // Highlight current selection with animation
        selector.style.animation = 'pulse 2s ease-in-out infinite';
    }
});

// Add pulse animation for dropdown
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.4); }
        50% { box-shadow: 0 0 0 8px rgba(249, 115, 22, 0); }
    }
`;
document.head.appendChild(style);
        
        document.addEventListener('DOMContentLoaded', function() {
    const detailContainers = document.querySelectorAll('[style*="fef3c7"], [style*="dcfce7"], [style*="e0e7ff"], [style*="fce7f3"]');
    
    detailContainers.forEach((container, index) => {
        container.style.opacity = '0';
        container.style.transform = 'translateY(30px)';
        container.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            container.style.opacity = '1';
            container.style.transform = 'translateY(0)';
        }, 100 + (index * 100));
    });
});
    </script>

    
</x-app-layout>