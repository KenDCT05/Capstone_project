<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-100 via-pink-50 to-red-200 py-2 sm:py-4">
        <div class="max-w-full mx-auto px-2 sm:px-4">
            <!-- Header Section -->
            <div class="text-center mb-4 sm:mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 md:w-24 md:h-24 bg-red-500 rounded-full mb-3 sm:mb-4 shadow-lg animate-bounce">
                    <span class="text-2xl sm:text-3xl md:text-4xl">📝</span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-black text-red-700 mb-2 drop-shadow-lg px-2">Submit Your Activity! </h1>
                <p class="text-base sm:text-lg md:text-xl text-red-600 font-semibold px-2">Show your teacher what amazing work you've done!</p>
            </div>

            <!-- Main Content Card -->
            <div class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-4 md:p-6 lg:p-8 shadow-2xl border-2 sm:border-4 border-red-200 mb-4 sm:mb-6">
                
                <!-- Activity Details Section -->
                <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-2xl sm:rounded-3xl p-3 sm:p-4 md:p-6 mb-4 sm:mb-6 border-2 sm:border-4 border-red-200 shadow-lg">
                    <div class="text-center mb-3 sm:mb-4">
                        <div class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-r from-red-400 to-pink-400 rounded-full mb-3 sm:mb-4 shadow-lg">
                            <span class="text-lg sm:text-xl md:text-2xl">⭐</span>
                        </div>
                        <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-red-700 mb-2 px-2">Your Activity Details</h2>
                    </div>

                    <!-- Activity Title -->
                    <div class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 mb-3 sm:mb-4 border-2 border-red-200 shadow-md">
                        <h3 class="text-lg sm:text-xl md:text-2xl font-black text-red-700 text-center break-words px-1">{{ $material->title }}</h3>
                    </div>

                    <!-- Activity Info Row -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-3 sm:mb-4">
                        <!-- Subject -->
                        <div class="bg-gradient-to-r from-blue-100 to-blue-200 rounded-xl sm:rounded-2xl p-3 sm:p-4 border-2 border-blue-300 shadow-md">
                            <div class="flex items-center justify-center">
                                <span class="text-lg sm:text-xl mr-2">📚</span>
                                <div class="text-center">
                                    <p class="text-xs font-bold text-blue-600 uppercase tracking-wide">Subject</p>
                                    <p class="text-base sm:text-lg font-black text-blue-700 break-words">{{ $material->subject->name }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Due Date -->
                        @if($material->due_date)
                            <div class="bg-gradient-to-r from-red-200 to-pink-200 rounded-xl sm:rounded-2xl p-3 sm:p-4 border-2 border-red-300 shadow-md">
                                <div class="flex items-center justify-center">
                                    <span class="text-lg sm:text-xl mr-2">⏰</span>
                                    <div class="text-center">
                                        <p class="text-xs font-bold text-red-600 uppercase tracking-wide">Due Date</p>
                                        <p class="text-sm sm:text-base md:text-lg font-black text-red-700 break-words">{{ $material->due_date->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Description -->
                    @if($material->description)
                        <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-xl sm:rounded-2xl p-3 sm:p-4 border-2 border-purple-200 shadow-md">
                            <div class="text-center mb-2">
                                <span class="text-lg sm:text-xl">📋</span>
                                <p class="text-xs sm:text-sm font-bold text-purple-600 uppercase tracking-wide">Instructions</p>
                            </div>
                            <p class="text-sm sm:text-base md:text-lg font-semibold text-purple-700 text-center leading-relaxed break-words px-1">{{ $material->description }}</p>
                        </div>
                    @endif
                </div>

                @if($existingSubmission)
                    <!-- Already Submitted Section -->
                    <div class="bg-gradient-to-r from-green-100 to-emerald-100 rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 border-2 sm:border-4 border-green-300 shadow-lg mb-4 sm:mb-6">
                        <div class="text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-18 sm:h-18 md:w-20 md:h-20 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full mb-3 sm:mb-4 shadow-lg animate-pulse">
                                <span class="text-2xl sm:text-3xl">✅</span>
                            </div>
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-black text-green-700 mb-3 sm:mb-4 px-2">Great Job! You Already Submitted! 🎉</h3>
                            
                            <div class="bg-white rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 shadow-lg border-2 border-green-200 mb-4 sm:mb-6">
                                <p class="text-base sm:text-lg md:text-xl font-bold text-green-600 mb-2 break-words">
                                    📅 Submitted on: {{ $existingSubmission->submitted_at->format('M d, Y g:i A') }}
                                </p>
                                
                                @if($existingSubmission->grade)
                                    <div class="bg-yellow-100 rounded-xl p-3 sm:p-4 mb-3 sm:mb-4 border-2 border-yellow-300">
                                        <p class="text-lg sm:text-xl md:text-2xl font-black text-yellow-700 break-words">
                                            🏆 Your Grade: {{ $existingSubmission->grade }}
                                        </p>
                                    </div>
                                @endif
                                
                                @if($existingSubmission->teacher_feedback)
                                    <div class="bg-blue-100 rounded-xl p-3 sm:p-4 border-2 border-blue-300">
                                        <p class="text-sm sm:text-base md:text-lg font-bold text-blue-600 mb-2">💬 Teacher's Feedback:</p>
                                        <p class="text-sm sm:text-base md:text-lg font-semibold text-blue-700 italic break-words">"{{ $existingSubmission->teacher_feedback }}"</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons for Existing Submission -->
                    <div class="flex flex-col gap-3 sm:gap-4 justify-center">
                        <a href="{{ route('submissions.download', $existingSubmission) }}" 
                           class="group inline-flex items-center justify-center px-4 sm:px-6 md:px-8 py-3 sm:py-4 md:py-6 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-base sm:text-lg md:text-xl lg:text-2xl font-black rounded-2xl sm:rounded-3xl shadow-2xl transform hover:scale-105 hover:rotate-1 transition-all duration-300 border-2 sm:border-4 border-blue-400 hover:border-blue-300 active:scale-95">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 mr-2 sm:mr-3 md:mr-4 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="drop-shadow-lg">DOWNLOAD MY WORK! </span>
                        </a>
                        
                        <a href="{{ route('materials.student.index') }}" 
                           class="group inline-flex items-center justify-center px-4 sm:px-6 md:px-8 py-3 sm:py-4 md:py-6 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white text-base sm:text-lg md:text-xl lg:text-2xl font-black rounded-2xl sm:rounded-3xl shadow-2xl transform hover:scale-105 hover:-rotate-1 transition-all duration-300 border-2 sm:border-4 border-gray-300 hover:border-gray-400 active:scale-95">
                            <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 mr-2 sm:mr-3 md:mr-4 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span class="drop-shadow-lg">BACK TO MATERIALS! </span>
                        </a>
                    </div>
                @else
                    <!-- Submission Form Section -->
                    <div class="bg-gradient-to-r from-orange-50 to-red-50 rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 border-2 sm:border-4 border-orange-200 shadow-lg">
                        <div class="text-center mb-4 sm:mb-6 md:mb-8">
                            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-18 sm:h-18 md:w-20 md:h-20 bg-gradient-to-r from-orange-400 to-red-400 rounded-full mb-3 sm:mb-4 shadow-lg animate-pulse">
                                <span class="text-2xl sm:text-3xl">📤</span>
                            </div>
                            <h3 class="text-xl sm:text-2xl md:text-3xl font-black text-orange-700 mb-2 px-2">Upload Your Amazing Work! 🌟</h3>
                            <p class="text-sm sm:text-base md:text-lg font-semibold text-orange-600 px-2">Choose your file and submit it to your teacher!</p>
                        </div>

                        <form action="{{ route('materials.student.submit.store', $material) }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6 md:space-y-8">
                            @csrf
                            
                            <!-- File Upload Section -->
                            <div class="bg-white rounded-xl sm:rounded-2xl p-4 sm:p-6 md:p-8 shadow-lg border-2 sm:border-4 border-orange-200">
                                <div class="text-center mb-4 sm:mb-6">
                                    <div class="inline-flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-r from-purple-400 to-pink-400 rounded-full mb-3 sm:mb-4 shadow-lg">
                                        <span class="text-lg sm:text-xl md:text-2xl">📁</span>
                                    </div>
                                    <label for="file" class="text-lg sm:text-xl md:text-2xl font-black text-purple-700 mb-2 block px-2">
                                        Choose Your File!
                                    </label>
                                    <p class="text-sm sm:text-base md:text-lg font-semibold text-purple-600 mb-3 sm:mb-4 px-2">Click the button below to select your work!</p>
                                </div>
                                
                                <div class="text-center">
                                    <input type="file" name="file" id="file" required class="hidden">
                                    <label for="file" class="inline-block cursor-pointer w-full max-w-sm">
                                        <div class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 shadow-2xl transform hover:scale-105 hover:rotate-1 transition-all duration-300 border-2 sm:border-4 border-purple-400 hover:border-purple-300 active:scale-95">
                                            <div class="space-y-2 sm:space-y-4">
                                                <div class="text-3xl sm:text-4xl md:text-6xl">📁</div>
                                                <p class="text-base sm:text-lg md:text-xl lg:text-2xl font-black drop-shadow-lg">CHOOSE YOUR FILE! 📎</p>
                                                <p class="text-sm sm:text-base md:text-lg font-bold">Maximum size: 10MB</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                
                                <!-- File Name Display -->
                                <div id="file-display" class="hidden mt-4 sm:mt-6">
                                    <div class="bg-gradient-to-r from-green-100 to-emerald-100 rounded-xl sm:rounded-2xl p-3 sm:p-4 md:p-6 border-2 sm:border-4 border-green-300 shadow-lg">
                                        <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-4">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-400 rounded-full flex items-center justify-center shadow-lg animate-bounce flex-shrink-0">
                                                <span class="text-lg sm:text-2xl">✅</span>
                                            </div>
                                            <div class="text-center sm:text-left flex-1 min-w-0">
                                                <p class="text-sm sm:text-base md:text-lg font-bold text-green-600 mb-1">File Selected! 🎉</p>
                                                <p id="file-name" class="text-base sm:text-lg md:text-xl font-black text-green-700 break-all"></p>
                                            </div>
                                            <button type="button" onclick="clearFile()" class="w-8 h-8 sm:w-10 sm:h-10 bg-red-400 hover:bg-red-500 rounded-full flex items-center justify-center shadow-lg transition-all duration-200 flex-shrink-0 active:scale-95">
                                                <span class="text-white text-sm sm:text-lg">✖️</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('file')
                                    <div class="mt-3 sm:mt-4 bg-red-100 border-2 sm:border-4 border-red-300 rounded-xl sm:rounded-2xl p-3 sm:p-4">
                                        <p class="text-sm sm:text-base md:text-lg font-bold text-red-600 text-center break-words">❌ {{ $message }}</p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col gap-3 sm:gap-4 justify-center">
                                <button type="submit" 
                                        class="group inline-flex items-center justify-center px-4 sm:px-6 md:px-8 py-3 sm:py-4 md:py-6 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white text-base sm:text-lg md:text-xl lg:text-2xl font-black rounded-2xl sm:rounded-3xl shadow-2xl transform hover:scale-105 hover:rotate-1 transition-all duration-300 border-2 sm:border-4 border-orange-400 hover:border-orange-300 animate-pulse active:scale-95">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 mr-2 sm:mr-3 md:mr-4 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <span class="drop-shadow-lg">SUBMIT NOW! </span>
                                </button>
                                
                                <a href="{{ route('materials.student.index') }}" 
                                   class="group inline-flex items-center justify-center px-4 sm:px-6 md:px-8 py-3 sm:py-4 md:py-6 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white text-base sm:text-lg md:text-xl lg:text-2xl font-black rounded-2xl sm:rounded-3xl shadow-2xl transform hover:scale-105 hover:-rotate-1 transition-all duration-300 border-2 sm:border-4 border-gray-300 hover:border-gray-400 active:scale-95">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 mr-2 sm:mr-3 md:mr-4 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="drop-shadow-lg">CANCEL </span>
                                </a>
                            </div>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Encouraging Footer -->
            <div class="text-center py-3 sm:py-4 md:py-8">
                <div class="inline-flex items-center space-x-2 sm:space-x-4 text-base sm:text-lg md:text-xl lg:text-2xl px-2">
                    <span class="animate-pulse">🌟</span>
                    <span class="text-sm sm:text-base md:text-lg lg:text-xl font-black text-red-600">You're doing amazing work! Keep it up!</span>
                    <span class="animate-pulse">🌟</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS and JavaScript -->
    <style>
        /* Enhanced button effects for mobile */
        button:hover, a:hover {
            box-shadow: 0 15px 30px -8px rgba(0, 0, 0, 0.3);
        }

        /* Smooth transitions for all elements */
        * {
            transition: all 0.2s ease-in-out;
        }

        /* Custom button glow effects */
        .group:hover {
            box-shadow: 0 15px 30px -8px rgba(34, 197, 94, 0.4);
        }

        /* Better touch targets for mobile */
        @media (max-width: 640px) {
            button, a {
                min-height: 48px;
                min-width: 48px;
            }
            
            /* Prevent zoom on focus for iOS */
            input[type="file"] {
                font-size: 16px;
            }
        }

        /* Prevent horizontal scroll */
        body {
            overflow-x: hidden;
        }

        /* Better text wrapping */
        .break-words {
            word-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
        }
    </style>

    <!-- JavaScript for file handling -->
    <script>
        // Wait for DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            
            if (fileInput) {
                fileInput.addEventListener('change', function() {
                    showFileName(this);
                });
            }
        });

        function showFileName(input) {
            console.log('showFileName called', input.files); // Debug log
            const fileDisplay = document.getElementById('file-display');
            const fileName = document.getElementById('file-name');
            
            if (input.files && input.files[0] && fileDisplay && fileName) {
                console.log('File selected:', input.files[0].name); // Debug log
                fileName.textContent = input.files[0].name;
                fileDisplay.classList.remove('hidden');
                
                // Add a little celebration animation
                setTimeout(() => {
                    fileDisplay.classList.add('animate-pulse');
                    setTimeout(() => {
                        fileDisplay.classList.remove('animate-pulse');
                    }, 1000);
                }, 100);
            } else {
                console.log('No file or elements not found'); // Debug log
                if (fileDisplay) {
                    fileDisplay.classList.add('hidden');
                }
            }
        }
        
        function clearFile() {
            const fileInput = document.getElementById('file');
            const fileDisplay = document.getElementById('file-display');
            
            if (fileInput) fileInput.value = '';
            if (fileDisplay) fileDisplay.classList.add('hidden');
        }

        // Add touch feedback for better mobile interaction
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('button, a');
            
            buttons.forEach(button => {
                button.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.95)';
                });
                
                button.addEventListener('touchend', function() {
                    setTimeout(() => {
                        this.style.transform = '';
                    }, 150);
                });
            });
        });
    </script>
</x-app-layout>