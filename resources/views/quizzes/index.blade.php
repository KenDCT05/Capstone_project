<x-app-layout>
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">My Quizzes</h1>

    <form method="GET" class="mb-4">
        <select name="subject_id" onchange="this.form.submit()" class="border rounded p-2">
            <option value="">All Subjects</option>
            @foreach($subjects as $s)
                <option value="{{ $s->id }}" @selected($subjectId==$s->id)>{{ $s->name }}</option>
            @endforeach
        </select>
        <a href="{{ route('quizzes.create') }}" class="ml-3 px-4 py-2 bg-blue-600 text-white rounded">New Quiz</a>
    </form>

    <table class="w-full bg-white border">
        <thead>
            <tr class="bg-gray-50">
                <th class="p-2 text-left">Title</th>
                <th class="p-2 text-left">Subject</th>
                <th class="p-2">Questions</th>
                <th class="p-2">Published</th>
                <th class="p-2 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($quizzes as $q)
                <tr class="border-t">
                    <td class="p-2">{{ $q->title }}</td>
                    <td class="p-2">{{ $q->subject->name }}</td>
                    <td class="p-2 text-center">{{ $q->questions_count }}</td>
                    <td class="p-2 text-center">{{ $q->is_published ? 'Yes' : 'No' }}</td>
                    <td class="p-2 text-right space-x-2">
                        <a href="{{ route('quizzes.edit',$q) }}" class="px-3 py-1 bg-amber-500 text-white rounded">Edit</a>
                        <form action="{{ route('quizzes.destroy',$q) }}" method="POST" class="inline"
                              onsubmit="return confirm('Delete quiz?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                        </form>
                        @if(!$q->is_published)
                            <form action="{{ route('quizzes.publish',$q) }}" method="POST" class="inline">
                                @csrf
                                <button class="px-3 py-1 bg-green-600 text-white rounded">Publish</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td class="p-4" colspan="5">No quizzes yet.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $quizzes->links() }}</div>
</div>
</x-app-layout>
