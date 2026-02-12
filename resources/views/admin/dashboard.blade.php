<!-- resources/views/admin/dashboard.blade.php -->
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100 p-6">
        
        <!-- Enhanced Header Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5">
                                <h1 class="text-3xl font-bold text-white mb-1">Admin Dashboard</h1>
                                <p class="text-white/80 text-sm font-medium">Managing education excellence</p>
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
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="space-y-8">
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Total Teachers -->
                    <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-red-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Total Teachers</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalTeachers }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Active Faculty
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Students -->
                    <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-rose-100 to-rose-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-semibold text-rose-600 uppercase tracking-wider">Total Students</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalStudents }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                                        Enrolled Learners
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Users -->
                    <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-gradient-to-br from-red-100 to-pink-200 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider">Total Users</p>
                                <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalUsers }}</p>
                                <div class="mt-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Platform Members
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Section -->
 <!-- Quick Actions Section - UPDATED -->
<div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 mb-8">
    <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
        <div class="w-6 h-6 bg-gradient-to-r from-red-500 to-red-600 rounded-lg mr-3"></div>
        Quick Actions
    </h2>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <!-- Register Student -->
        <a href="{{ route('admin.register.student') }}"
           class="group flex flex-col items-start justify-between bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 
                  hover:from-blue-100 hover:to-blue-200 transition-all duration-300 
                  cursor-pointer border border-transparent hover:border-blue-300 h-36">
            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center 
                        group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 text-sm">Register Student</h3>
                <p class="text-xs text-gray-600">Add new students</p>
            </div>
        </a>

        <!-- Register Teacher -->
        <a href="{{ route('admin.register.teacher') }}"
           class="group flex flex-col items-start justify-between bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-5 
                  hover:from-emerald-100 hover:to-emerald-200 transition-all duration-300 
                  cursor-pointer border border-transparent hover:border-emerald-300 h-36">
            <div class="w-10 h-10 bg-emerald-600 rounded-lg flex items-center justify-center 
                        group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 text-sm">Register Teacher</h3>
                <p class="text-xs text-gray-600">Add teacher accounts</p>
            </div>
        </a>

        <!-- Manage Sections -->
        <a href="{{ route('admin.sections') }}"
           class="group flex flex-col items-start justify-between bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 
                  hover:from-purple-100 hover:to-purple-200 transition-all duration-300 
                  cursor-pointer border border-transparent hover:border-purple-300 h-36">
            <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center 
                        group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 text-sm">Manage Sections</h3>
                <p class="text-xs text-gray-600">{{ $sectionsCount }} sections</p>
            </div>
        </a>

        <!-- Manage Subjects -->
        <a href="{{ route('admin.subject-list') }}"
           class="group flex flex-col items-start justify-between bg-gradient-to-br from-pink-50 to-pink-100 rounded-xl p-5 
                  hover:from-pink-100 hover:to-pink-200 transition-all duration-300 
                  cursor-pointer border border-transparent hover:border-pink-300 h-36">
            <div class="w-10 h-10 bg-pink-600 rounded-lg flex items-center justify-center 
                        group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 text-sm">Manage Subjects</h3>
                <p class="text-xs text-gray-600">{{ $subjectsCount }} subjects</p>
            </div>
        </a>

        <!-- View Gradebook -->
        <a href="{{ route('admin.gradebook') }}"
           class="group flex flex-col items-start justify-between bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-5 
                  hover:from-orange-100 hover:to-orange-200 transition-all duration-300 
                  cursor-pointer border border-transparent hover:border-orange-300 h-36">
            <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center 
                        group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 text-sm">View Gradebook</h3>
                <p class="text-xs text-gray-600">Monitor grades</p>
            </div>
        </a>

        <!-- Search Users -->
        <a href="{{ route('admin.search.user.form') }}"
           class="group flex flex-col items-start justify-between bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl p-5 
                  hover:from-gray-200 hover:to-gray-300 transition-all duration-300 
                  cursor-pointer border border-transparent hover:border-gray-300 h-36">
            <div class="w-10 h-10 bg-gray-600 rounded-lg flex items-center justify-center 
                        group-hover:scale-110 transition-transform duration-300">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 text-sm">Search Users</h3>
                <p class="text-xs text-gray-600">Search users</p>
            </div>
        </a>
    </div>
</div>

<!-- Teachers Table -->
<div class="bg-white rounded-xl shadow-lg border border-red-100 overflow-hidden">
    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-white font-bold text-lg flex items-center">
                <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                All Teachers
            </h3>
            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-3 py-1">
                <span class="text-white text-sm font-medium">{{ $allTeachers->count() }} total</span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        @if ($allTeachers->isEmpty())
            <div class="text-center py-12">
                <div class="mx-auto w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No teachers registered yet</p>
                <p class="text-gray-400 text-sm mt-1">Get started by registering your first teacher</p>
            </div>
        @else
            <div class="overflow-x-auto @if($allTeachers->count() > 5) max-h-96 overflow-y-auto @endif">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Teacher ID</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Name</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Email</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Contact</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Registered</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allTeachers as $teacher)
                            <tr class="border-b border-gray-100 hover:bg-red-25 transition-colors duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-red-100 to-red-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-red-700 font-semibold text-sm">{{ $loop->iteration }}</span>
                                        </div>
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-xs font-bold whitespace-nowrap inline-block">{{ $teacher->user_id }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div>
                                        <div class="font-medium text-gray-900 whitespace-nowrap">{{ $teacher->name }}</div>
                                        <div class="text-gray-500 text-sm">Faculty Member</div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-700 whitespace-nowrap">{{ $teacher->email }}</td>
                                <td class="py-4 px-4 text-gray-700 whitespace-nowrap">{{ $teacher->contact_number ?? 'N/A' }}</td>
                                <td class="py-4 px-4">
                                    @if($teacher->is_active)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium whitespace-nowrap inline-block">Active</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium whitespace-nowrap inline-block">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-gray-600 whitespace-nowrap">{{ $teacher->created_at ? $teacher->created_at->format('M d, Y') : 'Recent' }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.toggle.status', $teacher->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to {{ $teacher->is_active ? 'deactivate' : 'activate' }} {{ $teacher->name }}?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="{{ $teacher->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white p-2 rounded-lg transition-colors duration-200"
                                                    title="{{ $teacher->is_active ? 'Deactivate' : 'Activate' }} Account">
                                                @if($teacher->is_active)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.delete.user', $teacher->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete {{ $teacher->name }}? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200"
                                                    title="Delete Teacher">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Students Table -->
<div class="bg-white rounded-xl shadow-lg border border-red-100 overflow-hidden">
    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h3 class="text-white font-bold text-lg flex items-center">
                <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                </svg>
                All Students
            </h3>
            <div class="bg-white/20 backdrop-blur-sm rounded-lg px-3 py-1">
                <span class="text-white text-sm font-medium">{{ $allStudents->count() }} total</span>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        @if ($allStudents->isEmpty())
            <div class="text-center py-12">
                <div class="mx-auto w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No students registered yet</p>
                <p class="text-gray-400 text-sm mt-1">Start building your student community</p>
            </div>
        @else
            <div class="overflow-x-auto @if($allStudents->count() > 5) max-h-96 overflow-y-auto @endif">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Student ID</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Name</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Email</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Guardian</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Guardian Contact</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Status</th>
                            <th class="text-left py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Registered</th>
                            <th class="text-center py-3 px-4 font-semibold text-gray-700 text-sm whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allStudents as $student)
                            <tr class="border-b border-gray-100 hover:bg-red-25 transition-colors duration-150">
                                <td class="py-4 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gradient-to-r from-rose-100 to-rose-200 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <span class="text-rose-700 font-semibold text-sm">{{ $loop->iteration }}</span>        
                                        </div>
                                        <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-lg text-xs font-bold whitespace-nowrap inline-block">{{ $student->user_id }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4">
                                    <div>
                                        <div class="font-medium text-gray-900 whitespace-nowrap">{{ $student->name }}</div>
                                        <div class="text-gray-500 text-sm">Student</div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-gray-700 whitespace-nowrap">{{ $student->email }}</td>
                                <td class="py-4 px-4 text-gray-700 whitespace-nowrap">{{ $student->guardian_name ?? 'N/A' }}</td>
                                <td class="py-4 px-4 text-gray-700 whitespace-nowrap">{{ $student->guardian_contact ?? 'N/A' }}</td>
                                <td class="py-4 px-4">
                                    @if($student->is_active)
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium whitespace-nowrap inline-block">Active</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-medium whitespace-nowrap inline-block">Inactive</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-gray-600 whitespace-nowrap">{{ $student->created_at ? $student->created_at->format('M d, Y') : 'Recent' }}</td>
                                <td class="py-4 px-4">
                                    <div class="flex justify-center gap-2">
                                        <form action="{{ route('admin.toggle.status', $student->id) }}" method="POST" 
                                            onsubmit="return confirm('Are you sure you want to {{ $student->is_active ? 'deactivate' : 'activate' }} {{ $student->name }}?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="{{ $student->is_active ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white p-2 rounded-lg transition-colors duration-200"
                                                    title="{{ $student->is_active ? 'Deactivate' : 'Activate' }} Account">
                                                @if($student->is_active)
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.delete.user', $student->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete {{ $student->name }}? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition-colors duration-200"
                                                    title="Delete Student">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-xl shadow-lg border border-red-100 overflow-hidden">
    <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
        <h3 class="text-white font-bold text-lg flex items-center">
            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
            Recent Activity
        </h3>
    </div>
    
    <div class="p-6">
        @if($allTeachers->isNotEmpty() || $allStudents->isNotEmpty())
            <div class="space-y-3 max-h-96 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-red-300 scrollbar-track-gray-100">
                @php
                    $allUsers = $allTeachers->map(function($teacher) {
                        return [
                            'user' => $teacher,
                            'type' => 'teacher',
                            'created_at' => $teacher->created_at
                        ];
                    })->concat($allStudents->map(function($student) {
                        return [
                            'user' => $student,
                            'type' => 'student',
                            'created_at' => $student->created_at
                        ];
                    }))->sortByDesc('created_at');
                @endphp
                
                @foreach($allUsers as $item)
                    @if($item['type'] === 'teacher')
                        <div class="flex items-center p-3 bg-red-50 rounded-lg">
                            <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-xs font-bold">{{ substr($item['user']->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $item['user']->name }} joined as teacher</p>
                                <p class="text-xs text-gray-500">{{ $item['user']->created_at ? $item['user']->created_at->diffForHumans() : 'Recently' }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center p-3 bg-red-50 rounded-lg">
                            <div class="w-8 h-8 bg-rose-500 rounded-full flex items-center justify-center mr-3">
                                <span class="text-white text-xs font-bold">{{ substr($item['user']->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $item['user']->name }} enrolled as student</p>
                                <p class="text-xs text-gray-500">{{ $item['user']->created_at ? $item['user']->created_at->diffForHumans() : 'Recently' }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-500 font-medium">No recent activity</p>
                <p class="text-gray-400 text-sm">Activity will appear as users join</p>
            </div>
        @endif
    </div>
</div>

            </div>
        </div>
    </div>
</x-app-layout>