<x-app-layout>
    <script>
        function passwordForm() {
            return {
                showCurrentPassword: false,
                showNewPassword: false,
                showConfirmPassword: false,
                newPassword: '',
                confirmPassword: '',
                passwordsMatch: false,
                passwordStrength: 0,
                
                checkPasswordMatch() {
                    this.passwordsMatch = this.newPassword === this.confirmPassword && this.newPassword.length > 0;
                    this.calculatePasswordStrength();
                },
                
                calculatePasswordStrength() {
                    let score = 0;
                    if (!this.newPassword) {
                        this.passwordStrength = 0;
                        return;
                    }
                    
                    // Length check
                    if (this.newPassword.length >= 8) score += 25;
                    if (this.newPassword.length >= 12) score += 25;
                    
                    // Character variety checks
                    if (/[a-z]/.test(this.newPassword)) score += 12.5;
                    if (/[A-Z]/.test(this.newPassword)) score += 12.5;
                    if (/[0-9]/.test(this.newPassword)) score += 12.5;
                    if (/[^A-Za-z0-9]/.test(this.newPassword)) score += 12.5;
                    
                    this.passwordStrength = Math.min(100, score);
                },
                
                get passwordStrengthColor() {
                    if (this.passwordStrength < 30) return 'bg-red-500';
                    if (this.passwordStrength < 60) return 'bg-yellow-500';
                    if (this.passwordStrength < 80) return 'bg-blue-500';
                    return 'bg-green-500';
                },
                
                get passwordStrengthText() {
                    if (this.passwordStrength < 30) return 'Weak';
                    if (this.passwordStrength < 60) return 'Fair';
                    if (this.passwordStrength < 80) return 'Good';
                    return 'Strong';
                },
                
                get passwordMatchClass() {
                    if (this.confirmPassword.length === 0) {
                        return 'block w-full rounded-2xl border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-20 bg-gray-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pr-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm';
                    }
                    return this.passwordsMatch ? 
                        'block w-full rounded-2xl border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500 focus:ring-2 focus:ring-opacity-30 bg-emerald-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pr-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm' :
                        'block w-full rounded-2xl border-red-300 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-30 bg-red-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pr-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm';
                }
            }
        }
    </script>
    
    <!-- Enhanced Background with Animated Gradient -->
    <div class="min-h-screen bg-gradient-to-br from-red-50 to-rose-100 overflow-hidden">

        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">

            <!-- Profile Information Section -->
            <div class="group hover:transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/50 overflow-hidden hover:shadow-2xl hover:shadow-red-500/10 transition-all duration-300">
                    <div class="border-gradient-to-b from-red-500 to-red-600 p-8 lg:p-10">
                        <!-- Enhanced Section Header -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                                    {{ __('Profile Information') }}
                                </h2>
                                <p class="mt-1 text-gray-600 text-sm leading-relaxed">
                                    {{ __("Update your account's profile information and email address.") }}
                                </p>
                            </div>
                        </div>

                        <!-- Resend Verification Form -->
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <!-- Update Profile Form -->
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <!-- Enhanced Name Field -->
                            <div class="space-y-2 group">
                                <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-semibold text-sm flex items-center gap-2" />
                                <div class="relative">
                                    <x-text-input 
                                        id="name" 
                                        name="name" 
                                        type="text" 
                                        class="block w-full rounded-2xl border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-30 bg-gray-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pl-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm hover:bg-white/70" 
                                        :value="old('name', $user->name)" 
                                        required 
                                        autofocus 
                                        autocomplete="name" 
                                    />
                                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error class="mt-2 text-red-600 text-sm font-medium" :messages="$errors->get('name')" />
                            </div>

                            <!-- Enhanced Email Field -->
                            <div class="space-y-2 group">
                                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-semibold text-sm flex items-center gap-2" />
                                <div class="relative">
                                    <x-text-input 
                                        id="email" 
                                        name="email" 
                                        type="email" 
                                        class="block w-full rounded-2xl border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-30 bg-gray-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pl-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm hover:bg-white/70" 
                                        :value="old('email', $user->email)" 
                                        required 
                                        autocomplete="username" 
                                    />
                                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a3 3 0 11-6 0 3 3 0 016 0z M8 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                </div>
                                <x-input-error class="mt-2 text-red-600 text-sm font-medium" :messages="$errors->get('email')" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-4 p-5 bg-gradient-to-r from-red-50 to-red-50/50 rounded-2xl border border-red-200 backdrop-blur-sm">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-sm text-red-700 font-medium">
                                                    {{ __('Your email address is unverified.') }}
                                                    <button 
                                                        form="send-verification" 
                                                        class="ml-1 font-semibold text-red-600 hover:text-red-700 underline underline-offset-2 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-opacity-20 rounded-md transition-all duration-200 hover:bg-red-50 px-1 py-0.5"
                                                    >
                                                        {{ __('Click here to re-send the verification email.') }}
                                                    </button>
                                                </p>

                                                @if (session('status') === 'verification-link-sent')
                                                    <div class="mt-3 p-3 bg-emerald-50 rounded-xl border border-emerald-200">
                                                        <p class="text-sm text-emerald-700 font-medium flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                            {{ __('A new verification link has been sent to your email address.') }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Enhanced Actions -->
                            <div class="flex items-center gap-4 pt-4">
                                <x-primary-button class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:from-red-700 focus:to-red-800 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 active:from-red-900 active:to-red-900 transition-all duration-300 px-8 py-3 rounded-2xl font-semibold text-white shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/30 transform hover:scale-[1.02]">
                                    {{ __('Save Changes') }}
                                </x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform scale-90"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        x-init="setTimeout(() => show = false, 4000)"
                                        class="text-sm text-emerald-700 font-semibold bg-emerald-50 px-4 py-2 rounded-full border border-emerald-200 flex items-center gap-2 shadow-sm"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ __('Saved successfully') }}
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Update Password Section -->
            <div class="group hover:transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/50 overflow-hidden hover:shadow-2xl hover:shadow-red-500/10 transition-all duration-300">
                    <div class="border-gradient-to-b from-red-500 to-red-600 p-8 lg:p-10" x-data="passwordForm()">
                        <!-- Enhanced Section Header -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                                    {{ __('Update Password') }}
                                </h2>
                                <p class="mt-1 text-gray-600 text-sm leading-relaxed">
                                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                                </p>
                            </div>
                        </div>

                        <form method="post" action="{{ route('profile-change.password') }}" class="space-y-6">
                            @csrf
                            @method('put')

                            <!-- Enhanced Current Password -->
                            <div class="space-y-2 group">
                                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 font-semibold text-sm" />
                                <div class="relative">
                                    <input 
                                        id="update_password_current_password" 
                                        name="current_password" 
                                        x-bind:type="showCurrentPassword ? 'text' : 'password'"
                                        class="block w-full rounded-2xl border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-30 bg-gray-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pl-12 pr-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm hover:bg-white/70" 
                                        autocomplete="current-password"
                                        placeholder="Enter your current password"
                                    />
                                    
                                    <!-- Lock Icon -->
                                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>

                                    <!-- Enhanced Toggle Button -->
                                    <button type="button" 
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-red-500 transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100/50"
                                        @click="showCurrentPassword = !showCurrentPassword">
                                        <svg x-show="!showCurrentPassword" xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="showCurrentPassword" xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 6.18A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.959 9.959 0 01-4.046 5.032M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M3 3l18 18"/>
                                        </svg>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-600 text-sm font-medium" />
                            </div>

                            <!-- Enhanced New Password with Strength Indicator -->
                            <div class="space-y-2 group">
                                <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 font-semibold text-sm" />
                                <div class="relative">
                                    <input 
                                        id="update_password_password" 
                                        name="password" 
                                        x-bind:type="showNewPassword ? 'text' : 'password'"
                                        x-model="newPassword"
                                        @input="checkPasswordMatch()"
                                        class="block w-full rounded-2xl border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-30 bg-gray-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pl-12 pr-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm hover:bg-white/70" 
                                        autocomplete="new-password"
                                        placeholder="Enter your new password"
                                    />
                                    
                                    <!-- Key Icon -->
                                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                    </div>

                                    <!-- Enhanced Toggle Button -->
                                    <button type="button" 
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-red-500 transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100/50"
                                        @click="showNewPassword = !showNewPassword">
                                        <svg x-show="!showNewPassword" xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="showNewPassword" xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 6.18A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.959 9.959 0 01-4.046 5.032M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M3 3l18 18"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Password Strength Indicator -->
                                <div x-show="newPassword.length > 0" class="mt-3 space-y-2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600 font-medium">Password Strength</span>
                                        <span class="font-semibold" :class="passwordStrength < 30 ? 'text-red-600' : passwordStrength < 60 ? 'text-yellow-600' : passwordStrength < 80 ? 'text-blue-600' : 'text-green-600'" x-text="passwordStrengthText"></span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full transition-all duration-500" :class="passwordStrengthColor" :style="'width: ' + passwordStrength + '%'"></div>
                                    </div>
                                </div>
                                
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-600 text-sm font-medium" />
                            </div>

                            <!-- Enhanced Confirm Password -->
                            <div class="space-y-2 group">
                                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-semibold text-sm" />
                                <div class="relative">
                                    <input 
                                        id="update_password_password_confirmation" 
                                        name="password_confirmation" 
                                        x-bind:type="showConfirmPassword ? 'text' : 'password'"
                                        x-model="confirmPassword"
                                        @input="checkPasswordMatch()"
                                        :class="passwordMatchClass"
                                        autocomplete="new-password"
                                        placeholder="Confirm your new password"
                                    />
                                    
                                    <!-- Shield Icon -->
                                    <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400 group-focus-within:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    </div>

                                    <!-- Enhanced Toggle Button -->
                                    <button type="button" 
                                        class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-red-500 transition-colors duration-200 p-1 rounded-lg hover:bg-gray-100/50"
                                        @click="showConfirmPassword = !showConfirmPassword">
                                        <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" 
                                            class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 6.18A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.959 9.959 0 01-4.046 5.032M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                d="M3 3l18 18"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Password Match Indicator -->
                                <div x-show="confirmPassword.length > 0" class="mt-2" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                    <div x-show="passwordsMatch" class="flex items-center gap-2 text-sm text-emerald-600 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span>Passwords match</span>
                                    </div>
                                    <div x-show="!passwordsMatch" class="flex items-center gap-2 text-sm text-red-600 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        <span>Passwords do not match</span>
                                    </div>
                                </div>
                                
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-600 text-sm font-medium" />
                            </div>

                            <!-- Enhanced Save Button -->
                            <div class="flex items-center gap-4 pt-4">
                                <x-primary-button class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:from-red-700 focus:to-red-800 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 active:from-red-900 active:to-red-900 transition-all duration-300 px-8 py-3 rounded-2xl font-semibold text-white shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/30 transform hover:scale-[1.02]">
                                    {{ __('Update Password') }}
                                </x-primary-button>

                                @if (session('status') === 'password-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 transform scale-90"
                                        x-transition:enter-end="opacity-100 transform scale-100"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100"
                                        x-transition:leave-end="opacity-0"
                                        x-init="setTimeout(() => show = false, 4000)"
                                        class="text-sm text-emerald-700 font-semibold bg-emerald-50 px-4 py-2 rounded-full border border-emerald-200 flex items-center gap-2 shadow-sm"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        {{ __('Password updated successfully') }}
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Delete Account Section -->
            <div class="group hover:transform hover:scale-[1.01] transition-all duration-300">
                <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-white/50 overflow-hidden hover:shadow-2xl hover:shadow-red-500/10 transition-all duration-300">
                    <div class="border-gradient-to-b from-red-500 to-red-600 p-8 lg:p-10">
                        <!-- Enhanced Section Header -->
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                                    {{ __('Delete Account') }}
                                </h2>
                                <p class="mt-1 text-gray-600 text-sm leading-relaxed">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Warning Card -->
                        <div class="mb-6 p-5 bg-gradient-to-r from-red-50 to-red-50/50 rounded-2xl border border-red-200 backdrop-blur-sm">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-semibold text-red-800 mb-1">Before deleting your account</h3>
                                    <p class="text-sm text-red-700 leading-relaxed">
                                        Please download any data or information that you wish to retain. This action cannot be undone.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:from-red-700 focus:to-red-800 active:from-red-900 active:to-red-900 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 transition-all duration-300 px-8 py-3 rounded-2xl font-semibold text-white shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/30 transform hover:scale-[1.02]"
                        >
                            {{ __('Delete Account') }}
                        </x-danger-button>

                        <!-- Enhanced Modal -->
                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <div class="bg-white/95 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/50 max-w-md mx-auto overflow-hidden">
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-8 space-y-6">
                                    @csrf
                                    @method('delete')

                                    <!-- Modal Header with Enhanced Styling -->
                                    <div class="text-center">
                                        <div class="w-20 h-20 bg-gradient-to-br from-red-500 to-red-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-red-500/25">
                                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-2xl font-bold text-gray-900 mb-3">
                                            {{ __('Are you sure?') }}
                                        </h2>
                                        <p class="text-gray-600 leading-relaxed mb-6">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                        </p>
                                    </div>

                                    <!-- Enhanced Password Field -->
                                    <div class="space-y-2">
                                        <x-input-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-semibold text-sm" />
                                        <div class="relative">
                                            <x-text-input
                                                id="password"
                                                name="password"
                                                type="password"
                                                class="block w-full rounded-2xl border-gray-200 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-30 bg-gray-50/50 focus:bg-white transition-all duration-300 px-4 py-3.5 pl-12 text-gray-900 shadow-sm backdrop-blur-sm"
                                                placeholder="{{ __('Enter your password') }}"
                                            />
                                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600 text-sm font-medium" />
                                    </div>

                                    <!-- Enhanced Action Buttons -->
                                    <div class="flex gap-3 pt-4">
                                        <x-secondary-button x-on:click="$dispatch('close')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-2xl py-3 font-semibold transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-[1.02]">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-danger-button class="flex-1 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:from-red-700 focus:to-red-800 active:from-red-900 active:to-red-900 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 rounded-2xl py-3 font-semibold text-white transition-all duration-300 shadow-lg shadow-red-500/25 hover:shadow-xl hover:shadow-red-500/30 transform hover:scale-[1.02]">
                                            {{ __('Delete Account') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </div>
                        </x-modal>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Enhanced Alpine.js Script -->
    <script>
        function passwordForm() {
            return {
                currentPassword: '',
                newPassword: '',
                confirmPassword: '',
                showCurrentPassword: false,
                showNewPassword: false,
                showConfirmPassword: false,
                passwordStrength: 0,
                passwordsMatch: false,
                
                checkPasswordMatch() {
                    this.passwordsMatch = this.newPassword === this.confirmPassword && this.newPassword.length > 0;
                    this.calculatePasswordStrength();
                },
                
                calculatePasswordStrength() {
                    let score = 0;
                    if (!this.newPassword) {
                        this.passwordStrength = 0;
                        return;
                    }
                    
                    // Length scoring
                    if (this.newPassword.length >= 8) score += 25;
                    if (this.newPassword.length >= 12) score += 25;
                    
                    // Character variety scoring
                    if (/[a-z]/.test(this.newPassword)) score += 12.5;
                    if (/[A-Z]/.test(this.newPassword)) score += 12.5;
                    if (/[0-9]/.test(this.newPassword)) score += 12.5;
                    if (/[^A-Za-z0-9]/.test(this.newPassword)) score += 12.5;
                    
                    this.passwordStrength = Math.min(100, score);
                },
                
                get passwordStrengthColor() {
                    if (this.passwordStrength < 30) return 'bg-red-500';
                    if (this.passwordStrength < 60) return 'bg-yellow-500';
                    if (this.passwordStrength < 80) return 'bg-blue-500';
                    return 'bg-green-500';
                },
                
                get passwordStrengthText() {
                    if (this.passwordStrength < 30) return 'Weak';
                    if (this.passwordStrength < 60) return 'Fair';
                    if (this.passwordStrength < 80) return 'Good';
                    return 'Strong';
                },
                
                get passwordMatchClass() {
                    const baseClasses = 'block w-full rounded-2xl focus:ring-2 focus:ring-opacity-30 transition-all duration-300 px-4 py-3.5 pl-12 pr-12 text-gray-900 placeholder-gray-400 shadow-sm backdrop-blur-sm hover:bg-white/70';
                    
                    if (this.confirmPassword.length === 0) {
                        return `${baseClasses} border-gray-200 focus:border-red-500 focus:ring-red-500 bg-gray-50/50 focus:bg-white`;
                    }
                    
                    return this.passwordsMatch ? 
                        `${baseClasses} border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500 bg-emerald-50/50 focus:bg-white` :
                        `${baseClasses} border-red-300 focus:border-red-500 focus:ring-red-500 bg-red-50/50 focus:bg-white`;
                }
            }
        }
    </script>
</x-app-layout>