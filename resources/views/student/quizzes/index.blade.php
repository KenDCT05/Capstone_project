<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">Available Quizzes</h1>

        @if($quizzes->count())
            <ul class="space-y-4">
                @foreach($quizzes as $quiz)
                    <li class="p-4 bg-white rounded-xl shadow hover:shadow-md border">
                        <div class="flex justify-between items-center">
                            <div>
                                <h2 class="text-xl font-semibold">{{ $quiz->title }}</h2>
                                <p class="text-gray-500">{{ ucfirst($quiz->type) }} | Total Points: {{ $quiz->total_points }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('student.quizzes.show', $quiz) }}" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">View</a>
                                <a href="{{ route('student.quizzes.take', $quiz) }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Take Quiz</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4">
                {{ $quizzes->links() }}
            </div>
        @else
            <p>No quizzes available at the moment.</p>
        @endif
    </div>
</x-app-layout>
