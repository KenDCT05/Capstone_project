<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100 p-6">
        <div class="max-w-2xl mx-auto">
            
            <div class="bg-white rounded-xl shadow-xl border border-red-100 overflow-hidden">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6 relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-black/10 to-black/5"></div>
                    <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                    
                    <div class="relative flex items-center">
                        <a href="{{ route('admin.sections') }}" 
                           class="group mr-4 w-10 h-10 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center border border-white/30 hover:bg-white/30 transition-all duration-300">
                            <svg class="w-5 h-5 text-white group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                        </a>
                        <div>
                            <h2 class="text-3xl font-bold text-white flex items-center">
                                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Create New Section
                            </h2>
                            <p class="text-white/80 mt-1 font-medium">Add a section for student grouping</p>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-8">
                    <form action="{{ route('admin.sections.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Year Level Dropdown -->
                        <div class="space-y-2">
                            <label for="year_level" class="flex items-center text-gray-800 font-semibold text-base">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                Grade Level
                            </label>
                            <select name="year_level" 
                                    id="year_level"
                                    required
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('year_level') border-red-500 @enderror">
                                <option value="">Select Grade Level</option>
                                <option value="1" {{ old('year_level') == 1 ? 'selected' : '' }}>Grade 1</option>
                                <option value="2" {{ old('year_level') == 2 ? 'selected' : '' }}>Grade 2</option>
                                <option value="3" {{ old('year_level') == 3 ? 'selected' : '' }}>Grade 3</option>
                                <option value="4" {{ old('year_level') == 4 ? 'selected' : '' }}>Grade 4</option>
                                <option value="5" {{ old('year_level') == 5 ? 'selected' : '' }}>Grade 5</option>
                                <option value="6" {{ old('year_level') == 6 ? 'selected' : '' }}>Grade 6</option>
                                <option value="7" {{ old('year_level') == 7 ? 'selected' : '' }}>Grade 7</option>

                            </select>
                            @error('year_level')
                                <p class="text-red-600 text-sm mt-2 flex items-center font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Section Name -->
                        <div class="space-y-2">
                            <label for="name" class="flex items-center text-gray-800 font-semibold text-base">
                                <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                                Section Name
                            </label>
                            <input type="text" 
                                   name="name" 
                                   id="name"
                                   value="{{ old('name') }}" 
                                   required
                                   class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('name') border-red-500 @enderror"
                                   placeholder="e.g. Honesty, Integrity, Saint Peter">
                            @error('name')
                                <p class="text-red-600 text-sm mt-2 flex items-center font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit"
                                    class="group flex items-center justify-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-8 py-4 rounded-xl font-semibold text-base transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Section
                                <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                            <a href="{{ route('admin.sections') }}"
                               class="group flex items-center justify-center bg-white hover:bg-gray-50 text-red-700 px-8 py-4 rounded-xl font-semibold text-base border-2 border-red-200 hover:border-red-300 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <svg class="w-4 h-4 mr-3 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Info Section -->
                <div class="bg-gradient-to-r from-red-50 to-rose-50 px-8 py-6 border-t border-red-100">
                    <div class="flex items-start space-x-4">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-sm">
                            <p class="font-bold text-red-900 mb-2">Tips for Creating Sections:</p>
                            <ul class="space-y-1.5 text-red-700 font-medium">
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Select the grade level first, then enter section name
                                </li>
                                <li class="flex items-start">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Each section is tied to a specific grade level
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>