<x-app-layout>
    <div class="max-w-2xl mx-auto py-10">
        <h2 class="text-2xl font-bold mb-6">Edit Material</h2>

        <form action="{{ route('materials.teacher.update', $material->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block">Title</label>
                <input type="text" name="title" class="w-full" value="{{ old('title', $material->title) }}" required>
            </div>

            <div class="mb-4">
                <label class="block">Description</label>
                <textarea name="description" class="w-full">{{ old('description', $material->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block">Replace File (optional)</label>
                <input type="file" name="file" class="w-full">
            </div>

            <button class="bg-red-700 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
