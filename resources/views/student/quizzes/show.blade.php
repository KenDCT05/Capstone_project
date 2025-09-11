{{-- resources/views/student/quizzes/show.blade.php - CHILD FRIENDLY VERSION --}}
<x-app-layout>
    <style>
        /* Child-friendly styling matching the quiz interface */
        body {
            font-family: 'Comic Sans MS', cursive, sans-serif !important;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8e8e 50%, #ffb3b3 100%) !important;
            min-height: 100vh;
        }
        
        .quiz-overview-container {
            background: linear-gradient(145deg, #ffffff, #f8f8f8);
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(255, 107, 107, 0.3);
            border: 5px solid #ff4757;
            position: relative;
            overflow: hidden;
        }
        
        .quiz-overview-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 71, 87, 0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
            z-index: 0;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        .content-wrapper {
            position: relative;
            z-index: 1;
        }
        
        .quiz-title {
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(45deg, #ff4757, #ff6b6b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 3rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
            line-height: 1.2;
        }
        
        .quiz-details {
            background: linear-gradient(135deg, #fff5f5, #ffebee);
            border: 4px solid #ff4757;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(255, 71, 87, 0.2);
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: linear-gradient(135deg, #ffffff, #ffebee);
            border: 3px solid #ff8a80;
            border-radius: 15px;
            font-size: 1.4rem;
            font-weight: bold;
            color: #d32f2f;
            transition: all 0.3s ease;
        }
        
        .detail-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 71, 87, 0.3);
            border-color: #ff4757;
        }
        
        .detail-item:last-child {
            margin-bottom: 0;
        }
        
        .detail-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #ff4757;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin-right: 20px;
            flex-shrink: 0;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .detail-content {
            flex: 1;
        }
        
        .detail-label {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 5px;
        }
        
        .detail-value {
            font-size: 1.5rem;
            color: #d32f2f;
            font-weight: bold;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 25px 50px;
            border: none;
            border-radius: 25px;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 20px;
            font-family: 'Comic Sans MS', cursive;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        .btn-start {
            background: linear-gradient(135deg, #4caf50, #81c784);
            color: white;
            animation: bounce 2s infinite;
        }
        
        @keyframes bounce {
            0%, 20%, 60%, 100% { transform: translateY(0); }
            40% { transform: translateY(-8px); }
            80% { transform: translateY(-4px); }
        }
        
        .btn-back {
            background: linear-gradient(135deg, #9e9e9e, #bdbdbd);
            color: white;
        }
        
        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
        }
        
        .btn-icon {
            font-size: 2.5rem;
        }
        
        .floating-emoji {
            position: absolute;
            font-size: 3rem;
            animation: float-around 8s ease-in-out infinite;
            pointer-events: none;
            opacity: 0.6;
        }
        
        @keyframes float-around {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(50px, -30px) rotate(90deg); }
            50% { transform: translate(-30px, -50px) rotate(180deg); }
            75% { transform: translate(-50px, 30px) rotate(270deg); }
        }
        
        .sparkle {
            position: absolute;
            width: 20px;
            height: 20px;
            background: #ffeb3b;
            clip-path: polygon(50% 0%, 60% 40%, 100% 50%, 60% 60%, 50% 100%, 40% 60%, 0% 50%, 40% 40%);
            animation: sparkle 2s linear infinite;
        }
        
        @keyframes sparkle {
            0%, 100% { transform: scale(0) rotate(0deg); opacity: 0; }
            50% { transform: scale(1) rotate(180deg); opacity: 1; }
        }
        
        .time-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeeba);
            border: 3px solid #ffc107;
            color: #856404;
        }
        
        .ready-message {
            text-align: center;
            font-size: 1.6rem;
            color: #4caf50;
            font-weight: bold;
            margin-bottom: 30px;
            padding: 20px;
            background: linear-gradient(135deg, #e8f5e8, #c8e6c9);
            border: 3px solid #4caf50;
            border-radius: 20px;
            animation: glow 2s ease-in-out infinite alternate;
        }
        
        @keyframes glow {
            from { box-shadow: 0 0 20px rgba(76, 175, 80, 0.3); }
            to { box-shadow: 0 0 30px rgba(76, 175, 80, 0.6); }
        }
    </style>
    
    <!-- Floating Emojis -->
    <div class="floating-emoji" style="top: 10%; left: 10%; animation-delay: 0s;">📚</div>
    <div class="floating-emoji" style="top: 20%; right: 15%; animation-delay: 2s;">⭐</div>
    <div class="floating-emoji" style="bottom: 30%; left: 20%; animation-delay: 4s;">🎯</div>
    <div class="floating-emoji" style="bottom: 10%; right: 10%; animation-delay: 6s;">🏆</div>
    <div class="floating-emoji" style="top: 50%; left: 5%; animation-delay: 3s;">🎊</div>
    <div class="floating-emoji" style="bottom: 50%; right: 5%; animation-delay: 5s;">✨</div>
    
    <!-- Sparkles -->
    <div class="sparkle" style="top: 15%; left: 25%; animation-delay: 0s;"></div>
    <div class="sparkle" style="top: 35%; right: 20%; animation-delay: 1s;"></div>
    <div class="sparkle" style="bottom: 25%; left: 30%; animation-delay: 2s;"></div>
    <div class="sparkle" style="bottom: 45%; right: 25%; animation-delay: 1.5s;"></div>

    <div class="max-w-4xl mx-auto p-6 quiz-overview-container">
        <div class="content-wrapper">
            <!-- Quiz Title -->
            <h1 class="quiz-title">🎊 {{ $quiz->title }} 🎊</h1>
            
            <!-- Ready Message -->
            <div class="ready-message">
                🌟 Are you ready for an awesome quiz adventure? 🌟
            </div>
            
            <!-- Quiz Details -->
            <div class="quiz-details">
                <!-- Quiz Type -->
                <div class="detail-item">
                    <div class="detail-icon">
                        @if($quiz->type === 'practice')
                            📝
                        @elseif($quiz->type === 'exam')
                            🎓
                        @else
                            📋
                        @endif
                    </div>
                    <div class="detail-content">
                        <div class="detail-label">Quiz Type</div>
                        <div class="detail-value">{{ ucfirst($quiz->type) }}</div>
                    </div>
                </div>
                
                <!-- Total Points -->
                <div class="detail-item">
                    <div class="detail-icon">🏆</div>
                    <div class="detail-content">
                        <div class="detail-label">Total Points</div>
                        <div class="detail-value">{{ $quiz->total_points }} Points</div>
                    </div>
                </div>
                
                <!-- Time Limit -->
                @if($quiz->time_limit_seconds)
                    <div class="detail-item {{ $quiz->time_limit_seconds < 1800 ? 'time-warning' : '' }}">
                        <div class="detail-icon">
                            {{ $quiz->time_limit_seconds < 1800 ? '⚠️' : '⏰' }}
                        </div>
                        <div class="detail-content">
                            <div class="detail-label">Time Limit</div>
                            <div class="detail-value">
                                {{ gmdate('H:i:s', $quiz->time_limit_seconds) }}
                                @if($quiz->time_limit_seconds < 1800)
                                    <span style="font-size: 1.1rem; color: #f57f17;">(Quick Quiz!)</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="detail-item">
                        <div class="detail-icon">🕐</div>
                        <div class="detail-content">
                            <div class="detail-label">Time Limit</div>
                            <div class="detail-value">No Time Limit ♾️</div>
                        </div>
                    </div>
                @endif
                
                <!-- Number of Questions -->
                <div class="detail-item">
                    <div class="detail-icon">❓</div>
                    <div class="detail-content">
                        <div class="detail-label">Questions</div>
                        <div class="detail-value">{{ $quiz->questions->count() }} Questions</div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('student.quizzes.take', $quiz) }}" class="action-btn btn-start">
                    <span class="btn-icon">🚀</span>
                    <span>Start Quiz!</span>
                </a>
                
                <a href="{{ route('student.quizzes.index') }}" class="action-btn btn-back">
                    <span class="btn-icon">⬅️</span>
                    <span>Go Back</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Fun JavaScript for extra interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add click sound to buttons
            const buttons = document.querySelectorAll('.action-btn');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    // Simple click sound using Web Audio API
                    if (typeof(AudioContext) !== "undefined" || typeof(webkitAudioContext) !== "undefined") {
                        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                        const oscillator = audioContext.createOscillator();
                        const gainNode = audioContext.createGain();
                        
                        oscillator.connect(gainNode);
                        gainNode.connect(audioContext.destination);
                        
                        oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
                        oscillator.type = 'sine';
                        
                        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                        gainNode.gain.linearRampToValueAtTime(0.1, audioContext.currentTime + 0.05);
                        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.2);
                        
                        oscillator.start(audioContext.currentTime);
                        oscillator.stop(audioContext.currentTime + 0.2);
                    }
                });
            });
            
            // Add hover effects to detail items
            const detailItems = document.querySelectorAll('.detail-item');
            detailItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Create floating particles
            function createParticle() {
                const particle = document.createElement('div');
                particle.style.position = 'absolute';
                particle.style.width = '6px';
                particle.style.height = '6px';
                particle.style.backgroundColor = '#ff4757';
                particle.style.borderRadius = '50%';
                particle.style.pointerEvents = 'none';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = '100%';
                particle.style.opacity = '0.7';
                particle.style.animation = 'float-up 4s linear infinite';
                
                document.body.appendChild(particle);
                
                setTimeout(() => {
                    particle.remove();
                }, 4000);
            }
            
            // Add CSS for particle animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes float-up {
                    0% {
                        transform: translateY(0) rotate(0deg);
                        opacity: 0.7;
                    }
                    100% {
                        transform: translateY(-100vh) rotate(360deg);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
            
            // Create particles periodically
            setInterval(createParticle, 2000);
            
            // Add extra sparkle to start button
            const startButton = document.querySelector('.btn-start');
            if (startButton) {
                setInterval(() => {
                    startButton.style.boxShadow = '0 15px 35px rgba(76, 175, 80, 0.4), 0 0 20px rgba(255, 235, 59, 0.5)';
                    setTimeout(() => {
                        startButton.style.boxShadow = '0 10px 25px rgba(0,0,0,0.15)';
                    }, 1000);
                }, 3000);
            }
        });
    </script>
</x-app-layout>