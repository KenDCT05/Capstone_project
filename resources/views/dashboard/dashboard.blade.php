{{-- <!-- resources/views/dashboard/admin.blade.php -->
<x-app-layout>
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Header -->
            <div class="bg-white rounded-2xl p-6 mb-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-red-800 mb-1 flex items-center">
                            Welcome back, Admin 
                            <span class="ml-2 text-pink-400">🌸</span>
                        </h1>
                        <p class="text-red-600">Manage your school community with ease</p>
                    </div>
                    <div class="w-16 h-16 bg-pink-200 rounded-full flex items-center justify-center">
                        <span class="text-2xl">👋</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Stats -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Total Teachers -->
                        <div class="bg-red-50 rounded-2xl p-6 relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-red-800 font-semibold mb-1">Total Teachers</p>
                                    <p class="text-3xl font-bold text-red-900">{{ $recentTeachers->count() }}</p>
                                </div>
                                <div class="w-12 h-12 bg-red-200 rounded-xl flex items-center justify-center">
                                    <span class="text-xl">👨‍🏫</span>
                                </div>
                            </div>
                        </div>

                        <!-- Students -->
                        <div class="bg-purple-50 rounded-2xl p-6 relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-purple-800 font-semibold mb-1">Students</p>
                                    <p class="text-3xl font-bold text-purple-900">{{ $recentStudents->count() }}</p>
                                </div>
                                <div class="w-12 h-12 bg-purple-200 rounded-xl flex items-center justify-center">
                                    <span class="text-xl">🎓</span>
                                </div>
                            </div>
                        </div>

                        <!-- Total Users -->
                        <div class="bg-green-50 rounded-2xl p-6 relative overflow-hidden">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-green-800 font-semibold mb-1">Total Users</p>
                                    <p class="text-3xl font-bold text-green-900">{{ $recentTeachers->count() + $recentStudents->count() }}</p>
                                </div>
                                <div class="w-12 h-12 bg-green-200 rounded-xl flex items-center justify-center">
                                    <span class="text-xl">👥</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recently Registered Teachers Table -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mb-6">
                        <div class="bg-red-700 px-6 py-4">
                            <h3 class="text-white font-semibold flex items-center">
                                <span class="mr-2">👨‍🏫</span>
                                Recently Registered Teachers
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            @if ($recentTeachers->isEmpty())
                                <div class="text-center py-8">
                                    <p class="text-gray-500">No teachers registered yet.</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="border-b border-gray-100">
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Name</th>
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Email</th>
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Role</th>
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody class="space-y-2">
                                            @foreach ($recentTeachers as $teacher)
                                                <tr class="border-b border-gray-50 hover:bg-gray-50">
                                                    <td class="py-3 px-2">
                                                        <div class="flex items-center">
                                                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                                                <span class="text-red-600">👤</span>
                                                            </div>
                                                            <span class="font-medium text-gray-900">{{ $teacher->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-2 text-gray-600">{{ $teacher->email }}</td>
                                                    <td class="py-3 px-2">
                                                        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">Teacher</span>
                                                    </td>
                                                    <td class="py-3 px-2 text-gray-500 text-sm">{{ $teacher->created_at ? $teacher->created_at->format('M d, Y') : 'Recent' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Recently Registered Students Table -->
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                        <div class="bg-purple-700 px-6 py-4">
                            <h3 class="text-white font-semibold flex items-center">
                                <span class="mr-2">👨‍👩‍👧‍👦</span>
                                Recently Registered Students
                            </h3>
                        </div>
                        
                        <div class="p-6">
                            @if ($recentStudents->isEmpty())
                                <div class="text-center py-8">
                                    <p class="text-gray-500">No students registered yet.</p>
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead>
                                            <tr class="border-b border-gray-100">
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Name</th>
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Email</th>
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Role</th>
                                                <th class="text-left py-3 px-2 font-semibold text-gray-600">Registered</th>
                                            </tr>
                                        </thead>
                                        <tbody class="space-y-2">
                                            @foreach ($recentStudents as $student)
                                                <tr class="border-b border-gray-50 hover:bg-gray-50">
                                                    <td class="py-3 px-2">
                                                        <div class="flex items-center">
                                                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                                                <span class="text-purple-600">👤</span>
                                                            </div>
                                                            <span class="font-medium text-gray-900">{{ $student->name }}</span>
                                                        </div>
                                                    </td>
                                                    <td class="py-3 px-2 text-gray-600">{{ $student->email }}</td>
                                                    <td class="py-3 px-2">
                                                        <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">Student</span>
                                                    </td>
                                                    <td class="py-3 px-2 text-gray-500 text-sm">{{ $student->created_at ? $student->created_at->format('M d, Y') : 'Recent' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Quick Actions -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <!-- Quick Actions -->
<div class="bg-white rounded-2xl p-6 shadow-sm">
    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
        <span class="mr-2">⚡</span>
        Quick Actions
    </h3>

    <div class="space-y-3">
        <a href="{{ route('admin.register.student') }}" 
           class="block w-full bg-red-700 hover:bg-red-800 text-white px-4 py-3 rounded-xl text-center font-medium transition-colors duration-200">
            <span class="mr-2">🎓</span>
            Register Student
        </a>

        <a href="{{ route('admin.register.teacher') }}" 
           class="block w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl text-center font-medium transition-colors duration-200">
            <span class="mr-2">🧑‍🏫</span>
            Register Teacher
        </a>

        <a href="{{ route('admin.assign') }}" 
           class="block w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-3 rounded-xl text-center font-medium transition-colors duration-200">
            <span class="mr-2">🎯</span>
            Assign Students to Teachers
        </a>

        <a href="{{ route('profile.edit') }}" 
           class="block w-full bg-white hover:bg-gray-50 text-gray-700 px-4 py-3 rounded-xl text-center font-medium border border-gray-200 transition-colors duration-200">
            <span class="mr-2">✏️</span>
            Edit Profile
        </a>
    </div>
</div>

                    <!-- Quick Overview -->
                    <div class="bg-white rounded-2xl p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-800 mb-4">Quick Overview</h3>
                        
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Active Today</span>
                                <span class="font-bold text-green-600">{{ $recentTeachers->count() + $recentStudents->count() }}</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">This Month</span>
                                <span class="font-bold text-green-600">+{{ $recentTeachers->count() + $recentStudents->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}