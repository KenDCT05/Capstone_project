<x-app-layout>
    <div class="max-w-7xl mx-auto p-4">
        <h2 class="text-xl font-bold mb-4">Available Materials</h2>

        <!-- Subject Filter -->
        <form method="GET" class="mb-6">
            <select name="subject_id" onchange="this.form.submit()" class="border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </form>

        <!-- Materials List -->
        @forelse($materials as $material)
            <div class="mb-4 p-4 border border-gray-200 rounded-lg bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">
                            {{ $material->title }}
                        </h3>
                        
                        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                {{ $material->subject->name }}
                            </span>
                            <span>
                                Uploaded: {{ $material->created_at->format('M d, Y') }}
                            </span>
                            <span>
                                By: {{ $material->teacher->name }}
                            </span>
                        </div>

                        @if($material->description)
                            <p class="text-gray-600 text-sm mb-3">
                                {{ $material->description }}
                            </p>
                        @endif
                    </div>

                    <div class="ml-4">
                        <!-- FIXED: Use route-based download instead of Storage::url() -->
                        <a href="{{ route('materials.student.download', $material) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download
                        </a>
                    </div>
                </div>
                
                <!-- File Info -->
                <div class="mt-3 pt-3 border-t border-gray-100">
                    <div class="flex items-center text-xs text-gray-500">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        {{ strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION)) }} file
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-8 text-center">
                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No materials available</h3>
                <p class="text-gray-600">
                    @if($selectedSubject)
                        No materials found for the selected subject.
                    @else
                        No materials have been uploaded for your enrolled subjects yet.
                    @endif
                </p>
            </div>
        @endforelse
    </div>
</x-app-layout>