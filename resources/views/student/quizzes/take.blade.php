<x-app-layout>
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">

    <div class="mb-4">
        <h2 class="text-xl font-bold mb-2">Question {{ $currentIndex + 1 }} of {{ $totalQuestions }}</h2>
        
        <!-- Progress bar -->
        <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ (($currentIndex + 1) / $totalQuestions) * 100 }}%"></div>
        </div>
    </div>

    <!-- Display timers if they exist -->
    @if(isset($quiz->time_limit_seconds) && $quiz->time_limit_seconds)
        <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded">
            <p class="text-sm text-yellow-700">Quiz Time Remaining: <span id="quiz-timer" class="font-bold">{{ $quiz->time_limit_seconds }}</span> seconds</p>
        </div>
    @endif

    @if(isset($question->time_limit_seconds) && $question->time_limit_seconds)
        <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded">
            <p class="text-sm text-blue-700">Question Time Remaining: <span id="question-timer" class="font-bold">{{ $question->time_limit_seconds }}</span> seconds</p>
        </div>
    @endif

    <div class="mb-6">
        <p class="text-lg mb-4">{{ $question->question_text }}</p>
        
        @if($question->points)
            <p class="text-sm text-gray-600 mb-4">Points: {{ $question->points }}</p>
        @endif
    </div>

    <!-- THE KEY FIX: Include the current question index in the form action -->
   <form method="POST" action="{{ route('student.quizzes.take', $quiz) }}?q={{ $currentIndex }}">
        @csrf
        
        <!-- Hidden field to ensure we know which question we're answering -->
        <input type="hidden" name="current_question_index" value="{{ $currentIndex }}">
        
        <!-- Default empty value to handle cases where no option is selected -->
        <input type="hidden" name="answers[{{ $question->id }}]" value="">
        
        <div class="space-y-3 mb-6">
            @foreach($options as $option)
                <div>
                    <label class="flex items-start space-x-3 p-3 border-2 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors {{ isset($existingAnswer) && $existingAnswer->option_id == $option['id'] ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                        <input 
                            type="radio" 
                            name="answers[{{ $question->id }}]" 
                            value="{{ $option['id'] }}" 
                            class="mt-1 text-blue-600 focus:ring-blue-500"
                            {{ isset($existingAnswer) && $existingAnswer->option_id == $option['id'] ? 'checked' : '' }}
                            required
                        >
                        <span class="text-gray-800">{{ $option['option_text'] }}</span>
                    </label>
                </div>
            @endforeach
        </div>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded">
                <ul class="text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex justify-between items-center">
            <div>
                @if($currentIndex > 0)
                    <a href="{{ route('student.quizzes.take', [$quiz, 'q' => $currentIndex - 1]) }}" 
                       class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                        ← Previous
                    </a>
                @else
                    <div></div> <!-- Empty div to maintain flexbox spacing -->
                @endif
            </div>

            <div class="text-center">
                <button type="submit" 
                        class="px-8 py-3 rounded-lg text-white font-medium transition-colors {{ $currentIndex + 1 < $totalQuestions ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}">
                    {{ $currentIndex + 1 < $totalQuestions ? 'Next Question →' : 'Submit Quiz ✓' }}
                </button>
            </div>
        </div>
    </form>

    <!-- Quiz info -->
    <div class="mt-8 pt-4 border-t border-gray-200">
        <div class="flex justify-between text-sm text-gray-600">
            <span>Quiz: {{ $quiz->title }}</span>
            <span>Progress: {{ $currentIndex + 1 }}/{{ $totalQuestions }}</span>
        </div>
    </div>
</div>

<script>
    // Question timer
    @if(isset($question->time_limit_seconds) && $question->time_limit_seconds)
    let qTime = {{ $question->time_limit_seconds }};
    const qTimerEl = document.getElementById('question-timer');
    const questionTimer = setInterval(() => {
        if(qTime > 0) {
            qTime--;
            qTimerEl.innerText = qTime;
        } else {
            clearInterval(questionTimer);
            // Auto-submit when question time runs out
            document.querySelector('form').submit();
        }
    }, 1000);
    @endif

    // Quiz timer
    @if(isset($quiz->time_limit_seconds) && $quiz->time_limit_seconds)
    let quizTime = {{ $quiz->time_limit_seconds }};
    const quizTimerEl = document.getElementById('quiz-timer');
    const quizTimer = setInterval(() => {
        if(quizTime > 0) {
            quizTime--;
            quizTimerEl.innerText = quizTime;
        } else {
            clearInterval(quizTimer);
            // Auto-submit when quiz time runs out
            alert('Time is up! Submitting quiz...');
            // Redirect to submit route
            window.location.href = "{{ route('student.quizzes.submit', $quiz) }}";
        }
    }, 1000);
    @endif

    // Prevent accidental page refresh/back button
    window.addEventListener('beforeunload', function (e) {
        e.preventDefault();
        e.returnValue = '';
    });

    // Auto-save functionality (optional enhancement)
    document.addEventListener('change', function(e) {
        if (e.target.type === 'radio') {
            // You could add AJAX auto-save here if desired
            console.log('Answer selected:', e.target.value);
        }
    });
</script>
</x-app-layout>