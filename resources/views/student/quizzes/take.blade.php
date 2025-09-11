<x-app-layout>
    <!-- Music Control Button -->
    <button class="music-control" id="musicToggle" onclick="toggleMusic()">
        🎵
    </button>
    
    <!-- Background Audio -->
    <audio id="backgroundMusic" loop>
        <source src="https://cdnjs.cloudflare.com/ajax/libs/ion-sound/3.0.7/sounds/bell_ring.mp3" type="audio/mpeg">
    </audio>
    
    <!-- Floating Emojis -->
    <div class="floating-emoji" style="top: 10%; left: 10%; animation-delay: 0s;">📚</div>
    <div class="floating-emoji" style="top: 20%; right: 15%; animation-delay: 2s;">⭐</div>
    <div class="floating-emoji" style="bottom: 30%; left: 20%; animation-delay: 4s;">🎯</div>
    <div class="floating-emoji" style="bottom: 10%; right: 10%; animation-delay: 6s;">🏆</div>
    
    <div class="max-w-4xl mx-auto p-6 quiz-container">
        <div class="content-wrapper">
            <!-- Fun Header -->
            <h1 class="fun-header">🎊 Quiz Time Fun! 🎊</h1>
            
            <div class="progress-container">
                <h2 style="text-align: center; font-size: 1.8rem; color: #d32f2f; margin-bottom: 15px;">
                    🌟 Question {{ $currentIndex + 1 }} of {{ $totalQuestions }} 🌟
                </h2>

                <!-- Progress bar -->
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ ($currentIndex+1)/$totalQuestions*100 }}%"></div>
                </div>

                <!-- Question Type Indicator -->
                <div style="text-align: center; margin: 15px 0;">
                    <span class="question-type-badge 
                        @if($question->question_type === 'mcq') mcq-badge
                        @elseif($question->question_type === 'tf') tf-badge  
                        @elseif($question->question_type === 'fib') fib-badge
                        @endif">
                        {{ $question->getQuestionTypeLabel() }}
                    </span>
                </div>

                <!-- Timers -->
                <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px; flex-wrap: wrap;">
                    @if($quiz->time_limit_seconds && $quiz->time_limit_seconds > 0)
                        <div class="timer-display">
                            <span style="font-size: 1.5rem;">⏰</span>
                            <span>Quiz Time: <span id="quiz-timer">--:--</span></span>
                        </div>
                    @endif

                    @if($question->time_limit_seconds && $question->time_limit_seconds > 0)
                        <div class="timer-display">
                            <span style="font-size: 1.5rem;">⏱️</span>
                            <span>Question Time: <span id="question-timer">--s</span></span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Answer Form -->
            <form id="quiz-answer-form" method="POST" action="{{ route('student.quizzes.take', $quiz) }}?q={{ $currentIndex }}">
                @csrf
                <input type="hidden" name="current_question_index" value="{{ $currentIndex }}">
                <input type="hidden" name="question_id" value="{{ $question->id }}">

                <div class="question-box">
                    <p class="question-text">
                        {{ $question->question_text ?? 'Question text not available' }}
                    </p>

                    <!-- Question Type Specific UI -->
                    @if($question->question_type === 'fib')
                        <!-- Fill in the Blank Input -->
                        <div class="fib-container">
                            <div class="fib-input-wrapper">
                                <label for="fib-answer" class="fib-label">Your Answer:</label>
                                <input type="text" 
                                       id="fib-answer"
                                       name="answers[{{ $question->id }}]" 
                                       value="{{ $existingAnswer ? $existingAnswer->text_answer : '' }}"
                                       placeholder="Type your answer here..."
                                       class="fib-input"
                                       autocomplete="off"
                                       spellcheck="false">
                                <div class="fib-hint">
                                    @if($question->case_sensitive)
                                        <span class="hint-item">⚠️ Case sensitive</span>
                                    @endif
                                    @if($question->allow_partial_match)
                                        <span class="hint-item">💡 Partial answers accepted</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Multiple Choice / True-False Options -->
                        @php
                            $optionsCount = is_object($options) ? $options->count() : count($options);
                            $optionLabels = ['A', 'B', 'C', 'D', 'E', 'F'];
                        @endphp

                        @if($optionsCount > 0)
                            <div class="options-container {{ $question->question_type === 'tf' ? 'tf-options' : 'mcq-options' }}">
                                @foreach($options as $index => $option)
                                    @php
                                        $optionId = is_object($option) ? $option->id : $option['id'];
                                        $optionText = is_object($option) ? $option->option_text : $option['option_text'];
                                        $isSelected = $existingAnswer && $existingAnswer->option_id == $optionId;
                                    @endphp
                                    <label class="option-button {{ $isSelected ? 'selected' : '' }} 
                                        {{ $question->question_type === 'tf' ? 'tf-option' : 'mcq-option' }}" 
                                        data-option-id="{{ $optionId }}">
                                        
                                        @if($question->question_type === 'tf')
                                            <!-- True/False styling -->
                                            <div class="tf-icon {{ $optionText === 'True' ? 'true-icon' : 'false-icon' }}">
                                                @if($optionText === 'True')
                                                    ✓
                                                @else
                                                    ✗
                                                @endif
                                            </div>
                                        @else
                                            <!-- Multiple Choice styling -->
                                            <div class="option-icon">{{ $optionLabels[$index] ?? ($index + 1) }}</div>
                                        @endif
                                        
                                        <span style="flex: 1;">{{ $optionText }}</span>
                                        <input type="radio"
                                               name="answers[{{ $question->id }}]"
                                               value="{{ $optionId }}"
                                               style="display: none;"
                                               {{ $isSelected ? 'checked' : '' }}>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <p style="text-align: center; color: #f44336; font-size: 1.3rem;">
                                😟 No options available for this question.
                            </p>
                        @endif
                    @endif
                </div>

                <div class="nav-buttons">
                    @if($currentIndex > 0)
                        <button type="button" onclick="goToPrevious()" class="nav-btn btn-previous">
                            <span class="btn-icon">⬅️</span>
                            <span>Previous</span>
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if($currentIndex + 1 < $totalQuestions)
                        <button type="submit" class="nav-btn btn-next">
                            <span>Next Question</span>
                            <span class="btn-icon">➡️</span>
                        </button>
                    @else
                        <button type="submit" class="nav-btn btn-submit">
                            <span>Submit Quiz</span>
                            <span class="btn-icon">🏁</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Celebration Animation Container -->
    <div class="celebration" id="celebration"></div>

    <style>
        /* Enhanced Styling for All Question Types */
        .quiz-container {
            background: linear-gradient(135deg, #fff5f5, #fef7f0);
            border-radius: 20px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            position: relative;
            overflow: hidden;
            margin-top: 20px;
        }

        .question-type-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .mcq-badge {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .tf-badge {
            background: linear-gradient(135deg, #10b981, #047857);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .fib-badge {
            background: linear-gradient(135deg, #8b5cf6, #5b21b6);
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
        }

        /* Fill in the Blank Styles */
        .fib-container {
            margin: 30px 0;
        }

        .fib-input-wrapper {
            background: linear-gradient(135deg, #f3e8ff, #ede9fe);
            border: 3px solid #8b5cf6;
            border-radius: 20px;
            padding: 25px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .fib-input-wrapper::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(139, 92, 246, 0.1), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .fib-label {
            display: block;
            font-size: 1.2rem;
            font-weight: 700;
            color: #5b21b6;
            margin-bottom: 15px;
            position: relative;
            z-index: 1;
        }

        .fib-input {
            width: 100%;
            max-width: 400px;
            padding: 15px 20px;
            font-size: 1.3rem;
            border: 2px solid #d1d5db;
            border-radius: 12px;
            background: white;
            text-align: center;
            font-weight: 500;
            color: #374151;
            position: relative;
            z-index: 1;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .fib-input:focus {
            outline: none;
            border-color: #8b5cf6;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1), 0 4px 12px rgba(139, 92, 246, 0.15);
            transform: translateY(-2px);
        }

        .fib-hint {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .hint-item {
            background: rgba(139, 92, 246, 0.1);
            color: #5b21b6;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 500;
            border: 1px solid rgba(139, 92, 246, 0.2);
        }

        /* Enhanced True/False Options */
        .tf-options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 30px 0;
        }

        .tf-option {
            background: linear-gradient(135deg, #ffffff, #f9fafb);
            border: 3px solid #e5e7eb;
            border-radius: 20px;
            padding: 25px;
            cursor: pointer;
            transition: all 0.4s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            font-size: 1.4rem;
            font-weight: 700;
            text-align: center;
            position: relative;
            overflow: hidden;
            min-height: 120px;
        }

        .tf-option:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .tf-option.selected {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .tf-option:first-child {
            border-color: #10b981;
            color: #047857;
        }

        .tf-option:first-child:hover,
        .tf-option:first-child.selected {
            background: linear-gradient(135deg, #dcfdf7, #a7f3d0);
            border-color: #059669;
        }

        .tf-option:last-child {
            border-color: #ef4444;
            color: #dc2626;
        }

        .tf-option:last-child:hover,
        .tf-option:last-child.selected {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            border-color: #dc2626;
        }

        .tf-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 900;
        }

        .true-icon {
            background: linear-gradient(135deg, #10b981, #047857);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .false-icon {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* Enhanced MCQ Options */
        .mcq-options {
            margin: 30px 0;
        }

        .mcq-option {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border: 3px solid #e2e8f0;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
        }

        .mcq-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
            border-color: #3b82f6;
        }

        .mcq-option.selected {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-color: #3b82f6;
            color: #1d4ed8;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.25);
        }

        .option-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .mcq-option.selected .option-icon {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        /* Common Styles */
        .fun-header {
            text-align: center;
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4, #45b7d1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 25px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }

        .progress-bar {
            width: 100%;
            height: 12px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
            margin: 20px 0;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(135deg, #10b981, #059669);
            border-radius: 10px;
            transition: width 0.5s ease;
            position: relative;
        }

        .question-box {
            background: linear-gradient(135deg, #ffffff, #f9fafb);
            border: 3px solid #e5e7eb;
            border-radius: 20px;
            padding: 30px;
            margin: 30px 0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .question-text {
            font-size: 1.4rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 25px;
            line-height: 1.6;
            text-align: center;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-top: 40px;
        }

        .nav-btn {
            padding: 15px 30px;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-previous {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        .btn-next {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .btn-submit {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .nav-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .timer-display {
            background: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            border-radius: 20px;
            font-weight: 600;
            color: #374151;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Floating elements */
        .floating-emoji {
            position: fixed;
            font-size: 2rem;
            opacity: 0.6;
            animation: float 6s ease-in-out infinite;
            z-index: 1;
            pointer-events: none;
        }

        .music-control {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .music-control:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes confetti-fall {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(500px) rotate(360deg);
                opacity: 0;
            }
        }

        .celebration {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #ff6b6b;
            animation: confetti-fall 3s linear infinite;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .tf-options {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .nav-buttons {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-btn {
                width: 100%;
                justify-content: center;
            }
            
            .fib-input {
                font-size: 1.1rem;
                padding: 12px 16px;
            }
        }
    </style>

    <!-- Scripts -->
    <script>
        // Get state from controller
        const musicFromController = {{ isset($musicState) && $musicState === '1' ? 'true' : 'false' }};
        const startTimeFromController = {{ isset($startTime) && $startTime ? $startTime : 'null' }};
        
        function getUrlParameter(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }
        
        const musicFromUrl = getUrlParameter('music') === '1';
        const quizStartTimeFromUrl = getUrlParameter('start_time');
        
        window.quizState = window.quizState || {
            musicPlaying: musicFromController || musicFromUrl,
            quizTimeRemaining: {{ $quiz->time_limit_seconds && $quiz->time_limit_seconds > 0 ? $quiz->time_limit_seconds : 'null' }},
            quizStartTime: startTimeFromController || (quizStartTimeFromUrl ? parseInt(quizStartTimeFromUrl) : null)
        };

        let audioContext;
        let musicPlaying = window.quizState.musicPlaying;
        let musicInterval;
        
        function initAudio() {
            if (!audioContext) {
                audioContext = new (window.AudioContext || window.webkitAudioContext)();
            }
        }
        
        function createHappyTune() {
            if (!audioContext) initAudio();
            
            const notes = [261.63, 293.66, 329.63, 349.23, 392.00];
            let noteIndex = 0;
            
            function playNote() {
                if (!musicPlaying) return;
                
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.setValueAtTime(notes[noteIndex], audioContext.currentTime);
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0, audioContext.currentTime);
                gainNode.gain.linearRampToValueAtTime(0.1, audioContext.currentTime + 0.1);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.5);
                
                noteIndex = (noteIndex + 1) % notes.length;
                
                if (musicPlaying) {
                    musicInterval = setTimeout(playNote, 600);
                }
            }
            
            if (musicInterval) {
                clearTimeout(musicInterval);
            }
            
            playNote();
        }
        
        function toggleMusic() {
            const button = document.getElementById('musicToggle');
            
            if (musicPlaying) {
                musicPlaying = false;
                window.quizState.musicPlaying = false;
                button.textContent = '🔇';
                button.style.animation = 'none';
                if (musicInterval) {
                    clearTimeout(musicInterval);
                }
            } else {
                initAudio();
                musicPlaying = true;
                window.quizState.musicPlaying = true;
                button.textContent = '🎵';
                button.style.animation = 'pulse 2s infinite';
                createHappyTune();
            }
        }
        
        function initializeMusicState() {
            const button = document.getElementById('musicToggle');
            if (window.quizState.musicPlaying) {
                musicPlaying = true;
                button.textContent = '🎵';
                button.style.animation = 'pulse 2s infinite';
                setTimeout(() => {
                    initAudio();
                    createHappyTune();
                }, 100);
            } else {
                button.textContent = '🔇';
                button.style.animation = 'none';
            }
        }
        
        // Option Selection with Animation (for MCQ/TF)
        document.querySelectorAll('.option-button').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.option-button').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                this.classList.add('selected');
                
                const radio = this.querySelector('input[type="radio"]');
                if (radio) {
                    radio.checked = true;
                }
                
                playSelectionSound();
                createMiniCelebration(this);
            });
        });

        // Fill in the Blank input handling
        const fibInput = document.getElementById('fib-answer');
        if (fibInput) {
            fibInput.addEventListener('input', function() {
                // Visual feedback for typing
                if (this.value.trim()) {
                    this.style.borderColor = '#8b5cf6';
                    this.style.boxShadow = '0 0 0 3px rgba(139, 92, 246, 0.1)';
                } else {
                    this.style.borderColor = '#d1d5db';
                    this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1)';
                }
            });

            fibInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('quiz-answer-form').submit();
                }
            });
        }
        
        function playSelectionSound() {
            if (!audioContext) initAudio();
            
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.setValueAtTime(523.25, audioContext.currentTime);
            oscillator.type = 'sine';
            
            gainNode.gain.setValueAtTime(0, audioContext.currentTime);
            gainNode.gain.linearRampToValueAtTime(0.2, audioContext.currentTime + 0.05);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
            
            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.3);
        }
        
        function createMiniCelebration(element) {
            const rect = element.getBoundingClientRect();
            const colors = ['#ff4757', '#ff6b6b', '#ff8a80', '#ffc1cc'];
            
            for (let i = 0; i < 5; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.style.position = 'fixed';
                    confetti.style.left = (rect.left + rect.width/2 + (Math.random() - 0.5) * 100) + 'px';
                    confetti.style.top = (rect.top + rect.height/2) + 'px';
                    confetti.style.width = '8px';
                    confetti.style.height = '8px';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.borderRadius = '50%';
                    confetti.style.pointerEvents = 'none';
                    confetti.style.zIndex = '10000';
                    confetti.style.animation = 'confetti-fall 1s linear forwards';
                    
                    document.body.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 1000);
                }, i * 100);
            }
        }
        
        let isSubmitting = false;

        function goToPrevious() {
            if (isSubmitting) return;
            
            const currentIndex = {{ $currentIndex }};
            const prevIndex = currentIndex - 1;
            if (prevIndex >= 0) {
                const params = new URLSearchParams();
                params.set('q', prevIndex);
                if (musicPlaying) params.set('music', '1');
                if (window.quizState.quizStartTime) params.set('start_time', window.quizState.quizStartTime);
                
                window.location.href = "{{ route('student.quizzes.take', $quiz) }}?" + params.toString();
            }
        }

        document.getElementById('quiz-answer-form').addEventListener('submit', function(e) {
            if (isSubmitting) {
                e.preventDefault();
                return;
            }
            
            // Check if an answer is provided based on question type
            const questionType = '{{ $question->question_type }}';
            let hasAnswer = false;
            
            if (questionType === 'fib') {
                const fibInput = document.getElementById('fib-answer');
                hasAnswer = fibInput && fibInput.value.trim() !== '';
            } else {
                const selectedAnswer = document.querySelector('input[name^="answers["]:checked');
                hasAnswer = selectedAnswer !== null;
            }
            
            if (!hasAnswer) {
                alert('Please provide an answer before proceeding!');
                e.preventDefault();
                return;
            }
            
            // Add hidden inputs for state persistence
            const musicInput = document.createElement('input');
            musicInput.type = 'hidden';
            musicInput.name = 'music';
            musicInput.value = musicPlaying ? '1' : '0';
            this.appendChild(musicInput);
            
            const startTimeInput = document.createElement('input');
            startTimeInput.type = 'hidden';
            startTimeInput.name = 'start_time';
            startTimeInput.value = window.quizState.quizStartTime || Date.now();
            this.appendChild(startTimeInput);
            
            @if($currentIndex + 1 >= $totalQuestions)
            createFullCelebration();
            @endif
            
            isSubmitting = true;
        });
        
        function createFullCelebration() {
            const celebration = document.getElementById('celebration');
            const colors = ['#ff4757', '#ff6b6b', '#ff8a80', '#ffc1cc', '#ffeb3b', '#4caf50'];
            
            for (let i = 0; i < 50; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + '%';
                    confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.animationDelay = Math.random() * 3 + 's';
                    
                    celebration.appendChild(confetti);
                    
                    setTimeout(() => {
                        confetti.remove();
                    }, 3000);
                }, i * 50);
            }
        }

        // Quiz Timer
        @if($quiz->time_limit_seconds && $quiz->time_limit_seconds > 0)
        function initializeQuizTimer() {
            if (!window.quizState.quizStartTime) {
                window.quizState.quizStartTime = Date.now();
                window.quizState.quizTimeRemaining = {{ $quiz->time_limit_seconds }};
            } else {
                const elapsedSeconds = Math.floor((Date.now() - window.quizState.quizStartTime) / 1000);
                window.quizState.quizTimeRemaining = Math.max(0, {{ $quiz->time_limit_seconds }} - elapsedSeconds);
            }
        }
        
        initializeQuizTimer();
        let quizTimeRemaining = window.quizState.quizTimeRemaining;
        const quizTimerEl = document.getElementById('quiz-timer');
        
        if (quizTimerEl) {
            function updateQuizTimer() {
                if (quizTimeRemaining > 0) {
                    const hours = Math.floor(quizTimeRemaining / 3600);
                    const minutes = Math.floor((quizTimeRemaining % 3600) / 60);
                    const seconds = quizTimeRemaining % 60;
                    
                    let display = '';
                    if (hours > 0) {
                        display = `${hours}:${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
                    } else {
                        display = `${minutes}:${seconds.toString().padStart(2,'0')}`;
                    }
                    
                    quizTimerEl.innerText = display;
                    
                    if (quizTimeRemaining <= 300) {
                        quizTimerEl.style.color = '#ff4757';
                        quizTimerEl.style.animation = 'pulse 1s infinite';
                    }
                    
                    quizTimeRemaining--;
                    window.quizState.quizTimeRemaining = quizTimeRemaining;
                } else {
                    if (!isSubmitting) {
                        alert('Quiz time has expired! Submitting automatically...');
                        document.getElementById('quiz-answer-form').submit();
                    }
                }
            }
            
            updateQuizTimer();
            setInterval(updateQuizTimer, 1000);
        }
        @endif

        // Question Timer
        @if($question->time_limit_seconds && $question->time_limit_seconds > 0)
        let questionTimeRemaining = {{ $question->time_limit_seconds }};
        const questionTimerEl = document.getElementById('question-timer');
        
        if (questionTimerEl) {
            function updateQuestionTimer() {
                if (questionTimeRemaining > 0) {
                    questionTimerEl.innerText = questionTimeRemaining + 's';
                    
                    if (questionTimeRemaining <= 10) {
                        questionTimerEl.style.color = '#ff4757';
                        questionTimerEl.style.animation = 'pulse 0.5s infinite';
                    }
                    
                    questionTimeRemaining--;
                } else {
                    if (!isSubmitting) {
                        alert('Question time has expired! Moving to next question...');
                        document.getElementById('quiz-answer-form').submit();
                    }
                }
            }
            
            updateQuestionTimer();
            setInterval(updateQuestionTimer, 1000);
        }
        @endif
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeMusicState();
            
            setTimeout(() => {
                const emojis = document.querySelectorAll('.floating-emoji');
                emojis.forEach((emoji, index) => {
                    emoji.style.animationDelay = (index * 2) + 's';
                });
            }, 500);
        });
        
        window.addEventListener('beforeunload', function() {
            window.quizState.musicPlaying = musicPlaying;
        });
    </script>
</x-app-layout>