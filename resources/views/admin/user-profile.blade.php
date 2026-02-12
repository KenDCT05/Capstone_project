<x-app-layout>
<div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100 p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="bg-white rounded-xl shadow-xl border border-red-100 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 via-red-700 to-rose-700 px-8 py-6 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-black/10 to-black/5"></div>
                <div class="absolute -top-4 -right-4 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute -bottom-4 -left-4 w-24 h-24 bg-white/5 rounded-full blur-xl"></div>
                
                <div class="relative">
                    <h1 class="text-3xl font-bold text-white mb-1 flex items-center"> 
                        <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30 mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        User Profile
                    </h1>
                    <p class="text-white/80 text-sm font-medium">View detailed information about this user</p>
                </div>
            </div>
            
            <div class="px-8 py-6">
                <a href="{{ route('admin.search.user.form') }}" 
                   class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="font-medium">Back to Search</span>
                </a> 
            </div>
        </div>

        <!-- User Information Card -->
        <div class="bg-white rounded-xl shadow-xl border border-red-100 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                <h3 class="text-white font-bold text-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Personal Information
                </h3>
            </div>

            <div class="p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-red-600 via-red-700 to-rose-700 bg-clip-text text-transparent">{{ $user->name }}</h2>
                        <p class="text-gray-600 font-semibold text-base mt-1">{{ ucfirst($user->role) }}</p>
                    </div>
                    <span class="px-4 py-2 rounded-xl text-sm font-bold shadow-sm {{ $user->is_active ? 'bg-green-100 text-green-800 border-2 border-green-200' : 'bg-red-100 text-red-900 border-2 border-red-200' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                        <p class="text-sm text-gray-600 font-medium mb-1">User ID</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $user->user_id }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                        <p class="text-sm text-gray-600 font-medium mb-1">Email</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $user->email }}</p>
                    </div>
                    @if($user->contact_number)
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                        <p class="text-sm text-gray-600 font-medium mb-1">Contact Number</p>
                        <p class="font-bold text-gray-900 text-lg">{{ $user->contact_number }}</p>
                    </div>
                    @endif
                    @if($user->gender)
                    <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                        <p class="text-sm text-gray-600 font-medium mb-1">Gender</p>
                        <p class="font-bold text-gray-900 text-lg">{{ ucfirst($user->gender) }}</p>
                    </div>
                    @endif
                </div>

                @if($user->role === 'student' && $user->guardian_name)
                <div class="mt-8 pt-8 border-t-2 border-gray-200">
                    <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl px-6 py-4 mb-6">
                        <h3 class="text-white font-bold text-lg flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Guardian Information
                        </h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                            <p class="text-sm text-gray-600 font-medium mb-1">Guardian Name</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $user->guardian_name }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                            <p class="text-sm text-gray-600 font-medium mb-1">Guardian Email</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $user->guardian_email }}</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 border-2 border-gray-100">
                            <p class="text-sm text-gray-600 font-medium mb-1">Guardian Contact</p>
                            <p class="font-bold text-gray-900 text-lg">{{ $user->guardian_contact }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Statistics Cards -->
        @if(!empty($statistics))
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            @foreach($statistics as $label => $value)
            <div class="bg-white rounded-xl shadow-lg border border-red-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <p class="text-gray-600 text-sm font-bold uppercase tracking-wider mb-2">{{ ucwords(str_replace('_', ' ', $label)) }}</p>
                <p class="text-4xl font-bold bg-gradient-to-r from-red-600 via-red-700 to-rose-700 bg-clip-text text-transparent">{{ $value }}</p>
            </div>
            @endforeach
        </div>
        @endif

        <!-- Teacher: Subjects Teaching Section -->
        @if($user->role === 'teacher')
        <div class="bg-white rounded-xl shadow-lg border border-red-100 mb-6 overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                <h3 class="text-white font-bold text-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Subjects Teaching
                </h3>
            </div>

            <div class="p-8">
                @if($subjects->count() > 0)
                    <div class="overflow-x-auto rounded-xl border-2 border-gray-100">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-red-50 to-rose-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-800 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-800 uppercase tracking-wider">Students</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-red-800 uppercase tracking-wider">Created</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($subjects as $subject)
                                    <tr class="hover:bg-red-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                            {{ $subject->subjectList->name ?? $subject->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">
                                            {{ $subject->students->count() ?? 0 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-700 font-medium">
                                            {{ $subject->created_at ? $subject->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-gray-100">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        <p class="text-gray-600 font-semibold text-lg">No subjects assigned yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Teacher: Students List -->
        @if($students->count() > 0)
        <div class="bg-white rounded-xl shadow-lg border border-red-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                <h3 class="text-white font-bold text-lg flex items-center">
                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Students ({{ $students->count() }})
                </h3>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($students as $student)
                    <div class="group border-2 border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-red-300 hover:bg-red-50 transition-all duration-300 transform hover:-translate-y-1">
                        <p class="font-bold text-gray-900 text-lg mb-1">{{ $student->name }}</p>
                        <p class="text-sm text-gray-600 font-medium mb-3">{{ $student->user_id }}</p>
                        <a href="{{ route('admin.user.profile', $student->user_id) }}" class="inline-flex items-center text-red-600 hover:text-red-800 text-sm font-bold transition duration-300">
                            View Profile
                            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        @endif

        <!-- Student: Enrolled Subjects Section -->
        @if($user->role === 'student')
            <div class="bg-white rounded-xl shadow-lg border border-red-100 mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                    <h3 class="text-white font-bold text-lg flex items-center">
                        <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Enrolled Subjects
                    </h3>
                </div>

                <div class="p-8">
                    @if($subjects->count() > 0)
                        <div class="overflow-x-auto rounded-xl border-2 border-gray-100">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-red-50 to-rose-50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-red-800 uppercase tracking-wider">Subject</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-red-800 uppercase tracking-wider">Teacher</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($subjects as $subject)
                                    <tr class="hover:bg-red-50 transition-colors duration-200">
                                        <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">{{ $subject->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($subject->teacher)
                                            <a href="{{ route('admin.user.profile', $subject->teacher->user_id) }}" class="inline-flex items-center text-red-600 hover:text-red-800 font-bold transition duration-300">
                                                {{ $subject->teacher->name }}
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </a>
                                            @else
                                            <span class="text-gray-500 font-medium">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-gray-100">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <p class="text-gray-600 font-semibold text-lg">Not enrolled in any subjects yet.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Student: Teachers List -->
            @if($teachers->count() > 0)
            <div class="bg-white rounded-xl shadow-lg border border-red-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                    <h3 class="text-white font-bold text-lg flex items-center">
                        <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Teachers ({{ $teachers->count() }})
                    </h3>
                </div>

                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($teachers as $teacher)
                        <div class="group border-2 border-gray-200 rounded-xl p-5 hover:shadow-lg hover:border-red-300 hover:bg-red-50 transition-all duration-300 transform hover:-translate-y-1">
                            <p class="font-bold text-gray-900 text-lg mb-1">{{ $teacher->name }}</p>
                            <p class="text-sm text-gray-600 font-medium mb-3">{{ $teacher->email }}</p>
                            <a href="{{ route('admin.user.profile', $teacher->user_id) }}" class="inline-flex items-center text-red-600 hover:text-red-800 text-sm font-bold transition duration-300">
                                View Profile
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
</x-app-layout>