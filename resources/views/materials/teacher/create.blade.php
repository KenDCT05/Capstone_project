<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-rose-50">
        <div class="max-w-4xl mx-auto px-6 py-8">
            <!-- Navigation & Header -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-10 h-10 mr-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                        </svg>
                        Upload New Material
                    </h1>
                    <p class="text-red-100 mt-2">Create engaging learning resources for your students</p>
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
                    <form action="{{ route('materials.teacher.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
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
                                <option value="">Select a subject...</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
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
                            <input type="text" name="title" required 
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
                                      placeholder="Provide additional details about this material..."></textarea>
                        </div>

                        <!-- Activity Toggle -->
                        <div class="bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-200 rounded-2xl p-6">
                            <label for="is_activity" class="flex items-center space-x-4 cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" name="is_activity" id="is_activity" value="1"
                                           class="sr-only peer" onchange="toggleDueDate()">
                                    <div class="w-14 h-8 bg-gray-200 peer-focus:ring-4 peer-focus:ring-orange-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-7 after:w-7 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-orange-400 peer-checked:to-amber-400 cursor-pointer"></div>
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
                            </label>
                        </div>

                        <!-- Due Date (Hidden by default) -->
                        <div class="group" id="due_date_field" style="display: none;">
                            <label for="due_date" class="flex items-center text-red-700 font-bold text-lg mb-4">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                Due Date & Time
                            </label>
                            <input type="datetime-local" name="due_date"
                                   class="w-full bg-white/90 border-2 border-red-100 rounded-2xl px-6 py-4 text-gray-800 shadow-lg focus:ring-4 focus:ring-red-200/50 focus:border-red-300 transition-all duration-300 font-medium text-lg group-hover:shadow-xl">
                        </div>

                        <!-- File Upload -->
                        <div class="group">
                            <label for="file" class="flex items-center text-red-700 font-bold text-lg mb-4">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </div>
                                Upload File
                            </label>
                            <div class="relative">
                                <input type="file" name="file" required id="fileInput"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="bg-gradient-to-br from-red-100 to-rose-100 border-2 border-dashed border-red-300 rounded-2xl p-8 text-center hover:from-red-200 hover:to-rose-200 hover:border-red-400 transition-all duration-300 group-hover:shadow-xl">
                                    <div class="w-16 h-16 bg-gradient-to-br from-red-400 to-red-500 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                        </svg>
                                    </div>
                                    <div class="text-red-700 font-bold text-lg mb-2" id="fileText">Click to upload or drag and drop</div>
                                    <div class="text-red-500 text-sm">PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX files</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-6">
                            <button type="submit" 
                                    class="group relative inline-flex items-center space-x-3 bg-gradient-to-r from-red-500 to-rose-600 text-white px-12 py-4 rounded-2xl font-bold shadow-2xl shadow-red-500/30 hover:shadow-red-500/50 hover:from-red-600 hover:to-rose-700 transform hover:scale-105 transition-all duration-300 overflow-hidden text-lg">
                                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-rose-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-6 h-6 relative z-10 transform group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/>
                                </svg>
                                <span class="relative z-10">Upload Material</span>
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
    // ✅ IMPROVED: Better client-side validation
    function validateForm() {
        const dueDateInput = document.querySelector('input[name="due_date"]');
        const isActivityCheckbox = document.getElementById('is_activity');
        
        if (isActivityCheckbox && isActivityCheckbox.checked && dueDateInput && dueDateInput.value) {
            const dueDate = new Date(dueDateInput.value);
            const now = new Date();
            
            // Allow due dates up to 5 minutes in the past (to handle timezone issues)
            const fiveMinutesAgo = new Date(now.getTime() - 5 * 60 * 1000);
            
            if (dueDate < fiveMinutesAgo) {
                alert('Due date cannot be more than 5 minutes in the past. Please adjust the time.');
                dueDateInput.focus();
                return false;
            }
        }
        
        return true;
    }

    // ✅ IMPROVED: Better datetime handling
    function setMinDateTime() {
        const dueDateInput = document.querySelector('input[name="due_date"]');
        if (dueDateInput) {
            // Set minimum to 5 minutes ago to handle delays
            const fiveMinutesAgo = new Date(Date.now() - 5 * 60 * 1000);
            const minDateTime = fiveMinutesAgo.toISOString().slice(0, 16);
            dueDateInput.setAttribute('min', minDateTime);
        }
    }

    // ✅ IMPROVED: Activity toggle with better due date handling
    function toggleDueDate() {
        const checkbox = document.getElementById('is_activity');
        const dueDateField = document.getElementById('due_date_field');
        dueDateField.style.display = checkbox.checked ? 'block' : 'none';
        
        if (checkbox.checked) {
            setMinDateTime();
        }
    }

    // ✅ Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        setMinDateTime();
        
        // Update minimum datetime every minute
        setInterval(setMinDateTime, 60000);
        
        // ✅ IMPROVED: Form submission with retry mechanism
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!validateForm()) {
                    e.preventDefault();
                    return false;
                }
                
                // Disable submit button to prevent double submission
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    const originalContent = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"></circle><path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Uploading...';
                    
                    // Re-enable button after 30 seconds as fallback
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalContent;
                    }, 30000);
                }
            });
        }
    });

    // ✅ IMPROVED: File input enhancement with better error handling
    const fileInput = document.getElementById('fileInput');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileText = document.getElementById('fileText');
            
            if (file) {
                // Check file size (10MB limit)
                if (file.size > 10 * 1024 * 1024) {
                    alert('File size cannot exceed 10MB. Please choose a smaller file.');
                    this.value = '';
                    fileText.textContent = 'Click to upload or drag and drop';
                    fileText.classList.remove('text-green-700');
                    return;
                }
                
                // Check file type
                const allowedTypes = ['.pdf', '.doc', '.docx', '.txt', '.jpg', '.jpeg', '.png', '.zip', '.rar', '.ppt', '.pptx', '.xls', '.xlsx'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                
                if (!allowedTypes.includes(fileExtension)) {
                    alert('Invalid file type. Please choose a PDF, DOC, DOCX, TXT, JPG, JPEG, PNG, ZIP, RAR, PPT, PPTX, XLS, or XLSX file.');
                    this.value = '';
                    fileText.textContent = 'Click to upload or drag and drop';
                    fileText.classList.remove('text-green-700');
                    return;
                }
                
                const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
                fileText.textContent = `Selected: ${file.name} (${fileSizeMB} MB)`;
                fileText.classList.add('text-green-700');
            } else {
                fileText.textContent = 'Click to upload or drag and drop';
                fileText.classList.remove('text-green-700');
            }
        });

        // ✅ Add drag and drop functionality
        const dropZone = fileInput.parentElement;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-red-400', 'bg-red-200');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-red-400', 'bg-red-200');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files.length > 0) {
                fileInput.files = files;
                // Trigger the change event
                fileInput.dispatchEvent(new Event('change'));
            }
        }
    }

    // ✅ Add connection check and retry functionality
    function checkConnection() {
        return navigator.onLine;
    }

    // ✅ Show loading indicator during form submission
    function showLoadingState(form) {
        const loadingOverlay = document.createElement('div');
        loadingOverlay.id = 'loading-overlay';
        loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        loadingOverlay.innerHTML = `
            <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
                <div class="flex items-center">
                    <svg class="animate-spin h-6 w-6 mr-3 text-red-600" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.25"></circle>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-gray-800 font-medium">Uploading material...</span>
                </div>
                <div class="mt-2 text-sm text-gray-600">Please don't close this window</div>
            </div>
        `;
        document.body.appendChild(loadingOverlay);
    }

    // ✅ Handle form submission errors gracefully
    window.addEventListener('beforeunload', function(e) {
        const loadingOverlay = document.getElementById('loading-overlay');
        if (loadingOverlay) {
            e.preventDefault();
            e.returnValue = 'Upload in progress. Are you sure you want to leave?';
            return e.returnValue;
        }
    });
</script>
</x-app-layout>