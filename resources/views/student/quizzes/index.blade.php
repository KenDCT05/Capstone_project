<x-app-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka+One:wght@400&family=Nunito:wght@400;600;700;800&display=swap');
        
        * {
            box-sizing: border-box;
            
        }

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #fff1f2 0%, #fee2e2 50%, #fdf2f8 100%);
            background-size: 400% 400%;
            animation: rainbowBackground 8s ease infinite;
            min-height: 100vh;
        }

        @keyframes rainbowBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .quiz-container {
            max-width: 1200px;
            background: linear-gradient(135deg, #fff1f2 0%, #fee2e2 50%, #fdf2f8 100%);
            margin: 0 auto;
            padding: 20px;
        }

        .quiz-title {
            font-family: 'Fredoka One', cursive;
            font-size: 3.5rem;
            color: #f8f9fa  ;
            text-shadow: 4px 4px 8px rgba(0,0,0,0.3);
            text-align: center;
            margin-bottom: 40px;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .quiz-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .quiz-card {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 25px;
            padding: 30px;
            box-shadow: 
                0 15px 35px rgba(220, 38, 38, 0.2),
                0 5px 15px rgba(0, 0, 0, 0.1);
            border: 4px solid #dc2626;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .quiz-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.6s ease;
        }

        .quiz-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 
                0 25px 50px rgba(220, 38, 38, 0.3),
                0 15px 25px rgba(0, 0, 0, 0.2);
        }

        .quiz-card:hover::before {
            left: 100%;
        }

        .quiz-icon {
            font-size: 6rem;
            margin-bottom: 20px;
            text-align: center;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .math-icon { color: #dc2626; }
        .science-icon { color: #16a34a; }
        .english-icon { color: #2563eb; }
        .history-icon { color: #ca8a04; }
        .art-icon { color: #7c3aed; }
        .general-icon { color: #dc2626; }

        .quiz-content h2 {
            font-family: 'Fredoka One', cursive;
            font-size: 2rem;
            color: #dc2626;
            margin-bottom: 15px;
            text-align: center;
        }

        .quiz-info {
            background: rgba(220, 38, 38, 0.1);
            padding: 15px;
            border-radius: 15px;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 600;
            font-size: 1.2rem;
            color: #7f1d1d;
        }

        .quiz-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 1.3rem;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.3);
            transition: all 0.3s ease;
            transform: translate(-50%, -50%);
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }   

        .btn-view {
            background: linear-gradient(45deg, #e75050, #f54b4b);
            color: white;
        }

        .btn-view:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(223, 47, 47, 0.4);
        }

        .btn-take {
            background: linear-gradient(45deg, #16a34a, #22c55e);
            color: white;
            animation: wiggle 3s infinite;
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

        .btn-take:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(22, 163, 74, 0.4);
            animation: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px;
            background: rgba(255,255,255,0.9);
            border-radius: 25px;
            border: 4px dashed #dc2626;
            font-size: 1.5rem;
            color: #dc2626;
            font-weight: 600;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        /* Fun decorative elements */
        .floating-emoji {
            position: absolute;
            font-size: 2rem;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .emoji-1 { top: 10%; left: 10%; animation-delay: 0s; }
        .emoji-2 { top: 20%; right: 10%; animation-delay: -1s; }
        .emoji-3 { bottom: 20%; left: 15%; animation-delay: -2s; }
        .emoji-4 { bottom: 10%; right: 15%; animation-delay: -3s; }

        @media (max-width: 768px) {
            .quiz-title { font-size: 2.5rem; }
            .quiz-grid { grid-template-columns: 1fr; }
            .quiz-icon { font-size: 4rem; }
            .quiz-actions { flex-direction: column; }
        }
         .quiz-unpublished {
        opacity: 0.7;
        border-color: #9ca3af !important;
    }
    
    .btn-disabled {
        background: linear-gradient(45deg, #6b7280, #9ca3af);
        color: white;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    .btn-disabled:hover {
        transform: none;
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
}
.filter-section {
    background: rgba(255,255,255,0.95);
    border-radius: 25px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: 0 15px 35px rgba(220, 38, 38, 0.2);
    border: 4px solid #dc2626;
    animation: slideDown 0.6s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.filter-label {
    font-family: 'Fredoka One', cursive;
    font-size: 1.5rem;
    color: #dc2626;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.filter-select {
    font-family: 'Nunito', sans-serif;
    font-weight: 600;
    font-size: 1.2rem;
    padding: 15px 20px;
    border: 3px solid #dc2626;
    border-radius: 15px;
    background: white;
    color: #7f1d1d;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
}

.filter-select:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 15px rgba(220, 38, 38, 0.2);
}

.filter-select:focus {
    outline: none;
    border-color: #ef4444;
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
}

.btn-clear {
    background: linear-gradient(45deg, #7c3aed, #a855f7);
    color: white;
    font-family: 'Nunito', sans-serif;
    font-weight: 700;
    font-size: 1.1rem;
    padding: 12px 25px;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 8px 15px rgba(124, 58, 237, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-clear:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(124, 58, 237, 0.4);
}

.filter-active {
    background: rgba(220, 38, 38, 0.1);
    padding: 12px 20px;
    border-radius: 15px;
    margin-top: 15px;
    font-weight: 700;
    color: #7f1d1d;
    font-size: 1.1rem;
    text-align: center;
    animation: pulse 2s infinite;
}

.filter-grid {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 15px;
    align-items: end;
}

@media (max-width: 768px) {
    .filter-grid {
        grid-template-columns: 1fr;
    }
}
    </style>

    <div class="quiz-container">
        <!-- Floating decorative emojis -->
        <div class="floating-emoji emoji-1">🎉</div>
        <div class="floating-emoji emoji-2">⭐</div>
        <div class="floating-emoji emoji-3">🚀</div>
        <div class="floating-emoji emoji-4">🏆</div>
    <div class="bg-white rounded-3xl shadow-2xl border-4 border-red-200 mb-12 overflow-hidden">
    
    <!-- Header Section -->
    <div class="bg-red-500 p-8">
        <h1 class="quiz-title text-4xl font-bold text-white text-center">🎯 Fun Quiz Time! 🎯</h1>
        <p class="text-red-100 text-center mt-2">Test your knowledge with fun challenges</p>
    </div>

    
    <!-- Content Section -->
    <div class="p-6">
        <!-- Back Button -->
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center text-lg font-bold text-red-700 bg-red-50 border-2 border-red-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400 shadow-md hover:bg-red-100 transition-all duration-200 cursor-pointer">
            <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" 
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="font-medium">Dashboard</span>
        </a>
    </div>

</div>
<!-- Filter Section -->
<div class="filter-section">
    <label class="filter-label">
         Filter by Subject
    </label>
    
    <form method="GET" action="{{ route('student.quizzes.index') }}">
        <div class="filter-grid">
            <div>
                <select name="subject_id" class="filter-select" onchange="this.form.submit()">
                    <option value=""> All Subjects</option>
                    @foreach($enrolledSubjects as $subject)
                        <option value="{{ $subject->id }}" 
                                {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            @if($selectedSubjectId)
                <a href="{{ route('student.quizzes.index') }}" class="btn-clear">
                    Clear Filter
                </a>
            @endif
        </div>
        

    </form>
</div>

@if($quizzes->count())
    <div class="quiz-grid">
        @foreach($quizzes as $quiz)
            @php
                $attempt = $quiz->attempts()
                    ->where('student_id', auth()->id())
                    ->first();
                
                // Assign icons based on quiz type or title
                $icon = '📚'; // default
                $iconClass = 'general-icon';
                
                $type = strtolower($quiz->type ?? $quiz->title ?? '');
                if (str_contains($type, 'math')) {
                    $icon = '🔢';
                    $iconClass = 'math-icon';
                } elseif (str_contains($type, 'science')) {
                    $icon = '🔬';
                    $iconClass = 'science-icon';
                } elseif (str_contains($type, 'english') || str_contains($type, 'language')) {
                    $icon = '📖';
                    $iconClass = 'english-icon';
                } elseif (str_contains($type, 'history')) {
                    $icon = '🏛️';
                    $iconClass = 'history-icon';
                } elseif (str_contains($type, 'art')) {
                    $icon = '🎨';
                    $iconClass = 'art-icon';
                }
            @endphp

            <div class="quiz-card {{ !$quiz->is_published ? 'quiz-unpublished' : '' }}">
                <div class="quiz-icon {{ $iconClass }}">{{ $icon }}</div>
                <div class="quiz-content">
                    <h2>{{ $quiz->title }}</h2>
                    <div class="quiz-info">
                        <div>📋 {{ ucfirst($quiz->type) }}</div>
                        <div>🏆 Total Points: {{ $quiz->total_points }}</div>
                        
                        @if(!$quiz->is_published)
                            <div style="color: #dc2626; margin-top: 10px; font-weight: bold;">
                             Quiz Closed
                            </div>
                        @elseif($attempt)
                            <div style="color: #16a34a; margin-top: 10px;"> Completed!</div>
                        @else
                            <div style="color: #dc2626; margin-top: 10px;"> Ready to Take!</div>
                        @endif
                    </div>
                    <div class="quiz-actions">
                        @if($attempt)
                            <a href="{{ route('student.quizzes.result', $quiz) }}" 
                               class="btn btn-view">
                                 View Results
                            </a>
                        @endif
                        
                        @if(!$attempt)
                            @if($quiz->is_published)
                                <a href="{{ route('student.quizzes.show', ['quiz' => $quiz, 'q' => 0]) }}"
                                   class="btn btn-take">
                                     Start Quiz!
                                </a>
                            @else
                                <button class="btn btn-disabled" disabled>
                                     Quiz Unavailable
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination-wrapper">
        {{ $quizzes->links() }}
    </div>
@else
    <div class="empty-state">
        <div style="font-size: 4rem; margin-bottom: 20px;">😴</div>
        <div>No quizzes available at the moment.</div>
        <div style="font-size: 1.2rem; margin-top: 10px; opacity: 0.8;">Check back soon for exciting new quizzes!</div>
    </div>
@endif
    </div>

    <script>
        // Add click sound effect (optional)
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.quiz-card');
            const buttons = document.querySelectorAll('.btn');
            
            // Add hover sound simulation (visual feedback only since we can't play actual sounds)
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px) scale(1.02)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
            
            // Add click animation for buttons
            buttons.forEach(button => {
                button.addEventListener('click', function(e) {
                    this.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
            
            // Add random floating animations to cards
            cards.forEach((card, index) => {
                const delay = index * 200;
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s ease';
                    
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, delay);
            });
        });
    </script>
</x-app-layout>