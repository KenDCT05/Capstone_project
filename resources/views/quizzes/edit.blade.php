<x-app-layout>
<div class="max-w-4xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-bold">Edit Quiz: {{ $quiz->title }}</h1>

    <form method="POST" action="{{ route('quizzes.update',$quiz) }}" class="space-y-3">
        @csrf @method('PUT')
        <div>
            <label class="block mb-1">Subject</label>
            <select name="subject_id" class="border rounded p-2 w-full">
                @foreach($subjects as $s)
                    <option value="{{ $s->id }}" @selected($quiz->subject_id==$s->id)>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block mb-1">Title</label>
            <input name="title" class="border rounded p-2 w-full" value="{{ $quiz->title }}" required>
        </div>
        <div class="grid grid-cols-3 gap-3">
            <div>
                <label class="block mb-1">Type</label>
                <select name="type" class="border rounded p-2 w-full">
                    @foreach(['quiz','exam','activity'] as $t)
                        <option value="{{ $t }}" @selected($quiz->type==$t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block mb-1">Whole Quiz Time (s)</label>
                <input type="number" name="time_limit_seconds" class="border rounded p-2 w-full" value="{{ $quiz->time_limit_seconds }}">
            </div>
            <div class="flex items-center gap-6 mt-6">
                <label><input type="checkbox" name="randomize_questions" value="1" @checked($quiz->randomize_questions)> Randomize Qs</label>
                <label><input type="checkbox" name="randomize_options" value="1" @checked($quiz->randomize_options)> Randomize Opts</label>
            </div>
        </div>
        <div>
            <label><input type="checkbox" name="is_published" value="1" @checked($quiz->is_published)> Published</label>
        </div>
        <button class="px-4 py-2 bg-amber-600 text-white rounded">Save Quiz</button>
    </form>

    <hr>

    <h2 class="text-xl font-semibold">Add Question</h2>
    <form method="POST" action="{{ route('quizzes.questions.store',$quiz) }}" class="space-y-3">
        @csrf
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="block mb-1">Type</label>
                <select name="question_type" class="border rounded p-2 w-full">
                    <option value="mcq">Multiple Choice</option>
                    <option value="tf">True/False</option>
                </select>
            </div>
            <div>
                <label class="block mb-1">Points</label>
                <input type="number" name="points" class="border rounded p-2 w-full" value="1" min="1">
            </div>
        </div>
        <div>
            <label class="block mb-1">Question</label>
            <textarea name="question_text" class="border rounded p-2 w-full" required></textarea>
        </div>
        <div>
            <label class="block mb-1">Per-Question Time (seconds, optional)</label>
            <input type="number" name="time_limit_seconds" class="border rounded p-2 w-full">
        </div>

        <div class="space-y-2">
            <p class="font-medium">Options (mark one correct)</p>
            @for($i=0;$i<4;$i++)
                <div class="flex items-center gap-2">
                    <input type="radio" name="correct_index" value="{{ $i }}" @checked($i==0)>
                    <input name="options[]" class="border rounded p-2 w-full" placeholder="Option {{ $i+1 }}">
                </div>
            @endfor
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded">Add Question</button>
    </form>

    <hr>

    <h2 class="text-xl font-semibold">Questions</h2>
    @forelse($quiz->questions as $q)
        <div class="border rounded p-4 mb-3">
            <div class="flex justify-between">
                <div>
                    <p class="font-semibold">{{ $q->question_text }}</p>
                    <p class="text-sm text-gray-600">Points: {{ $q->points }} | Type: {{ strtoupper($q->question_type) }}</p>
                </div>
                <form action="{{ route('quizzes.questions.destroy',$q) }}" method="POST" onsubmit="return confirm('Delete question?')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                </form>
            </div>
            <ul class="mt-2 list-disc ml-6">
                @foreach($q->options as $i=>$opt)
                <li>
                    {{ $opt->option_text }}
                    @if($opt->is_correct) <span class="text-green-600 font-semibold">(correct)</span> @endif
                </li>
                @endforeach
            </ul>
        </div>
    @empty
        <p>No questions yet.</p>
    @endforelse
</div>
</x-app-layout>
