<!-- resources/views/admin/dashboard.blade.php -->
<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-stone-50 via-red-50 to-rose-100 p-6">
        
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Header with Enhanced Design -->
            <div class="relative overflow-hidden bg-gradient-to-r from-red-900 via-red-800 to-red-600 rounded-3xl p-8 mb-8 shadow-2xl">
                <div class="absolute inset-0 bg-black bg-opacity-10"></div>
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white bg-opacity-10 rounded-full blur-xl"></div>
                <div class="absolute -bottom-8 -left-8 w-24 h-24 bg-rose-300 bg-opacity-20 rounded-full blur-lg"></div>
                
                <div class="relative z-10 flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-white mb-2 tracking-tight">
                            Welcome back, Admin
                        </h1>
                        <p class="text-red-100 text-lg font-medium">Empowering education through seamless management</p>
                        <div class="mt-4 flex items-center space-x-4 text-red-200 text-sm">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ now()->format('M d, Y') }}
                            </span>
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                {{ now()->format('g:i A') }}
                            </span>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="bg-white bg-opacity-15 backdrop-blur-sm rounded-2xl p-6 border border-white border-opacity-20">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Stats & Tables -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Enhanced Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Total Teachers -->
                        <div class="group relative overflow-hidden bg-gradient-to-br from-red-600 to-red-800 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-4xl font-bold text-white">{{ $recentTeachers->count() }}</p>
                                        <p class="text-red-100 font-medium">Teachers</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-red-100 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Active educators</span>
                                </div>
                            </div>
                        </div>

                        <!-- Students -->
                        <div class="group relative overflow-hidden bg-gradient-to-br from-red-600 to-red-800 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-4xl font-bold text-white">{{ $recentStudents->count() }}</p>
                                        <p class="text-red-100 font-medium">Students</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-red-100 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Learning community</span>
                                </div>
                            </div>
                        </div>

                        <!-- Total Users -->
                        <div class="group relative overflow-hidden bg-gradient-to-br from-red-700 to-red-900 rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent to-white opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="p-3 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-4xl font-bold text-white">{{ $recentTeachers->count() + $recentStudents->count() }}</p>
                                        <p class="text-red-100 font-medium">Total Users</p>
                                    </div>
                                </div>
                                <div class="flex items-center text-red-100 text-sm">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span>Platform members</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Teachers Table -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100">
                        <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-white font-bold text-xl flex items-center">
                                    <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    Recently Registered Teachers
                                </h3>
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-3 py-1">
                                    <span class="text-white text-sm font-medium">{{ $recentTeachers->count() }} total</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            @if ($recentTeachers->isEmpty())
                                <div class="text-center py-12">
                                    <div class="mx-auto w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">No teachers registered yet</p>
                                    <p class="text-gray-400 text-sm mt-1">Get started by registering your first teacher</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gradient-to-r from-red-600 to-red-800">
                                            <tr>
                                                <th class="text-left py-4 px-3 font-bold text-white uppercase tracking-wide text-sm">Name</th>
                                                <th class="text-left py-4 px-3 font-bold text-white uppercase tracking-wide text-sm">Email</th>
                                                <th class="text-left py-4 px-3 font-bold text-white uppercase tracking-wide text-sm">Role</th>
                                                <th class="text-left py-4 px-3 font-bold text-white uppercase tracking-wide text-sm">Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentTeachers as $teacher)
                                                <tr class="border-b border-red-50 hover:bg-red-50 transition-all duration-200">
                                                    <td class="py-4 px-3">
                                                        <div class="flex items-center">
                                                            <div class="w-12 h-12 bg-gradient-to-r from-red-400 to-red-600 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                                                <span class="text-white font-bold text-lg">{{ substr($teacher->name, 0, 1) }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="font-bold text-gray-900 text-lg">{{ $teacher->name }}</span>
                                                                <div class="text-gray-500 text-sm">Faculty Member</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-3 text-gray-700 font-medium">{{ $teacher->email }}</td>
                                                    <td class="py-4 px-3">
                                                        <span class="bg-gradient-to-r from-red-100 to-red-200 text-red-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">Teacher</span>
                                                    </td>
                                                    <td class="py-4 px-3 text-gray-600 font-medium">{{ $teacher->created_at ? $teacher->created_at->format('M d, Y') : 'Recent' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Enhanced Students Table -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100">
                        <div class="bg-gradient-to-r from-red-600 to-red-800 px-8 py-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-white font-bold text-xl flex items-center">
                                    <div class="bg-gradient-to-r from-red-600 to-red-800 bg-opacity-20 rounded-lg p-2 mr-3">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        </svg>
                                    </div>
                                    Recently Registered Students
                                </h3>
                                <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-lg px-3 py-1">
                                    <span class="text-white text-sm font-medium">{{ $recentStudents->count() }} total</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            @if ($recentStudents->isEmpty())
                                <div class="text-center py-12">
                                    <div class="mx-auto w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-lg font-medium">No students registered yet</p>
                                    <p class="text-gray-400 text-sm mt-1">Start building your student community</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-gradient-to-r from-red-600 to-red-800">
                                            <tr class="border-b-2 border-red-100 ">
                                                <th class="text-left py-4 px-3 font-bold text-white uppercase tracking-wide text-sm">Name</th>
                                                <th class="text-left py-4 px-3 font-bold text-white uppercase tracking-wide text-sm">Email</th>
                                                <th class="text-left py-4 px-3 font-bold text-white uppercase tracking-wide text-sm">Role</th>
                                                <th class="text-left py-4 px-3 font-bold text-white  uppercase tracking-wide text-sm">Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentStudents as $student)
                                                <tr class="border-b border-red-50 hover:bg-red-50 transition-all duration-200">
                                                    <td class="py-4 px-3">
                                                        <div class="flex items-center">
                                                            <div class="bg-gradient-to-r from-red-600 to-red-800 w-12 h-12 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                                                <span class="text-white font-bold text-lg">{{ substr($student->name, 0, 1) }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="font-bold text-gray-900 text-lg">{{ $student->name }}</span>
                                                                <div class="text-gray-500 text-sm">Student</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="py-4 px-3 text-gray-700 font-medium">{{ $student->email }}</td>
                                                    <td class="py-4 px-3">
                                                        <span class="bg-gradient-to-r from-maroon-100 to-maroon-200 text-maroon-800 px-4 py-2 rounded-full text-sm font-bold shadow-sm">Student</span>
                                                    </td>
                                                    <td class="py-4 px-3 text-gray-600 font-medium">{{ $student->created_at ? $student->created_at->format('M d, Y') : 'Recent' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Enhanced Quick Actions -->
                <div class="space-y-8">
                    <!-- Enhanced Quick Actions -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100">
                        <div class="bg-gradient-to-r from-red-800 to-red-900 px-6 py-4">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                Quick Actions
                            </h3>
                        </div>

                        <div class="p-6 space-y-4">
                            <a href="{{ route('admin.register.student') }}" 
                               class="group flex items-center w-full bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <div class="bg-white bg-opacity-20 rounded-xl p-2 mr-4 group-hover:bg-opacity-30 transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                    </svg>
                                </div>
                                <span>Register Student</span>
                                <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a href="{{ route('admin.register.teacher') }}" 
                               class="group flex items-center w-full bg-gradient-to-r from-red-600 to-red-800 hover:from-maroon-700 hover:to-maroon-800 text-white px-6 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <div class="bg-white bg-opacity-20 rounded-xl p-2 mr-4 group-hover:bg-opacity-30 transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <span>Register Teacher</span>
                                <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            {{-- <a href="{{ route('admin.assign') }}" 
                               class="group flex items-center w-full bg-gradient-to-r from-red-700 to-red-800 hover:from-red-800 hover:to-red-900 text-white px-6 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <div class="bg-white bg-opacity-20 rounded-xl p-2 mr-4 group-hover:bg-opacity-30 transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                                    </svg>
                                </div>
                                <span>Assign Students</span>
                                <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a> --}}

                            <a href="{{ route('admin.gradebook') }}" 
                               class="group flex items-center w-full bg-gradient-to-r from-red-600 to-red-800 hover:from-maroon-800 hover:to-maroon-900 text-white px-6 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <div class="bg-white bg-opacity-20 rounded-xl p-2 mr-4 group-hover:bg-opacity-30 transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <span>Gradebook</span>
                                <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>

                            <a href="{{ route('profile.edit') }}" 
                               class="group flex items-center w-full bg-white hover:bg-gray-50 text-red-800 px-6 py-4 rounded-2xl font-bold text-lg border-2 border-red-200 hover:border-red-300 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <div class="bg-red-100 rounded-xl p-2 mr-4 group-hover:bg-red-200 transition-all duration-300">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <span>Edit Profile</span>
                                <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform duration-300 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Enhanced Quick Overview -->


                    <!-- Recent Activity Feed -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100">
                        <div class="bg-gradient-to-r from-red-800 to-red-900 px-6 py-4">
                            <h3 class="text-white font-bold text-lg flex items-center">
                                <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                Recent Activity
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="space-y-4">
                                @if($recentTeachers->isNotEmpty() || $recentStudents->isNotEmpty())
                                    @foreach($recentTeachers->take(2) as $teacher)
                                        <div class="flex items-center p-3 bg-red-50 rounded-xl border border-red-100">
                                            <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white text-xs font-bold">{{ substr($teacher->name, 0, 1) }}</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $teacher->name }} joined as teacher</p>
                                                <p class="text-xs text-gray-500">{{ $teacher->created_at ? $teacher->created_at->diffForHumans() : 'Recently' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    @foreach($recentStudents->take(2) as $student)
                                        <div class="flex items-center p-3 bg-maroon-50 rounded-xl border border-maroon-100">
                                            <div class="w-8 h-8 bg-gradient-to-r from-red-600 to-red-800 rounded-full flex items-center justify-center mr-3">
                                                <span class="text-white text-xs font-bold">{{ substr($student->name, 0, 1) }}</span>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">{{ $student->name }} enrolled as student</p>
                                                <p class="text-xs text-gray-500">{{ $student->created_at ? $student->created_at->diffForHumans() : 'Recently' }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-8">
                                        <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500 font-medium">No recent activity</p>
                                        <p class="text-gray-400 text-sm">Activity will appear here as users join</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>