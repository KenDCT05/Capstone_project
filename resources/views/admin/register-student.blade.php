<!-- resources/views/admin/register-student.blade.php -->

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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            Register Student
                        </h1>
                        <p class="text-white/80 text-sm font-medium">Enroll a new student in your learning community</p>
                    </div>
                </div>
                
                <div class="px-8 py-6">
                    <a href="{{ route('dashboard') }}" 
                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a> 
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-green-800 font-bold text-lg">Success!</h3>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Error Alert -->
            @if ($errors->any())
                <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-6 shadow-lg">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.664-.833-2.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-red-800 font-bold text-lg mb-2">Please fix the following errors:</h3>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li class="text-red-700 font-medium text-sm">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Form Container -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-red-100">
                <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-4">
                    <h3 class="text-white font-bold text-lg flex items-center">
                        <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        Student Information
                    </h3>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('admin.register.student.submit') }}" class="space-y-8">
                        @csrf

                        <!-- Student ID Field (NEW) -->
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6">
                            <div class="space-y-2">
                                <label for="user_id" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                        </svg>
                                    </div>
                                    Student ID
                                    <span class="ml-2 text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="user_id" 
                                       id="user_id"
                                       value="{{ old('user_id') }}"
                                       required
                                       class="w-full px-4 py-3 bg-white border-2 border-yellow-300 rounded-xl text-base font-medium focus:border-yellow-500 focus:bg-white transition-all duration-300 @error('user_id') border-red-500 @enderror"
                                       placeholder="Enter existing Student ID (e.g., 2024-00001)">
                                <p class="text-sm text-gray-600 flex items-center mt-2">
                                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Enter the student ID
                                </p>
   
                            </div>
                        </div>

                        <!-- Student Name Fields -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Last Name -->
                            <div class="space-y-2">
                                <label for="last_name" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    Last Name
                                </label>
                                <input type="text" 
                                       name="last_name" 
                                       id="last_name"
                                       value="{{ old('last_name') }}"
                                       required
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                       placeholder="Dela Cruz">
                            </div>

                            <!-- First Name -->
                            <div class="space-y-2">
                                <label for="first_name" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    First Name
                                </label>
                                <input type="text" 
                                       name="first_name" 
                                       id="first_name"
                                       value="{{ old('first_name') }}"
                                       required
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                       placeholder="Juan">
                            </div>

                            <!-- Middle Initial -->
                            <div class="space-y-2">
                                <label for="middle_initial" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    Middle Initial
                                </label>
                                <input type="text" 
                                       name="middle_initial" 
                                       id="middle_initial"
                                       value="{{ old('middle_initial') }}"
                                       maxlength="10"
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                       placeholder="N.">
                                <p class="text-sm text-gray-500 flex items-center mt-1">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Optional
                                </p>
                            </div>
                        </div>

                        <!-- Gender and Email -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Gender -->
                            <div class="space-y-2">
                                <label for="gender" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                        </svg>
                                    </div>
                                    Sex
                                </label>
                                <select name="gender" 
                                        id="gender"
                                        required
                                        class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300">
                                    <option value="">Select Sex...</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <!-- Student Email -->
                            <div class="space-y-2">
                                <label for="email" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    Student Email
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email"
                                       value="{{ old('email') }}"
                                       required
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                       placeholder="student@email.com">
                            </div>
                        </div>

                        <!-- Guardian Information Section -->
                        <div class="border-t border-gray-200 pt-8">
                            <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-xl px-6 py-4 mb-6">
                                <h3 class="text-white font-bold text-lg flex items-center">
                                    <svg class="w-6 h-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                    Parent/Guardian Information
                                </h3>
                            </div>

                            <!-- Guardian Name Fields -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                                <!-- Guardian Last Name -->
                                <div class="space-y-2">
                                    <label for="guardian_last_name" class="flex items-center text-gray-800 font-semibold text-base">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        Guardian Last Name
                                    </label>
                                    <input type="text" 
                                           name="guardian_last_name" 
                                           id="guardian_last_name"
                                           value="{{ old('guardian_last_name') }}"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                           placeholder="Dela Cruz">
                                </div>

                                <!-- Guardian First Name -->
                                <div class="space-y-2">
                                    <label for="guardian_first_name" class="flex items-center text-gray-800 font-semibold text-base">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        Guardian First Name
                                    </label>
                                    <input type="text" 
                                           name="guardian_first_name" 
                                           id="guardian_first_name"
                                           value="{{ old('guardian_first_name') }}"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                           placeholder="Juan">
                                </div>

                                <!-- Guardian Middle Initial -->
                                <div class="space-y-2">
                                    <label for="guardian_middle_initial" class="flex items-center text-gray-800 font-semibold text-base">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        Guardian M.I.
                                    </label>
                                    <input type="text" 
                                           name="guardian_middle_initial" 
                                           id="guardian_middle_initial"
                                           value="{{ old('guardian_middle_initial') }}"
                                           maxlength="10"
                                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                           placeholder="N.">
                                    <p class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Optional
                                    </p>
                                </div>
                            </div>

                            <!-- Guardian Email and Contact -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <!-- Guardian Email -->
                                <div class="space-y-2">
                                    <label for="guardian_email" class="flex items-center text-gray-800 font-semibold text-base">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                            </svg>
                                        </div>
                                        Guardian Email
                                    </label>
                                    <input type="email" 
                                           name="guardian_email" 
                                           id="guardian_email"
                                           value="{{ old('guardian_email') }}"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                           placeholder="guardian@email.com">
                                </div>

                                <!-- Guardian Contact -->
                                <div class="space-y-2">
                                    <label for="guardian_contact" class="flex items-center text-gray-800 font-semibold text-base">
                                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        </div>
                                        Guardian Contact
                                    </label>
                                    <input type="text" 
                                           name="guardian_contact" 
                                           id="guardian_contact"
                                           value="{{ old('guardian_contact') }}"
                                           required
                                           class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300"
                                           placeholder="639123456789">
                                    <p class="text-sm text-gray-500 flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Format: 639XXXXXXXXX
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="group flex items-center justify-center bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-8 py-4 rounded-xl font-semibold text-base transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Register Student
                                <svg class="w-4 h-4 ml-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>

                            <a href="{{ route('dashboard') }}" 
                               class="group flex items-center justify-center bg-white hover:bg-gray-50 text-red-700 px-8 py-4 rounded-xl font-semibold text-base border-2 border-red-200 hover:border-red-300 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <svg class="w-4 h-4 mr-3 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Important Information Card -->
            <div class="mt-6 bg-white rounded-xl shadow-lg border border-red-100 p-6">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-gray-800 font-bold text-base mb-2">Important Information</h4>
                        <ul class="space-y-1 text-gray-600 text-sm">
                            {{-- <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Enter the student's existing ID from your school's ID system</span>
                            </li> --}}
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Student ID must be unique and will be used for identification purposes</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Students will log in using their email address and password</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Email notification with login credentials will be sent automatically</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>Student will be required to change password on first login</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>All fields except Middle Initials are required</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>