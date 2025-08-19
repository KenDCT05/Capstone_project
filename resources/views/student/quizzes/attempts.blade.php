<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }} - Your Attempt</h1>

        @if($attempt)
            <p class="mb-2"><strong>Score:</strong> {{ $attempt->score }} / {{ $attempt->max_score }}</p>
            <p class="mb-4"><strong>Submitted At:</strong> {{ $attempt->submitted_at->format('M d, Y H:i') }}</p>

            <ul class="space-y-4">
                @foreach($attempt->answers as $answer)
                    <li class="p-4 border rounded @if ($answer->is_correct) bg-green-50 @else bg-red-50 @endif">
                        <p class="font-semibold">{{ $answer->question->question_text }}</p>
                        <p>Selected: {{ $answer->option?->option_text ?? 'No answer' }}</p>
                        <p>Points Awarded: {{ $answer->awarded_points }} / {{ $answer->question->points }}</p>
                    </li>
                @endforeach
            </ul>
        @else
            <p>You have not attempted this quiz yet.</p>
        @endif

        <div class="mt-4">
            <a href="{{ route('student.quizzes.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Back to Quizzes</a>
        </div>
    </div>
</x-app-layout>
