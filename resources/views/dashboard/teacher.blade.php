<x-app-layout>
    @if (session('success'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-init="setTimeout(() => show = false, 5000)"
             class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif
    
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100">
        <!-- Enhanced Header Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 p-4">
            <div class="bg-white rounded-xl shadow-xl border border-red-100 mb-6 overflow-hidden">
                <!-- Main Header -->
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-6 py-8 relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 bg-gradient-to-r from-black/10 to-black/5"></div>
                    <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                    
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5">
                                <h1 class="text-3xl font-bold text-white mb-1">Teaching Dashboard</h1>
                                <p class="text-white/80 text-sm font-medium">Empowering education, one lesson at a time</p>
                            </div>
                        </div>
                        
                        <!-- Quick Info Badge -->
                        <div class="hidden md:flex items-center space-x-4">
                            <div class="bg-white/20 backdrop-blur-sm border border-white/30 rounded-lg px-4 py-2">
                                <div class="flex items-center text-white">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Quick Navigation Pills -->
                <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
   
                        
                        <!-- Welcome Message -->
                        <div class="hidden sm:block text-xs text-gray-500">
                            Welcome back, <span class="font-semibold text-gray-700">{{ Auth::user()->name ?? 'Teacher' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Subject Count -->
                <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Subjects Created</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $subjectCount }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Active Courses
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Student Count -->
                <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-rose-100 to-rose-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-semibold text-rose-600 uppercase tracking-wider">Enrolled Students</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $studentCount }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                    Total Enrollment
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Week -->
                <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-pink-200 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Current Week</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ now()->format('M d') }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    {{ now()->format('Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Section -->
            <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <div class="w-6 h-6 bg-gradient-to-r from-red-500 to-red-600 rounded-lg mr-3"></div>
                    Quick Actions
                </h2>

                <!-- Improved and Reordered Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">

                    <!-- 1. Manage Courses (Foundation - comes first) -->
                    <a href="{{ route('subjects.index') }}" 
                       class="group bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-5 
                              hover:from-blue-100 hover:to-blue-200 transition-all duration-300 
                              cursor-pointer border-2 border-transparent hover:border-blue-300">
                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mb-3 
                                    group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1 text-sm">Manage Courses</h3>
                        <p class="text-xs text-gray-600">Create subjects & enroll students</p>
                    </a>

                    <!-- 2. Upload Materials (Content Creation) -->
                    <a href="{{ route('materials.teacher.index') }}" 
                       class="group bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-lg p-5 
                              hover:from-emerald-100 hover:to-emerald-200 transition-all duration-300 
                              cursor-pointer border-2 border-transparent hover:border-emerald-300">
                        <div class="w-8 h-8 bg-emerald-600 rounded-lg flex items-center justify-center mb-3 
                                    group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1 text-sm">Upload Materials</h3>
                        <p class="text-xs text-gray-600">Share resources & assignments</p>
                    </a>

                    <!-- 3. Create Quizzes (Assessment Creation) -->
                    <a href="{{ route('quizzes.index') }}"  
                       class="group bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg p-5 
                              hover:from-purple-100 hover:to-purple-200 transition-all duration-300 
                              cursor-pointer border-2 border-transparent hover:border-purple-300">
                        <div class="w-8 h-8 bg-purple-600 rounded-lg flex items-center justify-center mb-3 
                                    group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1 text-sm">Create Quizzes</h3>
                        <p class="text-xs text-gray-600">Build interactive assessments</p>
                    </a>

                    <!-- 4. Grade Book (Evaluation) -->
                    <a href="{{ route('gradebook.teacher') }}" 
                       class="group bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-5 
                              hover:from-orange-100 hover:to-orange-200 transition-all duration-300 
                              cursor-pointer border-2 border-transparent hover:border-orange-300">
                        <div class="w-8 h-8 bg-orange-600 rounded-lg flex items-center justify-center mb-3 
                                    group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1 text-sm">Grade Book</h3>
                        <p class="text-xs text-gray-600">Evaluate & record grades</p>
                    </a>

                    <!-- 5. Analytics (Insights) -->
                    <a href="{{ route('analytics.dashboard') }}" 
                       class="group bg-gradient-to-br from-red-50 to-pink-100 rounded-lg p-5 
                              hover:from-red-100 hover:to-pink-200 transition-all duration-300 
                              cursor-pointer border-2 border-transparent hover:border-red-300">
                        <div class="w-8 h-8 bg-red-600 rounded-lg flex items-center justify-center mb-3 
                                    group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1 text-sm">Analytics</h3>
                        <p class="text-xs text-gray-600">Track student progress & insights</p>
                    </a>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>