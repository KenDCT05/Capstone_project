<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-red-100 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Subject Header -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-16 h-16 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-6">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-3xl font-bold text-white mb-2">{{ $subject->name }}</h2>
                                <p class="text-red-100 text-lg">Subject Details & Management</p>
                            </div>
                        </div>
                        
                        <!-- Back Button -->
                        <a href="{{ route('subjects.index') }}" class="inline-flex items-center px-4 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 text-white font-medium rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Subjects
                        </a>
                    </div>
                </div>

                <!-- Subject Description -->
                @if($subject->description)
                    <div class="px-8 py-6 bg-gradient-to-r from-red-50 to-red-100 border-b border-red-200">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-red-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div>
                                <h4 class="font-semibold text-red-800 mb-1">Description</h4>
                                <p class="text-red-700 leading-relaxed">{{ $subject->description }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Subject Stats -->
                <div class="px-8 py-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl p-4 text-center">
                            <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="text-2xl font-bold text-red-800">{{ $subject->students->count() }}</div>
                            <div class="text-sm text-red-600">Enrolled Students</div>
                        </div>

                        <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl p-4 text-center">
                            <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="text-2xl font-bold text-red-800 font-mono">{{ $subject->join_code }}</div>
                            <div class="text-sm text-red-600">Join Code</div>
                        </div>

                        <div class="bg-gradient-to-br from-red-100 to-red-200 rounded-xl p-4 text-center">
                            <div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="text-2xl font-bold text-red-800">Active</div>
                            <div class="text-sm text-red-600">Status</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Section -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-700 to-red-800 px-8 py-4">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Enrolled Students
                        <span class="ml-3 px-3 py-1 bg-white bg-opacity-20 rounded-full text-sm font-medium">
                            {{ $subject->students->count() }}
                        </span>
                    </h3>
                </div>

                <div class="p-8">
                    @forelse ($subject->students as $student)
                        <div class="group bg-gradient-to-r from-red-50 to-red-100 border border-red-200 rounded-xl p-6 mb-4 hover:shadow-lg transition-all duration-300 hover:border-red-300">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <!-- Student Avatar -->
                                    <div class="w-12 h-12 bg-gradient-to-br from-red-600 to-red-700 rounded-full flex items-center justify-center shadow-lg">
                                        <span class="text-white font-bold text-lg">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    
                                    <!-- Student Info -->
                                    <div>
                                        <h4 class="text-lg font-semibold text-red-900">{{ $student->name }}</h4>
                                        <p class="text-red-600 flex items-center mt-1">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $student->email }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('subjects.removeStudent', [$subject->id, $student->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this student from the subject?');" class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg shadow-sm transition-all duration-200 transform hover:scale-105">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM9 3a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-semibold text-red-800 mb-2">No Students Enrolled</h4>
                            <p class="text-red-600 mb-6 max-w-md mx-auto">
                                Students can join this subject using the join code: 
                                <span class="font-mono font-bold bg-red-100 px-2 py-1 rounded">{{ $subject->join_code }}</span>
                            </p>
                            <div class="bg-gradient-to-r from-red-100 to-red-200 rounded-xl p-6 max-w-lg mx-auto">
                                <h5 class="font-semibold text-red-800 mb-3">How students can join:</h5>
                                <ul class="text-sm text-red-700 space-y-2 text-left">
                                    <li class="flex items-center">
                                        <span class="w-6 h-6 bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">1</span>
                                        Share the join code with your students
                                    </li>
                                    <li class="flex items-center">
                                        <span class="w-6 h-6 bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">2</span>
                                        Students enter the code in their dashboard
                                    </li>
                                    <li class="flex items-center">
                                        <span class="w-6 h-6 bg-red-600 text-white rounded-full flex items-center justify-center text-xs font-bold mr-3">3</span>
                                        They'll automatically be enrolled
                                    </li>
                                </ul>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>