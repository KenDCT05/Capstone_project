<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-rose-50">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- Navigation & Header -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-10 h-10 mr-4" fill="none" stroke="currentColor" viewBox="0 0 20 20">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Material
                    </h1>
                    <p class="text-red-100 mt-2">Update your teaching resource details</p>
                </div>
                
                <div class="px-8 py-6">
                    <a href="{{ route('materials.teacher.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium ml-2">Back to Materials</span>
                    </a>
                </div>
            </div>

            <!-- Main Form Container -->
            <div class="bg-white/80 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-2xl shadow-red-100/20 overflow-hidden">
                <!-- Decorative Background -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-400/10 to-rose-400/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-red-300/10 to-pink-300/10 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="relative p-8">
                    <!-- Current File Info -->
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 mb-8">
                        <div class="flex items-center space-x-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-blue-800 text-lg">Current File</div>
                                <div class="text-blue-600 text-sm">{{ basename($material->file_path) }}</div>
                                <div class="flex items-center space-x-3 mt-2">
                                    <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-blue-100 to-blue-200 text-blue-700 text-xs font-bold rounded-lg">
                                        {{ strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION)) }}
                                    </span>
                                    <span class="text-xs text-blue-500 font-medium">Uploaded {{ $material->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('materials.teacher.update', $material->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')
                        
                        <!-- Subject Selection -->
                        <div class="group">
                            <label for="subject_id" class="flex items-center text-red-700 font-bold text-lg mb-4">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                Subject
                            </label>
                            <select name="subject_id" required class="w-full bg-white/90 border-2 border-red-100 rounded-2xl px-6 py-4 text-red-800 shadow-lg focus:ring-4 focus:ring-red-200/50 focus:border-red-300 transition-all duration-300 font-medium text-lg group-hover:shadow-xl">
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $material->subject_id == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Title Input -->
                        <div class="group">
                            <label for="title" class="flex items-center text-red-700 font-bold text-lg mb-4">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a1.994 1.994 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                Title
                            </label>
                            <input type="text" name="title" required value="{{ old('title', $material->title) }}"
                                   class="w-full bg-white/90 border-2 border-red-100 rounded-2xl px-6 py-4 text-gray-800 shadow-lg focus:ring-4 focus:ring-red-200/50 focus:border-red-300 transition-all duration-300 font-medium text-lg group-hover:shadow-xl"
                                   placeholder="Enter a descriptive title for your material...">
                        </div>

                        <!-- Description -->
                        <div class="group">
                            <label for="description" class="flex items-center text-red-700 font-bold text-lg mb-4">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                    </svg>
                                </div>
                                Description
                            </label>
                            <textarea name="description" rows="4" 
                                      class="w-full bg-white/90 border-2 border-red-100 rounded-2xl px-6 py-4 text-gray-800 shadow-lg focus:ring-4 focus:ring-red-200/50 focus:border-red-300 transition-all duration-300 font-medium resize-none group-hover:shadow-xl"
                                      placeholder="Provide additional details about this material...">{{ old('description', $material->description) }}</textarea>
                        </div>

                        <!-- Activity Toggle -->
                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-200 rounded-2xl p-6">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <input type="checkbox" name="is_activity" id="is_activity" value="1"
                                           {{ $material->is_activity ? 'checked' : '' }}
                                           class="sr-only peer" onchange="toggleDueDate()">
                                    <div class="w-14 h-8 bg-gray-200 peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-7 after:w-7 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-orange-400 peer-checked:to-amber-400"></div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-bold text-orange-800 text-lg">Activity Mode</div>
                                        <div class="text-orange-600 text-sm">Allow students to submit responses to this material</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Due Date -->
                        <div class="group" id="due_date_field" style="display: {{ $material->is_activity ? 'block' : 'none' }};">
                            <label for="due_date" class="flex items-center text-red-700 font-bold text-lg mb-4">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                Due Date & Time
                            </label>
                            <input type="datetime-local" name="due_date" 
                                   value="{{ $material->due_date ? $material->due_date->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full bg-white/90 border-2 border-red-100 rounded-2xl px-6 py-4 text-gray-800 shadow-lg focus:ring-4 focus:ring-red-200/50 focus:border-red-300 transition-all duration-300 font-medium text-lg group-hover:shadow-xl">
                        </div>

                        <!-- File Replacement -->
                        <div class="group">
                            <label for="file" class="flex items-center text-red-700 font-bold text-lg mb-4">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </div>
                                Replace File (Optional)
                            </label>
                            <div class="relative">
                                <input type="file" name="file" id="fileInput"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="bg-gradient-to-br from-amber-100 to-yellow-100 border-2 border-dashed border-amber-300 rounded-2xl p-8 text-center hover:from-amber-200 hover:to-yellow-200 hover:border-amber-400 transition-all duration-300 group-hover:shadow-xl">
                                    <div class="w-16 h-16 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                    </div>
                                    <div class="text-amber-700 font-bold text-lg mb-2" id="fileText">Click to replace current file</div>
                                    <div class="text-amber-600 text-sm">Leave empty to keep the current file</div>
                                    <div class="text-amber-500 text-xs mt-2">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX files</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                            <button type="submit" 
                                    class="group relative inline-flex items-center space-x-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-12 py-4 rounded-2xl font-bold shadow-2xl shadow-green-500/30 hover:shadow-green-500/50 hover:from-green-600 hover:to-emerald-700 transform hover:scale-105 transition-all duration-300 overflow-hidden text-lg">
                                <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-6 h-6 relative z-10 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="relative z-10">Update Material</span>
                            </button>

                            <a href="{{ route('materials.teacher.index') }}" 
                               class="inline-flex items-center space-x-2 bg-white/90 backdrop-blur-sm border-2 border-red-200 text-red-600 px-8 py-4 rounded-2xl font-semibold hover:bg-red-50 hover:border-red-300 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                <span>Cancel</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDueDate() {
            const checkbox = document.getElementById('is_activity');
            const dueDateField = document.getElementById('due_date_field');
            dueDateField.style.display = checkbox.checked ? 'block' : 'none';
        }

        // File input enhancement
        document.getElementById('fileInput').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const fileText = document.getElementById('fileText');
            if (fileName) {
                fileText.textContent = `Selected: ${fileName}`;
                fileText.classList.add('text-green-700');
                fileText.classList.remove('text-amber-700');
            } else {
                fileText.textContent = 'Click to replace current file';
                fileText.classList.remove('text-green-700');
                fileText.classList.add('text-amber-700');
            }
        });
    </script>
</x-app-layout>