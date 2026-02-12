<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-rose-50">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Navigation & Header -->
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                        Activity Submissions
                    </h1>
                    <p class="text-red-100 mt-2">{{ $material->title }}</p>
                </div>
                
                <div class="px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4 text-sm text-gray-600">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"/>
                                </svg>
                                <span class="font-medium">Subject: {{ $material->subject->name }}</span>
                            </div>
                            @if($material->due_date)
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-medium">Due: {{ $material->due_date->format('M d, Y g:i A') }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('materials.teacher.index') }}" 
                           class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 via-red-700 to-rose-700 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span class="font-medium">Back to Materials</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Updated Statistics Panel -->
            <div class="bg-white/70 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-xl shadow-red-100/25 p-6 mb-8 relative overflow-hidden">
                <!-- Decorative Background -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-400/10 to-rose-400/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-red-300/10 to-pink-300/10 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="relative">
                    <h3 class="text-xl font-bold text-red-800 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Submission Statistics
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-2xl text-white shadow-xl shadow-blue-500/25 hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-3xl font-black">{{ $submissions->count() }}</div>
                                <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div class="text-blue-100 font-semibold">Total Submissions</div>
                        </div>
                        
                        <!-- ✅ UPDATED: On Time count includes both reviewed and unreviewed -->
                        <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-2xl text-white shadow-xl shadow-green-500/25 hover:shadow-2xl hover:shadow-green-500/40 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-3xl font-black">{{ $submissions->where('is_late', false)->count() }}</div>
                                <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div class="text-green-100 font-semibold">On Time</div>
                        </div>
                        
                        <!-- ✅ UPDATED: Late count includes both reviewed and unreviewed -->
                        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 p-6 rounded-2xl text-white shadow-xl shadow-yellow-500/25 hover:shadow-2xl hover:shadow-yellow-500/40 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-3xl font-black">{{ $submissions->where('is_late', true)->count() }}</div>
                                <svg class="w-8 h-8 text-yellow-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="text-yellow-100 font-semibold">Late Submissions</div>
                        </div>
                        
                        <div class="bg-gradient-to-br from-red-500 to-rose-600 p-6 rounded-2xl text-white shadow-xl shadow-red-500/25 hover:shadow-2xl hover:shadow-red-500/40 transition-all duration-300 transform hover:scale-105">
                            <div class="flex items-center justify-between mb-2">
                                <div class="text-3xl font-black">{{ $enrolledStudents->count() }}</div>
                                <svg class="w-8 h-8 text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </div>
                            <div class="text-red-100 font-semibold">Not Submitted</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submissions Table -->
            @if($submissions->count() > 0)
                <div class="bg-white/80 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-2xl shadow-red-100/20 overflow-hidden mb-8">
                    <!-- Enhanced Header -->
                    <div class="bg-gradient-to-r from-red-500 via-red-600 to-rose-600 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/5"></div>
                        <div class="absolute top-0 left-0 w-full h-full opacity-10">
                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <defs>
                                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                        <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                                    </pattern>
                                </defs>
                                <rect width="100" height="100" fill="url(#grid)"/>
                            </svg>
                        </div>
                        <div class="relative px-8 py-6">
                            <div class="grid grid-cols-6 gap-6 text-white font-bold text-sm uppercase tracking-wider">
                                <div class="col-span-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span>Student Details</span>
                                </div>
                                <div>Status</div>
                                <div>Submitted At</div>
                                <div>Grade</div>
                                <div>Actions</div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Submissions List -->
                    <div class="divide-y divide-red-50">
                        @foreach($submissions as $submission)
                            <div class="group grid grid-cols-6 gap-6 p-8 hover:bg-gradient-to-r hover:from-red-25 hover:to-rose-25 transition-all duration-300 items-center relative overflow-hidden">
                                <!-- Hover Effect -->
                                <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-red-400 to-red-600 transform scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-top"></div>
                                
                                <!-- Student Details -->
                                <div class="col-span-2">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div class="w-14 h-14 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-bold text-gray-900 text-lg leading-tight mb-1 group-hover:text-red-700 transition-colors">
                                                {{ $submission->student->name }}
                                            </h3>
                                            <div class="text-sm text-gray-500 font-medium">{{ $submission->student->email }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ✅ UPDATED Status with Consistent Vertical Layout -->
                                <div>
                                    <div class="flex flex-col space-y-2 items-start">
                                        @if($submission->status === 'late_reviewed')
                                            <!-- Late Reviewed: Show Late first, then Reviewed -->
                                            <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-100 to-orange-100 text-orange-800 text-xs font-bold rounded-full border border-orange-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Late
                                            </div>
                                            <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 text-xs font-bold rounded-full border border-green-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Reviewed
                                            </div>
                                        @elseif($submission->status === 'reviewed')
                                            <!-- On Time Reviewed: Show On Time first, then Reviewed -->
                                            <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 text-xs font-bold rounded-full border border-blue-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                On Time
                                            </div>
                                            <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 text-xs font-bold rounded-full border border-green-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Reviewed
                                            </div>
                                        @elseif($submission->status === 'late')
                                            <!-- Late Submission: Show Late only -->
                                            <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-yellow-100 to-orange-100 text-orange-800 text-xs font-bold rounded-full border border-orange-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Late
                                            </div>
                                        @else
                                            <!-- On Time Submission: Show On Time only -->
                                            <div class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 text-xs font-bold rounded-full border border-blue-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                On Time
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Submitted At -->
                                <div>
                                    <div class="bg-white/80 border border-gray-100 rounded-xl p-3 shadow-sm">
                                        <div class="font-bold text-gray-800 text-sm">{{ $submission->submitted_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-600 font-medium">{{ $submission->submitted_at->format('g:i A') }}</div>
                                    </div>
                                </div>

                                <!-- Grade -->
                                <div>
                                    @if($submission->grade)
                                        <div class="text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-purple-400 to-purple-500 text-white font-black text-lg rounded-2xl shadow-lg">
                                                {{ $submission->grade }}
                                            </div>
                                            <div class="text-xs text-purple-600 font-semibold mt-1">grade</div>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-400 text-white rounded-2xl">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div class="text-xs text-gray-500 font-medium mt-1">ungraded</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('submissions.download', $submission) }}" 
                                           class="group/btn inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <svg class="w-3.5 h-3.5 mr-1.5 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Download
                                        </a>
<a href="{{ route('submissions.view', $submission) }}" 
   class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
    </svg>
    View
</a>
                                        
                                        <button onclick="openFeedbackModal({{ $submission->id }}, '{{ $submission->student->name }}', '{{ $submission->teacher_feedback }}', '{{ $submission->grade }}')"
                                                class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-purple-500 to-indigo-500 text-white text-xs font-bold rounded-xl hover:from-purple-600 hover:to-indigo-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Grade
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Students Who Haven't Submitted -->
            @if($enrolledStudents->count() > 0)
                <div class="bg-white/80 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-2xl shadow-red-100/20 overflow-hidden">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-gray-600 via-gray-700 to-gray-800 relative overflow-hidden">
                        <div class="absolute inset-0 bg-black/5"></div>
                        <div class="relative px-8 py-6">
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                                Students Who Haven't Submitted
                            </h3>
                            <p class="text-gray-200 mt-1">{{ $enrolledStudents->count() }} students pending</p>
                        </div>
                    </div>
                    
                    <!-- Students List -->
                    <div class="divide-y divide-gray-100">
                        @foreach($enrolledStudents as $student)
                            <div class="group p-6 hover:bg-gradient-to-r hover:from-gray-25 hover:to-slate-25 transition-all duration-300 relative overflow-hidden">
                                <!-- Hover Effect -->
                                <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-gray-400 to-gray-600 transform scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-top"></div>
                                
                                <div class="flex items-center space-x-4 ml-2">
                                    <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center shadow-md group-hover:shadow-lg transition-shadow duration-300">
                                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="font-bold text-gray-900 text-lg group-hover:text-gray-700 transition-colors">
                                            {{ $student->name }}
                                        </h4>
                                        <div class="text-sm text-gray-500 font-medium">{{ $student->email }}</div>
                                    </div>
                                    <div class="flex items-center space-x-2 text-red-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span class="text-sm font-semibold">Not Submitted</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Feedback Modal -->
    <div id="feedbackModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-0 border-0 w-full max-w-md">
            <div class="bg-white/95 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-2xl shadow-red-500/20 overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-red-500 to-rose-600 px-8 py-6">
                    <h3 class="text-2xl font-bold text-white flex items-center" id="modalTitle">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Provide Feedback
                    </h3>
                    <p class="text-red-100 mt-1">Grade and provide feedback for this submission</p>
                </div>
                
                <!-- Modal Body -->
                <div class="p-8">
                    <form id="feedbackForm" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="mb-6">
                            <label class=" text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Grade (0-100)
                            </label>
                            <input type="number" name="grade" id="gradeInput" min="0" max="100" step="0.1"
                                   class="w-full bg-white/90 border-2 border-red-100 rounded-2xl px-6 py-4 text-red-800 font-semibold shadow-lg focus:ring-4 focus:ring-red-200/50 focus:border-red-300 transition-all duration-300"
                                   placeholder="Enter grade (0-100)">
                        </div>
                        
                        <div class="mb-8">
                            <label class=" text-sm font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2h-1.5l-4 4z"/>
                                </svg>
                                Feedback & Comments
                            </label>
                            <textarea name="feedback" id="feedbackInput" rows="4" 
                                      class="w-full bg-white/90 border-2 border-red-100 rounded-2xl px-6 py-4 text-red-800 font-medium shadow-lg focus:ring-4 focus:ring-red-200/50 focus:border-red-300 transition-all duration-300 resize-none"
                                      placeholder="Provide detailed feedback for the student..."></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="closeFeedbackModal()"
                                    class="px-8 py-4 bg-gradient-to-r from-gray-400 to-gray-500 hover:from-gray-500 hover:to-gray-600 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Save Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openFeedbackModal(submissionId, studentName, currentFeedback, currentGrade) {
            document.getElementById('modalTitle').innerHTML = `
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Feedback for ${studentName}
            `;
            document.getElementById('feedbackForm').action = `/submissions/${submissionId}/feedback`;
            document.getElementById('gradeInput').value = currentGrade || '';
            document.getElementById('feedbackInput').value = currentFeedback || '';
            document.getElementById('feedbackModal').classList.remove('hidden');
            
            // Add smooth fade-in animation
            setTimeout(() => {
                document.getElementById('feedbackModal').style.opacity = '1';
            }, 10);
        }

        function closeFeedbackModal() {
            const modal = document.getElementById('feedbackModal');
            modal.style.opacity = '0';
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.style.opacity = '';
            }, 200);
        }

        // Close modal when clicking outside
        document.getElementById('feedbackModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeFeedbackModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFeedbackModal();
            }
        });
    </script>
</x-app-layout>