<!-- resources/views/admin/register-teacher.blade.php -->

<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-stone-50 via-red-50 to-rose-100 p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header Section -->
            
            <div class="bg-white rounded-2xl shadow-xl border border-red-100 mb-8 overflow-hidden">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h1 class="text-3xl font-bold text-white flex items-center"> 
                        <br>
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                                
                         Register Teacher
                    </h1>
                    <p class="text-red-100 mt-2">Add a new faculty member to your educational team</p>
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

            <!-- Success Alert -->
            @if (session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 rounded-2xl p-6 shadow-lg">
                    <div class="flex items-center">
                        <div class="bg-green-100 rounded-xl p-3 mr-4">
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

            <!-- Main Form Container -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-red-100">
                <div class="bg-gradient-to-r from-red-800 to-red-900 px-8 py-6">
                    <h3 class="text-white font-bold text-xl flex items-center">
                        <div class="bg-white bg-opacity-20 rounded-lg p-2 mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        Teacher Information
                    </h3>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('admin.register.teacher.submit') }}" class="space-y-8">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Full Name -->
                            <div class="space-y-2">
                                <label for="name" class="flex items-center text-gray-800 font-bold text-lg">
                                    <div class="bg-red-100 rounded-lg p-2 mr-3">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    Full Name
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}" 
                                       required
                                       class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl text-lg font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('name') border-red-500 @enderror"
                                       placeholder="Enter teacher's full name">
                                @error('name') 
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <label for="email" class="flex items-center text-gray-800 font-bold text-lg">
                                    <div class="bg-red-100 rounded-lg p-2 mr-3">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                       class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl text-lg font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('email') border-red-500 @enderror"
                                       placeholder="teacher@email.com">
                                @error('email') 
                                    <div class="flex items-center mt-2 text-red-600">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="font-medium">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Contact Number (Full Width) -->
                        <div class="space-y-2">
                            <label for="contact_number" class="flex items-center text-gray-800 font-bold text-lg">
                                <div class="bg-red-100 rounded-lg p-2 mr-3">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                   class="w-full px-6 py-4 bg-gray-50 border-2 border-gray-200 rounded-2xl text-lg font-medium focus:border-red-500 focus:bg-white transition-all duration-300 @error('contact_number') border-red-500 @enderror"
                                   placeholder="+63 XXX XXX XXXX">
                            @error('contact_number') 
                                <div class="flex items-center mt-2 text-red-600">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="font-medium">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <button type="submit"
                                    class="group flex items-center justify-center w-full sm:w-auto bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all duration-300 transform hover:scale-105 hover:shadow-xl">
                                <div class="bg-white bg-opacity-20 rounded-xl p-2 mr-4 group-hover:bg-opacity-30 transition-all duration-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                Register Teacher
                                <svg class="w-5 h-5 ml-auto group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>

                            <a href="{{ route('dashboard') }}"  
                               class="group flex items-center justify-center w-full sm:w-auto bg-white hover:bg-gray-50 text-red-800 px-8 py-4 rounded-2xl font-bold text-lg border-2 border-red-200 hover:border-red-300 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <div class="bg-red-100 rounded-xl p-2 mr-4 group-hover:bg-red-200 transition-all duration-300">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                    </svg>
                                </div>
                                Back to Dashboard
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>