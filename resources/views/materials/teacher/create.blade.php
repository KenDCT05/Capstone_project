<x-app-layout>
    <div class="max-w-xl mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-4">Upload Material</h2>

        <form action="{{ route('materials.teacher.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="subject_id">Subject:</label>
                <select name="subject_id" required>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mt-2">
                <label for="title">Title:</label>
                <input type="text" name="title" required>
            </div>

            <div class="mt-2">
                <label for="description">Description:</label>
                <textarea name="description"></textarea>
            </div>

            <div class="mt-2">
                <label for="file">File:</label>
                <input type="file" name="file" required>
            </div>

            <button type="submit" class="btn btn-success mt-4">Upload</button>
        </form>
    </div>
</x-app-layout>
