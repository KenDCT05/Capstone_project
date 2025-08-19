<x-app-layout>
<div class="max-w-4xl mx-auto p-6">
    <!-- Header Section -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Quiz Results</h1>
                    <p class="text-blue-100 text-lg">{{ $quiz->title }}</p>
                </div>
                <div class="text-center">
                    <div class="bg-white/20 rounded-full w-24 h-24 flex items-center justify-center backdrop-blur-sm">
                        <div class="text-center">
                            <div class="text-2xl font-bold">{{ $attempt->percentage }}%</div>
                            <div class="text-sm">Score</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Score Summary -->
        <div class="px-6 py-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-green-50 rounded-lg border border-green-200">
                    <div class="text-2xl font-bold text-green-600">{{ $attempt->score ?? $attempt->answers()->sum('awarded_points') }}</div>
                    <div class="text-sm text-green-700">Points Earned</div>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $attempt->max_score }}</div>
                    <div class="text-sm text-blue-700">Total Points</div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg border border-purple-200">
                    <div class="text-2xl font-bold text-purple-600">{{ $attempt->getCorrectAnswersCount() }}/{{ $attempt->getTotalQuestionsCount() }}</div>
                    <div class="text-sm text-purple-700">Correct Answers</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-gray-600">{{ $attempt->getGrade() }}</div>
                    <div class="text-sm text-gray-700">Grade</div>
                </div>
            </div>

            <!-- Performance Status -->
            <div class="text-center mb-6">
                @if($attempt->isPassed())
                    <div class="inline-flex items-center px-6 py-3 bg-green-100 border border-green-300 rounded-full">
                        <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-800 font-semibold text-lg">Congratulations! You Passed!</span>
                    </div>
                @else
                    <div class="inline-flex items-center px-6 py-3 bg-red-100 border border-red-300 rounded-full">
                        <svg class="w-6 h-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-red-800 font-semibold text-lg">You didn't pass this time. Keep studying!</span>
                    </div>
                @endif
            </div>

            <!-- Quiz Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                <div><strong>Started:</strong> {{ $attempt->started_at->format('M j, Y \a\t g:i A') }}</div>
                <div><strong>Completed:</strong> {{ $attempt->submitted_at->format('M j, Y \a\t g:i A') }}</div>
                <div><strong>Duration:</strong> {{ $attempt->duration ? $attempt->duration . ' minutes' : 'N/A' }}</div>
                <div><strong>Questions:</strong> {{ $attempt->getTotalQuestionsCount() }}</div>
            </div>
        </div>
    </div>

    <!-- Detailed Question Review -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-800">Question Review</h2>
            <p class="text-gray-600 mt-1">Review your answers and see the correct solutions</p>
        </div>

        <div class="divide-y divide-gray-200">
            @foreach($attempt->answers as $index => $answer)
                <div class="px-6 py-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center mb-2">
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium mr-3">
                                    Question {{ $index + 1 }}
                                </span>
                                @if($answer->is_correct)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Correct
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Incorrect
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $answer->question->question_text }}</h3>
                        </div>
                        <div class="text-right text-sm text-gray-600 ml-4">
                            <div class="font-medium">{{ $answer->awarded_points }}/{{ $answer->question->points }} pts</div>
                        </div>
                    </div>

                    <!-- Answer Options -->
                    <div class="space-y-2">
                        @foreach($answer->question->options as $option)
                            @php
                                $isUserAnswer = $option->id == $answer->option_id;
                                $isCorrectAnswer = $option->is_correct;
                                $userGotItRight = $isUserAnswer && $answer->is_correct;
                                $userGotItWrong = $isUserAnswer && !$answer->is_correct;
                                
                                if ($userGotItRight || ($isCorrectAnswer && !$isUserAnswer)) {
                                    $borderClass = 'border-green-300';
                                    $bgClass = 'bg-green-50';
                                } elseif ($userGotItWrong) {
                                    $borderClass = 'border-red-300';
                                    $bgClass = 'bg-red-50';
                                } else {
                                    $borderClass = 'border-gray-200';
                                    $bgClass = 'bg-gray-50';
                                }
                            @endphp
                            <div class="flex items-center p-3 rounded-lg border {{ $borderClass }} {{ $bgClass }}">
                                <div class="flex items-center mr-3">
                                    @if($option->id == $answer->option_id)
                                        <!-- User's selected answer -->
                                        @if($answer->is_correct)
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    @elseif($option->is_correct)
                                        <!-- Correct answer (if user got it wrong) -->
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <!-- Other options -->
                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full"></div>
                                    @endif
                                </div>
                                
                                <span class="
                                    @if($option->id == $answer->option_id && $answer->is_correct)
                                        text-green-800 font-medium
                                    @elseif($option->id == $answer->option_id && !$answer->is_correct)
                                        text-red-800 font-medium
                                    @elseif($option->is_correct)
                                        text-green-800 font-medium
                                    @else
                                        text-gray-700
                                    @endif
                                ">
                                    {{ $option->option_text }}
                                </span>

                                @if($isUserAnswer)
                                    <span class="ml-auto text-sm {{ $userGotItRight ? 'text-green-600' : 'text-red-600' }}">
                                        Your Answer
                                    </span>
                                @elseif($isCorrectAnswer && !$answer->is_correct)
                                    <span class="ml-auto text-sm text-green-600">Correct Answer</span>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Explanation if available -->
                    @if(isset($answer->question->explanation) && $answer->question->explanation)
                        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h4 class="font-medium text-blue-900 mb-2">Explanation:</h4>
                            <p class="text-blue-800">{{ $answer->question->explanation }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('student.quizzes.index') }}" 
               class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Back to Quizzes
            </a>
            
            @if($quiz->allow_retake ?? true)
                <a href="{{ route('student.quizzes.show', $quiz) }}" 
                   class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                    Retake Quiz
                </a>
            @endif
            
            <button onclick="window.print()" 
                    class="px-6 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors font-medium">
                Print Results
            </button>
            
            <button onclick="shareResults()" 
                    class="px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium">
                Share Results
            </button>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style>
@media print {
    .no-print { display: none !important; }
    body { background: white !important; }
    .shadow-lg { box-shadow: none !important; }
    .bg-gradient-to-r { background: #4f46e5 !important; }
}
</style>

<script>
function shareResults() {
    if (navigator.share) {
        navigator.share({
            title: 'Quiz Results - {{ $quiz->title }}',
            text: 'I scored {{ $attempt->percentage }}% on {{ $quiz->title }}!',
            url: window.location.href
        });
    } else {
        // Fallback - copy to clipboard
        const text = `I scored {{ $attempt->percentage }}% on {{ $quiz->title }}! ${window.location.href}`;
        navigator.clipboard.writeText(text).then(() => {
            alert('Results copied to clipboard!');
        });
    }
}

// Add some celebration animation for passing grades
@if($attempt->isPassed())
document.addEventListener('DOMContentLoaded', function() {
    // Simple confetti effect (you can enhance this)
    setTimeout(() => {
        const celebration = document.createElement('div');
        celebration.innerHTML = '🎉';
        celebration.style.cssText = `
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            font-size: 3rem;
            z-index: 1000;
            animation: bounce 2s ease-in-out;
        `;
        document.body.appendChild(celebration);
        
        setTimeout(() => celebration.remove(), 2000);
    }, 500);
});

// Add bounce animation
const style = document.createElement('style');
style.textContent = `
    @keyframes bounce {
        0%, 20%, 60%, 100% { transform: translateX(-50%) translateY(0); }
        40% { transform: translateX(-50%) translateY(-30px); }
        80% { transform: translateX(-50%) translateY(-15px); }
    }
`;
document.head.appendChild(style);
@endif
</script>
</x-app-layout>