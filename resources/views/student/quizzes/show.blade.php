<x-app-layout>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-4">{{ $quiz->title }}</h1>
        <p class="text-gray-600 mb-2"><strong>Type:</strong> {{ ucfirst($quiz->type) }}</p>
        <p class="text-gray-600 mb-2"><strong>Total Points:</strong> {{ $quiz->total_points }}</p>
        @if($quiz->time_limit_seconds)
            <p class="text-gray-600 mb-4"><strong>Time Limit:</strong> {{ gmdate('H:i:s', $quiz->time_limit_seconds) }}</p>
        @endif

        <div class="mt-4 flex space-x-2">
            <a href="{{ route('student.quizzes.take', $quiz) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Start Quiz</a>
            <a href="{{ route('student.quizzes.index') }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Back</a>
        </div>
    </div>
</x-app-layout>
