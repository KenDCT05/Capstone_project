<x-app-layout>
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Create Quiz</h1>
    <form method="POST" action="{{ route('quizzes.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1">Subject</label>
            <select name="subject_id" class="border rounded p-2 w-full" required>
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1">Title</label>
            <input name="title" class="border rounded p-2 w-full" required>
        </div>
        <div>
            <label class="block mb-1">Type</label>
            <select name="type" class="border rounded p-2 w-full">
                <option value="quiz">Quiz</option>
                <option value="exam">Exam</option>
                <option value="activity">Activity</option>
            </select>
        </div>
        <div>
            <label class="block mb-1">Whole Quiz Time (seconds)</label>
            <input type="number" name="time_limit_seconds" class="border rounded p-2 w-full" placeholder="e.g. 900">
        </div>
        <div class="flex items-center space-x-6">
            <label><input type="checkbox" name="randomize_questions" value="1" checked> Randomize questions</label>
            <label><input type="checkbox" name="randomize_options" value="1" checked> Randomize options</label>
        </div>
        <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
    </form>
</div>
</x-app-layout>
