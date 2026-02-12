<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            
            <!-- Header Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Title: {{ $quiz->title }}
                    </h1>
                    <p class="text-red-100 mt-2">Edit Quiz Settings</p>
                </div>
                
                <div class="px-8 py-6">
                    <a href="{{ route('quizzes.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Quiz Dashboard</span>
                    </a> 
                </div>
            </div>

            <!-- RETAKE POLICY FORM SECTION -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg mr-3"></div>
                    Quiz Settings & Retake Policy
                </h2>

                <form method="POST" action="{{ route('quizzes.update', $quiz) }}" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Basic Quiz Settings (Read-Only Display) -->
  <!-- Quiz Settings Display (Read-Only) -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-gray-500 to-gray-600 rounded-lg mr-3"></div>
                    Quiz Information
                    <span class="ml-3 inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Read Only
                    </span>
                </h2>

                <!-- Read-only display of quiz settings -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            Subject
                        </label>
                        <div class="text-lg font-medium text-gray-900">{{ $quiz->subject->name ?? 'No Subject' }}</div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Quiz Title
                        </label>
                        <div class="text-lg font-medium text-gray-900">{{ $quiz->title }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 011-1h1m-1 1v1m-1-1h1m-1 1v1"></path>
                            </svg>
                            Quiz Type
                        </label>
                        <div class="text-lg font-medium text-gray-900 capitalize">{{ $quiz->type }}</div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Time Limit
                        </label>
                        <div class="text-lg font-medium text-gray-900">
                            {{ $quiz->time_limit_seconds ? $quiz->time_limit_seconds . ' seconds' : 'No limit' }}
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-200">
                        <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Total Questions
                        </label>
                        <div class="text-lg font-medium text-gray-900">{{ $quiz->questions->count() }}</div>
                    </div>
                </div>

                <!-- Note about locked settings -->
                <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-blue-800 font-medium">
                            Quiz settings are locked for editing. You can only add, remove, or modify questions.
                        </span>
                    </div>
                </div>
            </div>

                    <!-- Retake Policy Section -->
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
                                    </label>
                                    <input type="number" 
                                           name="max_attempts" 
                                           value="{{ old('max_attempts', $quiz->max_attempts ?? 1) }}"
                                           min="0"
                                           max="10"
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
                                    </label>
                                    <select name="retake_scoring"
                                            class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all duration-300 hover:border-purple-300 appearance-none">
                                        <option value="highest" {{ old('retake_scoring', $quiz->retake_scoring ?? 'highest') == 'highest' ? 'selected' : '' }}>
                                            Highest Score
                                        </option>
                                        <option value="latest" {{ old('retake_scoring', $quiz->retake_scoring ?? '') == 'latest' ? 'selected' : '' }}>
                                            Latest Attempt
                                        </option>
                                        <option value="average" {{ old('retake_scoring', $quiz->retake_scoring ?? '') == 'average' ? 'selected' : '' }}>
                                            Average of All Attempts
                                        </option>
                                        <option value="first" {{ old('retake_scoring', $quiz->retake_scoring ?? '') == 'first' ? 'selected' : '' }}>
                                            First Attempt Only
                                        </option>
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
                                           {{ old('show_previous_answers', $quiz->show_previous_answers ?? false) ? 'checked' : '' }}
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
                                           {{ old('require_pass_all', $quiz->require_pass_all ?? false) ? 'checked' : '' }}
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

                    <!-- Save Button -->
                    <div class="flex gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Retake Policy
                        </button>
                        
                        <a href="{{ route('quizzes.index') }}" 
                           class="inline-flex items-center px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-all duration-300">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Success Message (Initially Hidden) -->
            <div id="success-message" class="hidden bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span id="success-text"></span>
                </div>
            </div>

            <!-- Error Message (Initially Hidden) -->
            <div id="error-message" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span id="error-text"></span>
                </div>
            </div>

            <!-- Add Question Form with Dynamic Types -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 p-8" x-data="questionForm()">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-red-600 rounded-lg mr-3"></div>
                    Add New Question
                </h2>

                <form id="question-form" @submit.prevent="submitQuestion" class="space-y-6">
                    @csrf
                    
                    <!-- Question Type Selection -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Question Type
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            <label class="relative">
                                <input type="radio" @change="questionType = 'mcq'" name="question_type" value="mcq" class="sr-only peer">
                                <div class="flex flex-col items-center p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-blue-500 peer-checked:bg-blue-50">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mb-2">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Multiple Choice</span>
                                    <span class="text-xs text-gray-500 text-center">2-6 options with one correct</span>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" @change="questionType = 'tf'" name="question_type" value="tf" class="sr-only peer">
                                <div class="flex flex-col items-center p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-green-500 peer-checked:bg-green-50">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mb-2">
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">True/False</span>
                                    <span class="text-xs text-gray-500 text-center">Simple true or false choice</span>
                                </div>
                            </label>
                            
                            <label class="relative">
                                <input type="radio" @change="questionType = 'fib'" name="question_type" value="fib" class="sr-only peer">
                                <div class="flex flex-col items-center p-4 bg-white border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 peer-checked:border-purple-500 peer-checked:bg-purple-50">
                                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mb-2">
                                        <svg class="w-4 h-4 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">Fill in the Blank</span>
                                    <span class="text-xs text-gray-500 text-center">Student types the answer</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Question Settings -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                Points
                            </label>
                            <input type="number" 
                                name="points" 
                                value="1" 
                                min="1"
                                class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-red-400 focus:ring-4 focus:ring-red-100 transition-all duration-300 hover:border-red-300">
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Time Limit (seconds)
                            </label>
                            <input type="number" 
                                name="time_limit_seconds" 
                                min="5"
                                step="5"
                                placeholder="Optional"
                                class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-red-400 focus:ring-4 focus:ring-red-100 transition-all duration-300 hover:border-red-300 placeholder-gray-400">
                        </div>
                    </div>

                    <!-- Question Text -->
                    <div>
                        <label class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Question Text
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <textarea name="question_text" 
                                rows="4"
                                placeholder="Enter your question here..."
                                class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-red-400 focus:ring-4 focus:ring-red-100 transition-all duration-300 hover:border-red-300 placeholder-gray-400 resize-none" 
                                required></textarea>
                    </div>

                    <!-- Dynamic Answer Section -->
                    <!-- Multiple Choice Options -->
                    <div x-show="questionType === 'mcq'" class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl p-6 border border-blue-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            Answer Options (select the correct one)
                        </h3>
                        
                        <div class="space-y-4">
                            <template x-for="(option, index) in mcqOptions" :key="index">
                                <div class="flex items-center gap-4 bg-white rounded-xl p-4 border-2 border-gray-200 hover:border-blue-200 transition-all duration-300">
                                    <div class="flex items-center">
                                        <input type="radio" 
                                            name="correct_index" 
                                            :value="index" 
                                            :checked="index === 0"
                                            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                                        <span class="ml-2 text-sm font-medium text-gray-600" x-text="String.fromCharCode(65 + index)"></span>
                                    </div>
                                    <input name="options[]" 
                                        type="text"
                                        :placeholder="'Enter option ' + String.fromCharCode(65 + index)"
                                        x-model="option.text"
                                        class="flex-1 border-0 bg-transparent text-gray-900 focus:ring-0 focus:outline-none placeholder-gray-400">
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- True/False Options -->
<!-- True/False Options - COLOR RESPONSIVE VERSION -->
<div x-show="questionType === 'tf'" class="bg-gradient-to-r from-green-50 to-green-100 rounded-2xl p-6 border border-green-200" x-data="{ selectedTF: 'true' }">
    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
        <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        Select the Correct Answer
    </h3>
    
    <div class="grid grid-cols-2 gap-4">
        <!-- True Option -->
        <label class="cursor-pointer">
            <input type="radio" 
                   name="correct_answer_tf" 
                   value="true" 
                   @change="selectedTF = 'true'"
                   checked
                   class="sr-only">
            <div class="flex items-center justify-center p-6 rounded-xl transition-all duration-300 transform hover:scale-105"
                 :class="selectedTF === 'true' ? 
                     'bg-green-100 border-2 border-green-500 shadow-lg shadow-green-200' : 
                     'bg-white border-2 border-gray-200 hover:bg-green-50 hover:border-green-200'">
                <svg class="w-8 h-8 mr-3 transition-colors duration-300" 
                     :class="selectedTF === 'true' ? 'text-green-600' : 'text-gray-400'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-xl font-bold transition-colors duration-300"
                      :class="selectedTF === 'true' ? 'text-green-800' : 'text-gray-700'">True</span>
            </div>
        </label>
        
        <!-- False Option -->
        <label class="cursor-pointer">
            <input type="radio" 
                   name="correct_answer_tf" 
                   value="false"
                   @change="selectedTF = 'false'"
                   class="sr-only">
            <div class="flex items-center justify-center p-6 rounded-xl transition-all duration-300 transform hover:scale-105"
                 :class="selectedTF === 'false' ? 
                     'bg-red-100 border-2 border-red-500 shadow-lg shadow-red-200' : 
                     'bg-white border-2 border-gray-200 hover:bg-red-50 hover:border-red-200'">
                <svg class="w-8 h-8 mr-3 transition-colors duration-300" 
                     :class="selectedTF === 'false' ? 'text-red-600' : 'text-gray-400'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span class="text-xl font-bold transition-colors duration-300"
                      :class="selectedTF === 'false' ? 'text-red-800' : 'text-gray-700'">False</span>
            </div>
        </label>
    </div>
</div>

                    <!-- Fill in the Blank Options -->
                    <div x-show="questionType === 'fib'" class="bg-gradient-to-r from-purple-50 to-purple-100 rounded-2xl p-6 border border-purple-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Answer Settings
                        </h3>
                        
                        <div class="space-y-4">
                            <!-- Correct Answer -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Correct Answer <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                    name="correct_answer"
                                    placeholder="Enter the correct answer"
                                    class="w-full border-2 border-gray-200 rounded-xl p-4 text-gray-900 bg-white focus:border-purple-400 focus:ring-4 focus:ring-purple-100 transition-all duration-300">
                            </div>

                            <!-- Alternative Answers -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Alternative Acceptable Answers (optional)
                                </label>
                                <div class="space-y-2" x-data="{ alternatives: ['', ''] }">
                                    <template x-for="(alt, index) in alternatives" :key="index">
                                        <input type="text" 
                                            name="alternative_answers[]"
                                            :placeholder="'Alternative answer ' + (index + 1)"
                                            x-model="alternatives[index]"
                                            class="w-full border-2 border-gray-200 rounded-xl p-3 text-gray-900 bg-white focus:border-purple-400 focus:ring-2 focus:ring-purple-100 transition-all duration-300">
                                    </template>
                                    <button type="button" 
                                            @click="alternatives.push('')"
                                            x-show="alternatives.length < 5"
                                            class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                        + Add another alternative
                                    </button>
                                </div>
                            </div>

                            <!-- Answer Matching Options -->
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-purple-200">
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                        name="case_sensitive" 
                                        value="1"
                                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-gray-700">Case sensitive matching</span>
                                </label>
                                
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                        name="allow_partial_match" 
                                        value="1"
                                        class="w-4 h-4 text-purple-600 bg-gray-100 border-gray-300 rounded focus:ring-purple-500 focus:ring-2">
                                    <span class="ml-2 text-sm text-gray-700">Allow partial/fuzzy matching</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-4 pt-6 border-t border-gray-200">
                        <button type="submit" 
                                :disabled="isSubmitting"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg x-show="!isSubmitting" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <!-- Loading spinner -->
                            <svg x-show="isSubmitting" class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="isSubmitting ? 'Adding Question...' : 'Add Question'"></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Questions List -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-red-600 rounded-lg mr-3"></div>
                    Quiz Questions
                    <span class="ml-3 text-lg font-normal text-gray-500" id="question-count">({{ $quiz->questions->count() }} questions)</span>
                </h2>

                <div id="questions-container">
                    @forelse($quiz->questions as $index => $q)
                        <div class="question-item bg-gradient-to-r from-gray-50 to-red-50 rounded-2xl border-2 border-gray-200 p-6 mb-6 hover:border-red-200 transition-all duration-300" data-question-id="{{ $q->id }}">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-red-600 text-white rounded-full text-sm font-bold mr-3">
                                            {{ $index + 1 }}
                                        </span>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $q->question_text }}</h3>
                                    </div>
                                    
                                    <div class="flex gap-4 text-sm text-gray-600 mb-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                            {{ $q->points }} points
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full 
                                            @if($q->question_type === 'mcq') bg-blue-100 text-blue-800
                                            @elseif($q->question_type === 'tf') bg-green-100 text-green-800
                                            @elseif($q->question_type === 'fib') bg-purple-100 text-purple-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $q->getQuestionTypeLabel() }}
                                        </span>
                                        @if($q->time_limit_seconds)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $q->time_limit_seconds }}s
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <button onclick="deleteQuestion({{ $q->id }})" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition-all duration-300 hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>

                            <!-- Question Type Specific Display -->
                            @if($q->question_type === 'fib')
                                <!-- Fill in the Blank Display -->
                                <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-purple-800">Correct Answer:</span>
                                        <span class="ml-2 text-purple-900 font-mono">{{ $q->correct_answer }}</span>
                                    </div>
                                    
                                    @if($q->acceptableAnswers->count() > 0)
                                        <div class="mb-2">
                                            <span class="text-sm font-medium text-purple-800">Alternative Answers:</span>
                                            <div class="mt-1">
                                                @foreach($q->acceptableAnswers as $alt)
                                                    <span class="inline-block bg-purple-100 text-purple-800 text-sm px-2 py-1 rounded mr-2 mb-1 font-mono">{{ $alt->answer_text }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="flex gap-4 text-xs text-purple-600">
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Case Sensitive: {{ $q->case_sensitive ? 'Yes' : 'No' }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                            Partial Match: {{ $q->allow_partial_match ? 'Yes' : 'No' }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <!-- MCQ/True-False Display -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    @foreach($q->options as $i => $opt)
                                        <div class="flex items-center p-3 {{ $opt->is_correct ? 'bg-green-100 border-2 border-green-300' : 'bg-white border-2 border-gray-200' }} rounded-lg">
                                            <span class="inline-flex items-center justify-center w-6 h-6 {{ $opt->is_correct ? 'bg-green-600 text-white' : 'bg-gray-400 text-white' }} rounded-full text-xs font-bold mr-3">
                                                {{ chr(65 + $i) }}
                                            </span>
                                            <span class="text-sm {{ $opt->is_correct ? 'font-semibold text-green-800' : 'text-gray-700' }}">
                                                {{ $opt->option_text }}
                                            </span>
                                            @if($opt->is_correct)
                                                <svg class="w-5 h-5 text-green-600 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @empty
                        <div id="no-questions-message" class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No questions yet</h3>
                            <p class="text-gray-500">Add your first question using the form above.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Back to Quizzes Button -->
            <div class="flex justify-center">
                <a href="{{ route('quizzes.index') }}" 
                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-gray-600 to-gray-700 hover:from-gray-700 hover:to-gray-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to All Quizzes
                </a>
            </div>
        </div>
    </div>

    <!-- Alpine.js Component Script -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('questionForm', () => ({
                questionType: 'mcq',
                isSubmitting: false,
                mcqOptions: [
                    { text: '' },
                    { text: '' },
                    { text: '' },
                    { text: '' }
                ],
                
                init() {
                    this.$nextTick(() => {
                        const firstRadio = this.$el.querySelector('input[name="question_type"][value="mcq"]');
                        if (firstRadio) {
                            firstRadio.checked = true;
                        }
                    });
                },

                async submitQuestion() {
                    this.isSubmitting = true;
                    this.hideMessages();

                    try {
                        const formData = new FormData(this.$el);
                        
                        const response = await fetch(`{{ route('quizzes.questions.store', $quiz) }}`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                                'Accept': 'application/json',
                            }
                        });

                        const result = await response.json();

                        if (response.ok && result.success) {
                            this.showSuccess(result.message || 'Question added successfully!');
                            this.resetForm();
                            this.addQuestionToList(result.question);
                            this.updateQuestionCount();
                        } else {
                            const errorMessage = result.message || 'Failed to add question. Please try again.';
                            this.showError(errorMessage);
                            
                            if (result.errors) {
                                console.error('Validation errors:', result.errors);
                            }
                        }
                    } catch (error) {
                        console.error('Error adding question:', error);
                        this.showError('An unexpected error occurred. Please try again.');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                resetForm() {
                    // Reset form fields
                    this.$el.reset();
                    
                    // Reset Alpine data
                    this.questionType = 'mcq';
                    this.mcqOptions = [
                        { text: '' },
                        { text: '' },
                        { text: '' },
                        { text: '' }
                    ];

                    // Reset radio button
                    this.$nextTick(() => {
                        const firstRadio = this.$el.querySelector('input[name="question_type"][value="mcq"]');
                        if (firstRadio) {
                            firstRadio.checked = true;
                        }
                        
                        // Reset points to 1
                        const pointsInput = this.$el.querySelector('input[name="points"]');
                        if (pointsInput) {
                            pointsInput.value = '1';
                        }
                    });
                },

                addQuestionToList(question) {
                    // Remove "no questions" message if it exists
                    const noQuestionsMsg = document.getElementById('no-questions-message');
                    if (noQuestionsMsg) {
                        noQuestionsMsg.remove();
                    }

                    // Create new question element
                    const container = document.getElementById('questions-container');
                    const questionCount = container.querySelectorAll('.question-item').length + 1;
                    
                    const questionHtml = this.createQuestionHtml(question, questionCount);
                    container.insertAdjacentHTML('beforeend', questionHtml);
                },

                createQuestionHtml(question, index) {
                    const typeColors = {
                        'mcq': 'bg-blue-100 text-blue-800',
                        'tf': 'bg-green-100 text-green-800',
                        'fib': 'bg-purple-100 text-purple-800'
                    };
                    
                    let optionsHtml = '';
                    
                    if (question.question_type === 'fib') {
                        optionsHtml = `
                            <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                                <div class="mb-2">
                                    <span class="text-sm font-medium text-purple-800">Correct Answer:</span>
                                    <span class="ml-2 text-purple-900 font-mono">${question.correct_answer}</span>
                                </div>
                                ${question.alternative_answers && question.alternative_answers.length > 0 ? `
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-purple-800">Alternative Answers:</span>
                                        <div class="mt-1">
                                            ${question.alternative_answers.map(alt => `<span class="inline-block bg-purple-100 text-purple-800 text-sm px-2 py-1 rounded mr-2 mb-1 font-mono">${alt}</span>`).join('')}
                                        </div>
                                    </div>
                                ` : ''}
                                <div class="flex gap-4 text-xs text-purple-600">
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Case Sensitive: ${question.case_sensitive ? 'Yes' : 'No'}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Partial Match: ${question.allow_partial_match ? 'Yes' : 'No'}
                                    </span>
                                </div>
                            </div>
                        `;
                    } else {
                        optionsHtml = `
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                ${question.options.map((opt, i) => `
                                    <div class="flex items-center p-3 ${opt.is_correct ? 'bg-green-100 border-2 border-green-300' : 'bg-white border-2 border-gray-200'} rounded-lg">
                                        <span class="inline-flex items-center justify-center w-6 h-6 ${opt.is_correct ? 'bg-green-600 text-white' : 'bg-gray-400 text-white'} rounded-full text-xs font-bold mr-3">
                                            ${String.fromCharCode(65 + i)}
                                        </span>
                                        <span class="text-sm ${opt.is_correct ? 'font-semibold text-green-800' : 'text-gray-700'}">
                                            ${opt.option_text}
                                        </span>
                                        ${opt.is_correct ? `
                                            <svg class="w-5 h-5 text-green-600 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        ` : ''}
                                    </div>
                                `).join('')}
                            </div>
                        `;
                    }

                    return `
                        <div class="question-item bg-gradient-to-r from-gray-50 to-red-50 rounded-2xl border-2 border-gray-200 p-6 mb-6 hover:border-red-200 transition-all duration-300" data-question-id="${question.id}">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center mb-3">
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-red-600 text-white rounded-full text-sm font-bold mr-3">
                                            ${index}
                                        </span>
                                        <h3 class="text-lg font-semibold text-gray-900">${question.question_text}</h3>
                                    </div>
                                    
                                    <div class="flex gap-4 text-sm text-gray-600 mb-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                            </svg>
                                            ${question.points} points
                                        </span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full ${typeColors[question.question_type]}">
                                            ${question.question_type_label}
                                        </span>
                                        ${question.time_limit_seconds ? `
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                ${question.time_limit_seconds}s
                                            </span>
                                        ` : ''}
                                    </div>
                                </div>

                                <button onclick="deleteQuestion(${question.id})" 
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition-all duration-300 hover:shadow-lg">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                            ${optionsHtml}
                        </div>
                    `;
                },

                updateQuestionCount() {
                    const questionCount = document.querySelectorAll('.question-item').length;
                    const countElement = document.getElementById('question-count');
                    if (countElement) {
                        countElement.textContent = `(${questionCount} questions)`;
                    }
                    
                    // Update question numbers
                    document.querySelectorAll('.question-item').forEach((item, index) => {
                        const numberSpan = item.querySelector('.bg-red-600');
                        if (numberSpan) {
                            numberSpan.textContent = index + 1;
                        }
                    });
                },

                showSuccess(message) {
                    const successMsg = document.getElementById('success-message');
                    const successText = document.getElementById('success-text');
                    if (successMsg && successText) {
                        successText.textContent = message;
                        successMsg.classList.remove('hidden');
                        setTimeout(() => {
                            successMsg.classList.add('hidden');
                        }, 5000);
                    }
                },

                showError(message) {
                    const errorMsg = document.getElementById('error-message');
                    const errorText = document.getElementById('error-text');
                    if (errorMsg && errorText) {
                        errorText.textContent = message;
                        errorMsg.classList.remove('hidden');
                        setTimeout(() => {
                            errorMsg.classList.add('hidden');
                        }, 8000);
                    }
                },

                hideMessages() {
                    const successMsg = document.getElementById('success-message');
                    const errorMsg = document.getElementById('error-message');
                    if (successMsg) successMsg.classList.add('hidden');
                    if (errorMsg) errorMsg.classList.add('hidden');
                }
            }))
        })

        // Delete question function
        async function deleteQuestion(questionId) {
            if (!confirm('Are you sure you want to delete this question?')) {
                return;
            }

            try {
                const response = await fetch(`/questions/${questionId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                });

                const result = await response.json();

                if (response.ok && result.success) {
                    // Remove the question from DOM
                    const questionElement = document.querySelector(`[data-question-id="${questionId}"]`);
                    if (questionElement) {
                        questionElement.style.transition = 'all 0.3s ease-out';
                        questionElement.style.transform = 'translateX(-100%)';
                        questionElement.style.opacity = '0';
                        
                        setTimeout(() => {
                            questionElement.remove();
                            updateQuestionNumbers();
                            updateQuestionCount();
                            
                            // Show "no questions" message if no questions left
                            const remainingQuestions = document.querySelectorAll('.question-item');
                            if (remainingQuestions.length === 0) {
                                showNoQuestionsMessage();
                            }
                        }, 300);
                    }

                    showSuccessMessage(result.message || 'Question deleted successfully!');
                } else {
                    showErrorMessage(result.message || 'Failed to delete question. Please try again.');
                }
            } catch (error) {
                console.error('Error deleting question:', error);
                showErrorMessage('An unexpected error occurred. Please try again.');
            }
        }

        function updateQuestionNumbers() {
            document.querySelectorAll('.question-item').forEach((item, index) => {
                const numberSpan = item.querySelector('.bg-red-600');
                if (numberSpan) {
                    numberSpan.textContent = index + 1;
                }
            });
        }

        function updateQuestionCount() {
            const questionCount = document.querySelectorAll('.question-item').length;
            const countElement = document.getElementById('question-count');
            if (countElement) {
                countElement.textContent = `(${questionCount} questions)`;
            }
        }

        function showNoQuestionsMessage() {
            const container = document.getElementById('questions-container');
            if (container) {
                container.innerHTML = `
                    <div id="no-questions-message" class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No questions yet</h3>
                        <p class="text-gray-500">Add your first question using the form above.</p>
                    </div>
                `;
            }
        }

        function showSuccessMessage(message) {
            const successMsg = document.getElementById('success-message');
            const successText = document.getElementById('success-text');
            if (successMsg && successText) {
                successText.textContent = message;
                successMsg.classList.remove('hidden');
                successMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                setTimeout(() => {
                    successMsg.classList.add('hidden');
                }, 5000);
            }
        }

        function showErrorMessage(message) {
            const errorMsg = document.getElementById('error-message');
            const errorText = document.getElementById('error-text');
            if (errorMsg && errorText) {
                errorText.textContent = message;
                errorMsg.classList.remove('hidden');
                errorMsg.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                setTimeout(() => {
                    errorMsg.classList.add('hidden');
                }, 8000);
            }
        }
    </script>

    <!-- CSRF Token Meta Tag (add this to your layout if not already present) -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</x-app-layout>