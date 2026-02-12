<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 p-8 mb-8">
                <div class="flex items-center mb-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900">Create New Assessment</h1>
                </div>
                <p class="text-gray-600 text-lg">Design an engaging quiz or exam for your students</p>
            </div>

            <!-- Main Form -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 p-8">
                <form method="POST" action="{{ route('quizzes.store') }}" class="space-y-8">
                    @csrf
                    
                    <!-- Subject Selection -->
                    <div class="group">
                        <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Subject
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <select name="subject_id" 
                                class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-red-400 focus:ring-4 focus:ring-red-100 transition-all duration-300 hover:border-red-300 appearance-none" 
                                required>
                            <option value="" disabled selected>Select a subject</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Title Input -->
                    <div class="group">
                        <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Quiz Title
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <input name="title" 
                               type="text"
                               placeholder="Enter an engaging title for your quiz"
                               class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-red-400 focus:ring-4 focus:ring-red-100 transition-all duration-300 hover:border-red-300 placeholder-gray-400" 
                               required>
                    </div>

                    <!-- Type and Time Limit Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Quiz Type -->
                        <div class="group">
                            <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 011-1h1m-1 1v1m-1-1h1m-1 1v1"></path>
                                </svg>
                                Quiz Type
                            </label>
                            <select name="type" 
                                    class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-red-400 focus:ring-4 focus:ring-red-100 transition-all duration-300 hover:border-red-300 appearance-none">
                                <option value="quiz">📝 Quiz</option>
                                <option value="exam">📋 Exam</option>
                            </select>
                        </div>

                        <!-- Time Limit -->
                        <div class="group">
                            <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Time Limit (seconds)
                            </label>
                            <input type="number" 
                                   name="time_limit_seconds" 
                                   min="60"
                                   step="30"
                                   placeholder="e.g., 900 (15 minutes)"
                                   class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-red-400 focus:ring-4 focus:ring-red-100 transition-all duration-300 hover:border-red-300 placeholder-gray-400">
                            <p class="text-xs text-gray-500 mt-2">Tip: 900 seconds = 15 minutes, 1800 seconds = 30 minutes</p>
                        </div>
                    </div>

                    <!-- Quiz Options -->
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 rounded-2xl p-6 border border-red-100">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Quiz Settings
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Randomize Questions -->
                            <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-300 group">
                                <input type="checkbox" 
                                       name="randomize_questions" 
                                       value="1" 
                                       checked 
                                       class="w-5 h-5 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 focus:ring-2">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors duration-300">Randomize Questions</span>
                                    <p class="text-xs text-gray-500 mt-1">Questions appear in random order</p>
                                </div>
                            </label>

                            <!-- Randomize Options -->
                            <label class="flex items-center p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-red-300 cursor-pointer transition-all duration-300 group">
                                <input type="checkbox" 
                                       name="randomize_options" 
                                       value="1" 
                                       checked 
                                       class="w-5 h-5 text-red-600 bg-gray-100 border-gray-300 rounded focus:ring-red-500 focus:ring-2">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-900 group-hover:text-red-600 transition-colors duration-300">🎲 Randomize Options</span>
                                    <p class="text-xs text-gray-500 mt-1">Answer choices appear in random order</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- RETAKE POLICY SECTION - THIS WAS MISSING! -->
                    <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-2xl p-6 border border-purple-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Retake Policy
                        </h3>
                        
                        <div class="space-y-6">
                            <!-- Max Attempts Row -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Max Attempts -->
                                <div class="group">
                                    <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                        </svg>
                                        Maximum Attempts
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <input type="number" 
                                           name="max_attempts" 
                                           value="1"
                                           min="0"
                                           max="10"
                                           required
                                           class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all duration-300 hover:border-purple-300">
                                    <p class="text-xs text-gray-500 mt-2">Set to 0 for unlimited attempts</p>
                                </div>

                                <!-- Scoring Method -->
                                <div class="group">
                                    <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                        <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                        Scoring Method
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <select name="retake_scoring"
                                            required
                                            class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all duration-300 hover:border-purple-300 appearance-none">
                                        <option value="highest" selected>Highest Score</option>
                                        <option value="latest">Latest Attempt</option>
                                        <option value="average">Average of All Attempts</option>
                                        <option value="first">First Attempt Only</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-2">Which score to record in gradebook</p>
                                </div>
                            </div>


                            <!-- Additional Options -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Show Previous Answers -->
                                <label class="flex items-start p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 cursor-pointer transition-all duration-300 group">
                                    <input type="checkbox" 
                                           name="show_previous_answers" 
                                           value="1" 
                                           class="w-5 h-5 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 focus:ring-2 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900 group-hover:text-purple-600 transition-colors duration-300">
                                            Show Previous Answers
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">Students can review their mistakes when retaking</p>
                                    </div>
                                </label>

                                <!-- Require Passing Grade -->
                                <label class="flex items-start p-4 bg-white rounded-xl border-2 border-gray-200 hover:border-purple-300 cursor-pointer transition-all duration-300 group">
                                    <input type="checkbox" 
                                           name="require_pass_all" 
                                           value="1" 
                                           class="w-5 h-5 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 focus:ring-2 mt-1">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-900 group-hover:text-purple-600 transition-colors duration-300">
                                            Require Passing (75%)
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">No retakes allowed after passing</p>
                                    </div>
                                </label>
                            </div>

                            <!-- Info Box -->
                            <div class="bg-blue-50 border-2 border-blue-200 rounded-xl p-4">
                                <div class="flex items-start">
                                    <svg class="w-6 h-6 text-blue-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <strong class="font-semibold">Retake Policy Examples:</strong>
                                        <ul class="mt-2 space-y-1 list-disc list-inside">
                                            <li><strong>Practice Quiz:</strong> Unlimited attempts, highest score, show previous answers</li>
                                            <li><strong>Final Exam:</strong> 1 attempt only</li>
                                            <li><strong>Certification:</strong> 3 attempts max, 24-hour cooldown, require passing</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="flex-1 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Create Quiz
                        </button>
                        
                        <a href="{{ route('quizzes.index') }}" 
                           class="flex-1 sm:flex-none inline-flex items-center justify-center px-8 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-300">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Help Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Quick Tips
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600">
                    <div class="flex items-start">
                        <span class="text-red-500 mr-2">📝</span>
                        <div>
                            <strong>Quiz:</strong> Perfect for quick assessments and practice
                        </div>
                    </div>
                    <div class="flex items-start">
                        <span class="text-red-500 mr-2">📋</span>
                        <div>
                            <strong>Exam:</strong> Ideal for formal evaluations with strict timing
                        </div>
                    </div>
                    <div class="flex items-start">
                        <span class="text-red-500 mr-2">🎯</span>
                        <div>
                            <strong>Happy Teaching 😊</strong> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>