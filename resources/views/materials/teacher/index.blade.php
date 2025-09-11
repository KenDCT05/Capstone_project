<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 via-white to-rose-50">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <!-- Navigation & Header -->

                        <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center">
                                <svg class="w-10 h-10 mr-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                                </svg>
                                
                        My Materials
                    </h1>
                    <p class="text-red-100 mt-2">Manage teaching resources & activities</p>
                </div>
                
                <div class="px-8 py-6">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a> 
                </div>
            </div>

            <!-- Modern Controls Panel -->
            <div class="bg-white/70 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-xl shadow-red-100/25 p-6 mb-8 relative overflow-hidden">
                <!-- Decorative Background -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-400/10 to-rose-400/10 rounded-full -translate-y-16 translate-x-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-red-300/10 to-pink-300/10 rounded-full translate-y-12 -translate-x-12"></div>
                
                <div class="relative flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <!-- Filter Section -->
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                        <form method="GET" class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-red-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                                    </svg>
                                </div>
                                <label class="text-red-700 font-semibold">Filter by Subject</label>
                            </div>
                            <select name="subject_id" 
                                    onchange="this.form.submit()" 
                                    class="bg-white/90 border-0 rounded-2xl px-6 py-3 text-red-800 shadow-lg focus:ring-4 focus:ring-red-200/50 transition-all duration-300 min-w-[180px] font-medium">
                                <option value="">All Subjects</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}" {{ $selectedSubject == $subject->id ? 'selected' : '' }}>
                                        {{ $subject->name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-3">
                        <!-- Upload Button -->
                        <a href="{{ route('materials.teacher.create') }}" 
                           class="group relative inline-flex items-center space-x-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-8 py-3.5 rounded-2xl font-semibold shadow-xl shadow-red-500/25 hover:shadow-2xl hover:shadow-red-500/40 hover:from-red-600 hover:to-red-700 transform hover:scale-105 transition-all duration-300 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-red-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-5 h-5 relative z-10 transform group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="relative z-10">Upload Material</span>
                            <div class="absolute top-0 left-0 w-full h-0.5 bg-white/30"></div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Materials Grid/List -->
            @if($materials->count())
                <div class="bg-white/80 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-2xl shadow-red-100/20 overflow-hidden">
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
                            <div class="grid grid-cols-7 gap-6 text-white font-bold text-sm uppercase tracking-wider">
                                <div class="col-span-2 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>Material Details</span>
                                </div>
                                <div>Subject</div>
                                <div>Type</div>
                                <div>Due Date</div>
                                <div>Status</div>
                                <div>Actions</div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Materials List -->
                    <div class="divide-y divide-red-50">
                        @foreach ($materials as $material)
                            <div class="group grid grid-cols-7 gap-6 p-8 hover:bg-gradient-to-r hover:from-red-25 hover:to-rose-25 transition-all duration-300 items-center relative overflow-hidden">
                                <!-- Hover Effect -->
                                <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-red-400 to-red-600 transform scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-top"></div>
                                
                                <!-- Material Details -->
                                <div class="col-span-2">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <div class="w-14 h-14 bg-gradient-to-br from-red-100 to-red-200 rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-shadow duration-300">
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            @if($material->is_activity)
                                                <div class="absolute -top-1 -right-1 w-5 h-5 bg-orange-400 border-2 border-white rounded-full flex items-center justify-center">
                                                    <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <h3 class="font-bold text-gray-900 text-lg leading-tight mb-1 truncate group-hover:text-red-700 transition-colors">
                                                {{ $material->title }}
                                            </h3>
                                            <div class="flex items-center space-x-3">
                                                <span class="inline-flex items-center px-2.5 py-1 bg-gradient-to-r from-red-100 to-red-200 text-red-700 text-xs font-bold rounded-lg">
                                                    {{ strtoupper(pathinfo($material->file_path, PATHINFO_EXTENSION)) }}
                                                </span>
                                                <span class="text-xs text-gray-500 font-medium">{{ $material->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subject -->
                                <div>
                                    <span class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 text-sm font-bold rounded-full border border-blue-200">
                                        {{ $material->subject->name }}
                                    </span>
                                </div>

                                <!-- Type -->
                                <div>
                                    @if($material->is_activity)
                                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-100 to-amber-100 text-orange-800 text-sm font-bold rounded-full border border-orange-200 shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Activity
                                        </div>
                                    @else
                                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-gray-100 to-slate-100 text-gray-700 text-sm font-semibold rounded-full border border-gray-200">
                                            <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Material
                                        </div>
                                    @endif
                                </div>

                                <!-- Due Date -->
                                <div>
                                    @if($material->is_activity && $material->due_date)
                                        <div class="bg-white/80 border border-red-100 rounded-xl p-3 shadow-sm">
                                            <div class="font-bold text-red-800 text-sm">{{ $material->due_date->format('M d, Y') }}</div>
                                            <div class="text-xs text-red-600 font-medium">{{ $material->due_date->format('g:i A') }}</div>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-lg">—</span>
                                    @endif
                                </div>

                                <!-- Status/Submissions -->
                                <div>
                                    @if($material->is_activity)
                                        <div class="text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-green-400 to-emerald-500 text-white font-black text-lg rounded-2xl shadow-lg">
                                                {{ $material->submissions_count ?? 0 }}
                                            </div>
                                            <div class="text-xs text-green-600 font-semibold mt-1">submissions</div>
                                        </div>
                                    @else
                                        <div class="text-center">
                                            <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-gray-400 to-gray-500 text-white rounded-2xl">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-xs text-gray-500 font-medium mt-1">resource</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('materials.teacher.download', $material) }}" 
                                           class="group/btn inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-500 text-white text-xs font-bold rounded-xl hover:from-green-600 hover:to-emerald-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <svg class="w-3.5 h-3.5 mr-1.5 group-hover/btn:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Download
                                        </a>
                                        
                                        @if($material->is_activity)
                                            <a href="{{ route('materials.submissions', $material) }}" 
                                               class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs font-bold rounded-xl hover:from-blue-600 hover:to-indigo-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                        @endif
                                        
                                        <a href="{{ route('materials.teacher.edit', $material) }}" 
                                           class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold rounded-xl hover:from-amber-600 hover:to-orange-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('materials.teacher.destroy', $material) }}" 
                                              method="POST" 
                                              class="inline-block" 
                                              onsubmit="return confirm('Are you sure you want to delete this material?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-500 text-white text-xs font-bold rounded-xl hover:from-red-600 hover:to-rose-600 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Ultra Modern Empty State -->
                <div class="relative bg-white/80 backdrop-blur-xl border border-red-100/50 rounded-3xl shadow-2xl shadow-red-100/20 overflow-hidden">
                    <!-- Animated Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-red-50 to-rose-50"></div>
                    <div class="absolute top-10 left-10 w-32 h-32 bg-red-200/30 rounded-full animate-pulse"></div>
                    <div class="absolute bottom-10 right-10 w-24 h-24 bg-rose-200/30 rounded-full animate-pulse" style="animation-delay: 1s;"></div>
                    
                    <div class="relative text-center py-24 px-8">
                        <div class="relative inline-block mb-8">
                            <div class="w-32 h-32 bg-gradient-to-br from-red-400 to-rose-500 rounded-3xl flex items-center justify-center shadow-2xl shadow-red-500/25 transform rotate-3 hover:rotate-6 transition-transform duration-500">
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a1 1 0 011-1h6a1 1 0 011 1v2M7 7v2m5-2v2"></path>
                                </svg>
                            </div>
                            <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center animate-bounce">
                                <svg class="w-4 h-4 text-yellow-800" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <h3 class="text-3xl font-bold bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent mb-4">
                            Ready to Get Started?
                        </h3>
                        <p class="text-red-500/80 text-lg mb-8 max-w-md mx-auto leading-relaxed">
                            Upload your first teaching material and start creating engaging learning experiences for your students.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <a href="{{ route('materials.teacher.create') }}" 
                               class="group relative inline-flex items-center space-x-3 bg-gradient-to-r from-red-500 to-rose-600 text-white px-10 py-4 rounded-2xl font-bold shadow-2xl shadow-red-500/30 hover:shadow-red-500/50 hover:from-red-600 hover:to-rose-700 transform hover:scale-105 transition-all duration-300 overflow-hidden">
                                <div class="absolute inset-0 bg-gradient-to-r from-red-400 to-rose-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-6 h-6 relative z-10 transform group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                                <span class="relative z-10">Upload First Material</span>
                            </a>
                            
                            <a href="{{ route('dashboard') }}" 
                               class="inline-flex items-center space-x-2 bg-white/90 backdrop-blur-sm border-2 border-red-200 text-red-600 px-8 py-4 rounded-2xl font-semibold hover:bg-red-50 hover:border-red-300 transition-all duration-300 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4"></path>
                                </svg>
                                <span>Back to Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 