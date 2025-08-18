<x-app-layout>
    <div class="max-w-5xl mx-auto mt-10 bg-white p-6 rounded shadow">
                                    <a href="{{ route('subjects.join') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Join Class
                            </a>
        <h2 class="text-2xl font-bold mb-6">My Enrolled Subjects</h2>

        @forelse ($subjects as $subject)
            <div class="mb-4 p-4 border rounded bg-red-50 shadow">
                <h3 class="text-lg font-semibold">{{ $subject->name }}</h3>
                <p class="text-sm text-gray-600">{{ $subject->description }}</p>
                <p class="text-sm text-gray-500 mt-2">Teacher: {{ $subject->teacher->name ?? 'N/A' }}</p>
            </div>
        @empty
            <p>You are not enrolled in any subjects yet.</p>
        @endforelse
    </div>
</x-app-layout>
