<x-app-layout>
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-2">{{ $quiz->title }}</h1>
    <p class="text-gray-600 mb-4">{{ $quiz->subject->name }} • {{ ucfirst($quiz->type) }}</p>

    @if($quiz->time_limit_seconds)
        <p class="mb-2">Time limit: <strong>{{ $quiz->time_limit_seconds }} seconds</strong></p>
    @endif
    <p class="mb-6">Total points: {{ $quiz->total_points }}</p>

    @if($existing && $existing->submitted_at)
        <div class="p-3 bg-green-50 border rounded mb-4">
            You already submitted this quiz. Score: {{ $existing->score }}/{{ $existing->max_score }}
        </div>
    @endif

    <form method="POST" action="{{ route('student.quizzes.start',$quiz) }}">
        @csrf
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Start / Continue</button>
    </form>
</div>
</x-app-layout>
