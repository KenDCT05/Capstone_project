{{-- resources/views/materials/teacher/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">My Uploaded Materials</h2>

        <!-- Subject Filter -->
        <form method="GET" class="mb-4">
            <select name="subject_id" onchange="this.form.submit()" class="border rounded p-2">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Upload Button -->
        <a href="{{ route('materials.teacher.create') }}" class="inline-block bg-red-700 text-white px-4 py-2 rounded mb-4 hover:bg-red-800">Upload New Material</a>

        <!-- Materials Table -->
        @if($materials->count())
            <table class="w-full bg-white shadow rounded">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="p-3">Title</th>
                        <th class="p-3">Subject</th>
                        <th class="p-3">Description</th>
                        <th class="p-3">Uploaded</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materials as $material)
                        <tr class="border-t">
                            <td class="p-3">
                                <div class="font-medium">{{ $material->title }}</div>
                                <div class="text-sm text-gray-500">
                                    {{ pathinfo($material->file_path, PATHINFO_EXTENSION) }} file
                                </div>
                            </td>
                            <td class="p-3">
                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                                    {{ $material->subject->name }}
                                </span>
                            </td>
                            <td class="p-3">
                                <div class="text-sm text-gray-600">
                                    {{ Str::limit($material->description, 50) ?: 'No description' }}
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="text-sm text-gray-500">
                                    {{ $material->created_at->format('M d, Y') }}
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="flex space-x-3">
                                    <!-- FIXED: Use route-based download instead of Storage::url() -->
                                    <a href="{{ route('materials.teacher.download', $material) }}" 
                                       class="text-green-600 hover:text-green-800 hover:underline font-medium">
                                        Download
                                    </a>
                                    
                                    <a href="{{ route('materials.teacher.edit', $material) }}" 
                                       class="text-blue-600 hover:text-blue-800 hover:underline font-medium">
                                        Edit
                                    </a>
                                    
                                    <form action="{{ route('materials.teacher.destroy', $material) }}" 
                                          method="POST" 
                                          class="inline-block" 
                                          onsubmit="return confirm('Are you sure you want to delete this material?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-600 hover:text-red-800 hover:underline font-medium">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                <p class="text-gray-600">No materials found.</p>
                <p class="text-sm text-gray-500 mt-1">
                    Upload your first material to get started.
                </p>
            </div>
        @endif
    </div>
</x-app-layout>