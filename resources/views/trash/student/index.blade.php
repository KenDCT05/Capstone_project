<x-app-layout>
<div class="max-w-5xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Available Quizzes</h1>

    <form method="GET" class="mb-4">
        <select name="subject_id" onchange="this.form.submit()" class="border rounded p-2">
            <option value="">All Subjects</option>
            @foreach($subjects as $s)
                <option value="{{ $s->id }}" @selected(($subjectId ?? null) == $s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
    </form>

    <div class="grid gap-3">
        @forelse($quizzes as $q)
            <div class="border rounded p-4 bg-white">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $q->title }}</h3>
                        <p class="text-sm text-gray-600">{{ $q->subject->name }} • {{ ucfirst($q->type) }}</p>
                    </div>
                    <a class="px-3 py-1 bg-blue-600 text-white rounded" href="{{ route('student.quizzes.show',$q) }}">Open</a>
                </div>
            </div>
        @empty
            <p>No quizzes to show.</p>
        @endforelse
    </div>

    <div class="mt-4">{{ $quizzes->links() }}</div>
</div>
</x-app-layout>
