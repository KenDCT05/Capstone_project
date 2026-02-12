<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Main Form Container -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 overflow-hidden">
                
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-lg flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-3xl font-bold text-white">Create New Subject</h2>
                            <p class="text-red-100 mt-1">Set up a new course for your students</p>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="p-8">
                    <form action="{{ route('subjects.store') }}" method="POST">
                        @csrf

                        <!-- Year Level Dropdown -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-red-800 mb-2">Year Level</label>
                            <select id="year_level" required
                                    class="w-full border-2 border-red-200 rounded-xl px-4 py-3 bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">Select Year Level</option>
                                <option value="1">Grade 1</option>
                                <option value="2">Grade 2</option>
                                <option value="3">Grade 3</option>
                                <option value="4">Grade 4</option>
                                <option value="5">Grade 5</option>
                                <option value="6">Grade 6</option>
                                <option value="7">Grade 7</option>
                            </select>
                        </div>

                        <!-- Section Dropdown (will be populated dynamically) -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-red-800 mb-2">Section</label>
                            <select id="section" required
                                    class="w-full border-2 border-red-200 rounded-xl px-4 py-3 bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                    disabled>
                                <option value="">Select Year Level First</option>
                            </select>
                        </div>

                        <!-- Subject Dropdown -->
                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-red-800 mb-2">Subject</label>
                            <select id="subject" required
                                    class="w-full border-2 border-red-200 rounded-xl px-4 py-3 bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent">
                                <option value="">Select Subject</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->name }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Hidden input for final combined name -->
                        <input type="hidden" name="name" id="subject_name" required>

                        <!-- Live Preview -->
                        <div class="mb-6 p-4 bg-gradient-to-r from-red-50 to-orange-50 rounded-xl border-2 border-red-200">
                            <span class="block text-xs font-semibold text-red-800 mb-1">FINAL SUBJECT NAME:</span>
                            <span id="preview_text" class="text-lg text-gray-400 italic">Please select all fields above</span>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <label class="block text-sm font-semibold text-red-800 mb-2">Description (Optional)</label>
                            <textarea name="description" rows="3"
                                      class="w-full border-2 border-red-200 rounded-xl px-4 py-3 bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                      placeholder="Add a brief description of this subject..."></textarea>
                        </div>

                        <!-- Submit -->
                        <button type="submit" id="submit_btn" disabled
                                class="w-full bg-gradient-to-r from-red-500 to-red-700 text-white font-bold py-3 px-4 rounded-xl shadow-md hover:scale-105 transition disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                            Create Subject
                        </button>
                    </form>
                </div>

                <!-- Info Section -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 px-8 py-4 border-t border-red-200">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-sm text-red-700">
                            <p class="font-medium mb-1">What happens next?</p>
                            <ul class="space-y-1 text-red-600">
                                <li>• A unique join code will be automatically generated</li>
                                <li>• Students can use this code to join your subject</li>
                                <li>• You can manage and edit the subject anytime</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script to handle dynamic sections and combine fields -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const yearLevelSelect = document.getElementById('year_level');
            const sectionSelect = document.getElementById('section');
            const subjectSelect = document.getElementById('subject');
            const subjectNameInput = document.getElementById('subject_name');
            const previewText = document.getElementById('preview_text');
            const submitBtn = document.getElementById('submit_btn');

            // All sections data passed from backend
            const allSections = @json($sections);

            // When year level changes, populate sections
            yearLevelSelect.addEventListener('change', function() {
                const selectedYearLevel = parseInt(this.value);
                
                // Clear current section options
                sectionSelect.innerHTML = '<option value="">Select Section</option>';
                
                if (selectedYearLevel) {
                    // Filter sections by year level
                    const filteredSections = allSections.filter(section => 
                        section.year_level === selectedYearLevel
                    );
                    
                    if (filteredSections.length > 0) {
                        // Enable and populate section dropdown
                        sectionSelect.disabled = false;
                        filteredSections.forEach(section => {
                            const option = document.createElement('option');
                            option.value = section.name;
                            option.textContent = section.name;
                            sectionSelect.appendChild(option);
                        });
                    } else {
                        // No sections for this grade
                        sectionSelect.disabled = true;
                        sectionSelect.innerHTML = '<option value="">No sections available for this grade</option>';
                    }
                } else {
                    // No year level selected
                    sectionSelect.disabled = true;
                    sectionSelect.innerHTML = '<option value="">Select Year Level First</option>';
                }
                
                updateSubjectName();
            });

            function updateSubjectName() {
                const yearLevel = yearLevelSelect.value;
                const section = sectionSelect.value;
                const subject = subjectSelect.value;
                
                if (yearLevel && section && subject) {
                    const finalName = yearLevel + ' - ' + section + ' - ' + subject;
                    subjectNameInput.value = finalName;
                    previewText.textContent = finalName;
                    previewText.classList.remove('text-gray-400', 'italic', 'text-lg');
                    previewText.classList.add('text-red-900', 'font-bold', 'text-xl');
                    submitBtn.disabled = false;
                } else {
                    subjectNameInput.value = '';
                    previewText.textContent = 'Please select all fields above';
                    previewText.classList.remove('text-red-900', 'font-bold', 'text-xl');
                    previewText.classList.add('text-gray-400', 'italic', 'text-lg');
                    submitBtn.disabled = true;
                }
            }

            sectionSelect.addEventListener('change', updateSubjectName);
            subjectSelect.addEventListener('change', updateSubjectName);
        });
    </script>
</x-app-layout>