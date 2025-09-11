<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-100 via-pink-50 to-red-200 py-8">
        <div class="max-w-7xl mx-auto px-4">
            <!-- Header Section -->
<div class="bg-white rounded-3xl shadow-2xl border-4 border-red-200 mb-12 overflow-hidden">
    
    <!-- Header Section -->
    <div class="text-center bg-red-700 p-8">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-500 rounded-full mb-4 shadow-lg animate-bounce mx-auto">
            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h1 class="text-5xl font-black text-white mb-2 drop-shadow-lg">My Learning Materials! 📚</h1>
        <p class="text-xl text-red-100 font-semibold">Find all your awesome study materials here!</p>
    </div>

    <!-- Content Section -->
    <div class="p-6">
        <form method="GET" class="flex items-center gap-4 flex-wrap">
            
            <!-- Back Button -->
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center text-lg font-bold text-red-700 bg-red-50 border-2 border-red-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400 shadow-md hover:bg-red-100 transition-all duration-200 cursor-pointer">
                <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="font-medium">Dashboard</span>
            </a>

            <!-- Dropdown -->
            <select name="subject_id" 
                    onchange="this.form.submit()" 
                    class="text-lg font-bold text-red-700 bg-red-50 border-2 border-red-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-400 shadow-md hover:bg-red-100 transition-all duration-200 cursor-pointer">
                <option value="">🌈 All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                        📖 {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </form>
    </div>

</div>





            <!-- Materials Grid -->
            <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @forelse($materials as $material)
                    <div class="group relative bg-white rounded-3xl p-8 shadow-2xl border-4 border-red-200 hover:border-red-400 transform hover:scale-105 hover:-rotate-1 transition-all duration-300 overflow-hidden">
                        <!-- Decorative Elements -->
                        <div class="absolute -top-2 -right-2 w-16 h-16 bg-red-400 rounded-full opacity-20 group-hover:animate-ping"></div>
                        <div class="absolute -bottom-4 -left-4 w-20 h-20 bg-pink-300 rounded-full opacity-20"></div>
                        
                        <!-- Material Icon -->
                        <div class="flex justify-center mb-6">
                            <div class="w-20 h-20 bg-gradient-to-br from-red-400 to-red-500 rounded-full flex items-center justify-center shadow-lg group-hover:animate-bounce">
                                @php
                                    $extension = strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION));
                                    $icon = match($extension) {
                                        'PDF' => '📄',
                                        'DOC', 'DOCX' => '📝',
                                        'PPT', 'PPTX' => '📊',
                                        'XLS', 'XLSX' => '📈',
                                        'JPG', 'PNG', 'GIF' => '🖼️',
                                        'MP4', 'AVI', 'MOV' => '🎥',
                                        'MP3', 'WAV' => '🎵',
                                        default => '📎'
                                    };
                                @endphp
                                <span class="text-3xl">{{ $icon }}</span>
                            </div>
                        </div>

                        <!-- Material Info -->
                        <div class="text-center relative z-10">
                            <h3 class="text-2xl font-black text-red-700 mb-4 leading-tight">
                                {{ $material->title }}
                            </h3>

                            <!-- Subject Badge -->
                            <div class="inline-flex items-center bg-gradient-to-r from-red-400 to-pink-400 text-white px-4 py-2 rounded-full text-lg font-bold shadow-lg mb-4">
                                <span class="mr-2">🏷️</span>
                                {{ $material->subject->name }}
                            </div>

                            <!-- Description -->
                            @if($material->description)
                                <div class="bg-red-50 rounded-2xl p-4 mb-4 border-2 border-red-200">
                                    <p class="text-lg text-red-600 font-semibold leading-relaxed">
                                        {{ $material->description }}
                                    </p>
                                </div>
                            @endif

                            <!-- Teacher & Date Info -->
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center justify-center bg-gradient-to-r from-pink-100 to-red-100 rounded-2xl p-3 border-2 border-pink-200">
                                    <div class="w-10 h-10 bg-red-400 rounded-full flex items-center justify-center mr-3 shadow-md">
                                        <span class="text-lg">👨‍🏫</span>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-xs font-bold text-red-500 uppercase tracking-wide">Teacher</p>
                                        <p class="text-sm font-black text-red-700">{{ $material->teacher->name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-center bg-gradient-to-r from-red-100 to-pink-100 rounded-2xl p-3 border-2 border-red-200">
                                    <div class="w-10 h-10 bg-pink-400 rounded-full flex items-center justify-center mr-3 shadow-md">
                                        <span class="text-lg">📅</span>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-xs font-bold text-red-500 uppercase tracking-wide">Uploaded</p>
                                        <p class="text-sm font-black text-red-700">{{ $material->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Badge & File Type Info -->
                            <div class="space-y-3 mb-6">
                                <!-- Activity Badge -->
                                @if($material->is_activity)
                                    <div class="bg-gradient-to-r from-orange-400 to-yellow-400 rounded-2xl p-3 border-2 border-orange-300 shadow-lg animate-pulse">
                                        <div class="flex items-center justify-center">
                                            <span class="text-2xl mr-2">⭐</span>
                                            <span class="text-lg font-black text-white drop-shadow-md">SPECIAL ACTIVITY!</span>
                                            <span class="text-2xl ml-2">⭐</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Due Date for Activities -->
                                @if($material->is_activity && $material->due_date)
                                    <div class="bg-gradient-to-r from-red-400 to-pink-400 rounded-2xl p-3 border-2 border-red-300 shadow-lg">
                                        <div class="flex items-center justify-center">
                                            <span class="text-xl mr-2">⏰</span>
                                            <div class="text-center">
                                                <p class="text-xs font-bold text-white uppercase tracking-wide">Due Date</p>
                                                <p class="text-lg font-black text-white">{{ $material->due_date->format('M d, Y g:i A') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- File Type Info -->
                                <div class="bg-gradient-to-r from-red-200 to-pink-200 rounded-2xl p-3 border-2 border-red-300">
                                    <div class="flex items-center justify-center">
                                        <svg class="w-6 h-6 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <span class="text-lg font-black text-red-700">{{ $extension }} FILE</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submission Status for Activities -->
                            @if($material->is_activity)
                                @php
                                    $submission = $material->submissions->first();
                                @endphp
                                <div class="bg-gradient-to-r from-purple-100 to-blue-100 rounded-2xl p-4 mb-6 border-2 border-purple-300 shadow-lg">
                                    @if($submission)
                                        <div class="text-center mb-3">
                                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full mb-2 shadow-lg">
                                                <span class="text-xl">✅</span>
                                            </div>
                                            <h4 class="text-lg font-black text-purple-700">Your Submission</h4>
                                        </div>
                                        
                                        <div class="space-y-2">
                                            <!-- Status Badge -->
                                            <div class="text-center">
                                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold shadow-lg
                                                    {{ $submission->status === 'late' ? 'bg-yellow-400 text-yellow-900' : 
                                                       ($submission->status === 'reviewed' ? 'bg-green-400 text-green-900' : 'bg-blue-400 text-blue-900') }}">
                                                    {{ $submission->status === 'late' ? '⚠️ LATE' : ($submission->status === 'reviewed' ? '✨ REVIEWED' : '📝 SUBMITTED') }}
                                                </span>
                                            </div>
                                            
                                            <!-- Submitted Date -->
                                            <p class="text-center text-sm font-bold text-purple-600">
                                                Submitted: {{ $submission->submitted_at->format('M d, Y g:i A') }}
                                            </p>
                                            
                                            <!-- Grade -->
                                            @if($submission->grade)
                                                <div class="text-center bg-green-200 rounded-xl p-2 border-2 border-green-300">
                                                    <p class="text-lg font-black text-green-700">
                                                        🏆 Grade: {{ $submission->grade }}
                                                    </p>
                                                </div>
                                            @endif
                                            
                                            <!-- Teacher Feedback -->
                                            @if($submission->teacher_feedback)
                                                <div class="bg-blue-200 rounded-xl p-3 border-2 border-blue-300">
                                                    <p class="text-sm font-bold text-blue-600 mb-1">💬 Teacher Says:</p>
                                                    <p class="text-sm font-semibold text-blue-700">{{ $submission->teacher_feedback }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-r from-red-400 to-orange-400 rounded-full mb-2 shadow-lg animate-pulse">
                                                <span class="text-xl">📋</span>
                                            </div>
                                            <h4 class="text-lg font-black text-red-600">Not Submitted Yet!</h4>
                                            <p class="text-sm font-semibold text-red-500">Don't forget to submit your work!</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-4">
                            <!-- Download Button -->
                            <a href="{{ route('materials.student.download', $material) }}" 
                               class="group/btn w-full inline-flex items-center justify-center px-8 py-6 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-2xl font-black rounded-3xl shadow-2xl transform hover:scale-110 hover:-rotate-1 transition-all duration-300 border-4 border-green-400 hover:border-green-300">
                                <svg class="w-10 h-10 mr-4 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="drop-shadow-lg">DOWNLOAD!</span>
                            </a>

                            <!-- Activity Submission Buttons -->
                            @if($material->is_activity)
                                @php
                                    $submission = $material->submissions->first();
                                @endphp
                                @if($submission)
                                    <!-- View Submission Button -->
                                    <a href="{{ route('submissions.download', $submission) }}" 
                                       class="group/btn w-full inline-flex items-center justify-center px-8 py-6 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white text-2xl font-black rounded-3xl shadow-2xl transform hover:scale-110 hover:rotate-1 transition-all duration-300 border-4 border-blue-400 hover:border-blue-300">
                                        <svg class="w-10 h-10 mr-4 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span class="drop-shadow-lg">VIEW MY WORK!</span>
                                    </a>
                                @else
                                    <!-- Submit Button or Past Due -->
                                    @if($material->due_date && now() > $material->due_date)
                                        <div class="w-full inline-flex items-center justify-center px-8 py-6 bg-gray-400 text-white text-2xl font-black rounded-3xl shadow-lg border-4 border-gray-300 cursor-not-allowed">
                                            <svg class="w-10 h-10 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="drop-shadow-lg">TIME'S UP! ⏰</span>
                                        </div>
                                    @else
                                        <a href="{{ route('materials.student.submit', $material) }}" 
                                           class="group/btn w-full inline-flex items-center justify-center px-8 py-6 bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white text-2xl font-black rounded-3xl shadow-2xl transform hover:scale-110 hover:rotate-1 transition-all duration-300 border-4 border-orange-400 hover:border-orange-300 animate-pulse">
                                            <svg class="w-10 h-10 mr-4 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <span class="drop-shadow-lg">SUBMIT NOW!</span>
                                        </a>
                                    @endif
                                @endif
                            @endif
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-16">
                        <div class="inline-flex items-center justify-center w-32 h-32 bg-red-200 rounded-full mb-8 shadow-lg">
                            <span class="text-6xl">📚</span>
                        </div>
                        <h3 class="text-4xl font-black text-red-600 mb-4">No Materials Yet! 🤔</h3>
                        <div class="max-w-md mx-auto">
                            @if($selectedSubject)
                                <p class="text-xl text-red-500 font-semibold mb-8 leading-relaxed">
                                    No materials found for this subject. Try selecting "All Subjects" above! 
                                </p>
                            @else
                                <p class="text-xl text-red-500 font-semibold mb-8 leading-relaxed">
                                    Your teachers haven't uploaded any materials yet. Check back soon for awesome learning resources!
                                </p>
                            @endif
                        </div>
                        <div class="animate-bounce">
                            <span class="text-6xl">⬆️</span>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Fun Footer -->
            <div class="text-center mt-16 py-8">
                <div class="inline-flex items-center space-x-4 text-2xl">
                    <span class="animate-pulse">📖</span>
                    <span class="text-xl font-black text-red-600">Happy learning, superstar!</span>
                    <span class="animate-pulse">⭐</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for extra interactivity -->
    <style>
        @keyframes wiggle {
            0%, 7% { transform: rotateZ(0); }
            15% { transform: rotateZ(-15deg); }
            20% { transform: rotateZ(10deg); }
            25% { transform: rotateZ(-10deg); }
            30% { transform: rotateZ(6deg); }
            35% { transform: rotateZ(-4deg); }
            40%, 100% { transform: rotateZ(0); }
        }

        .group:hover .animate-wiggle {
            animation: wiggle 0.8s ease-in-out;
        }

        /* Enhanced hover effects */
        .group:hover {
            box-shadow: 0 25px 50px -12px rgba(239, 68, 68, 0.5);
        }

        /* Select dropdown styling */
        select option {
            padding: 10px;
        }

        /* Smooth transitions */
        * {
            transition: all 0.2s ease-in-out;
        }

        /* Custom download button glow effect */
        .group\/btn:hover {
            box-shadow: 0 20px 40px -12px rgba(34, 197, 94, 0.6);
        }
    </style>
</x-app-layout>