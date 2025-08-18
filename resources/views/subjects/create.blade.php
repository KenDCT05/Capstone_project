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
                    <form action="{{ route('subjects.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Subject Name Field -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-red-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Subject Name
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    name="name" 
                                    class="w-full border-2 border-red-200 rounded-xl px-4 py-3 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-200 bg-red-50 focus:bg-white" 
                                    placeholder="Enter subject name (e.g., Mathematics 101)"
                                    required
                                >
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Description Field -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-red-800 mb-2 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                </svg>
                                Description
                                <span class="text-red-400 text-xs ml-2">(Optional)</span>
                            </label>
                            <div class="relative">
                                <textarea 
                                    name="description" 
                                    rows="4" 
                                    class="w-full border-2 border-red-200 rounded-xl px-4 py-3 text-red-900 placeholder-red-400 focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-200 bg-red-50 focus:bg-white resize-none"
                                    placeholder="Provide a brief description of the subject, its objectives, or any relevant information..."
                                ></textarea>
                                <div class="absolute top-3 right-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-red-100">
                            <a href="{{ route('subjects.index') }}" class="inline-flex items-center px-4 py-2 text-red-600 hover:text-red-800 font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Subjects
                            </a>
                            
                            <button 
                                type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 focus:ring-4 focus:ring-red-200"
                            >
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Subject
                            </button>
                        </div>
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
</x-app-layout>