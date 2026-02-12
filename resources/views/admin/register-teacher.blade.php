<!-- resources/views/admin/register-teacher.blade.php -->

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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            Register Teacher
                        </h1>
                        <p class="text-white/80 text-sm font-medium">Add a new faculty member to your educational team</p>
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
            @if (session('success'))
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Teacher Information
                    </h3>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('admin.register.teacher.submit') }}" class="space-y-8">
                        @csrf

                        <!-- Teacher Name Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
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
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('last_name') border-red-500 @enderror"
                                       placeholder="Dela Cruz">
                                @error('last_name') 
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
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
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('first_name') border-red-500 @enderror"
                                       placeholder="Juan">
                                @error('first_name') 
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
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

                        <!-- Email and Contact -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                        </svg>
                                    </div>
                                    Email Address
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('email') border-red-500 @enderror"
                                       placeholder="teacher@gssm.edu.ph">
                                @error('email') 
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="space-y-2">
                                <label for="contact_number" class="flex items-center text-gray-800 font-semibold text-base">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    Contact Number
                                </label>
                                <input type="text" 
                                       name="contact_number" 
                                       id="contact_number" 
                                       value="{{ old('contact_number') }}" 
                                       required
                                       maxlength="20"
                                       class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl text-base font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('contact_number') border-red-500 @enderror"
                                       placeholder="09123456789">
                                @error('contact_number') 
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="flex justify-end pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="group inline-flex items-center px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2 transform group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span>Register Teacher</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Info Card -->
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
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>A unique Teacher ID will be automatically generated (format: TGSSM000001)</span>
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
                                <span>Teacher will be required to change password on first login</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-4 h-4 text-red-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span>All fields except Middle Initial are required</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>