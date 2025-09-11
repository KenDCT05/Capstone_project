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
                
                checkPasswordMatch() {
                    this.passwordsMatch = this.newPassword === this.confirmPassword && this.newPassword.length > 0;
                },
                
                get passwordMatchClass() {
                    if (this.confirmPassword.length === 0) {
                        return 'block w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 bg-gray-50 focus:bg-white transition-all duration-200 px-4 py-3 pr-20 text-gray-900 placeholder-gray-400 shadow-sm';
                    }
                    return this.passwordsMatch ? 
                        'block w-full rounded-2xl border-green-200 focus:border-green-500 focus:ring-green-500 focus:ring-2 focus:ring-opacity-20 bg-green-50 focus:bg-white transition-all duration-200 px-4 py-3 pr-20 text-gray-900 placeholder-gray-400 shadow-sm' :
                        'block w-full rounded-2xl border-red-200 focus:border-red-500 focus:ring-red-500 focus:ring-2 focus:ring-opacity-20 bg-red-50 focus:bg-white transition-all duration-200 px-4 py-3 pr-20 text-gray-900 placeholder-gray-400 shadow-sm';
                }
            }
        }
    </script>
    
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-red-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Profile Information -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="border-l-4 border-red-600 p-8">
                    <section>
                        <header class="mb-8">
                            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                                {{ __('Profile Information') }}
                            </h2>
                            <p class="mt-2 text-gray-600 text-sm leading-relaxed">
                                {{ __("Update your account's profile information and email address.") }}
                            </p>
                        </header>

                        <!-- Resend Verification Form -->
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <!-- Update Profile Form -->
                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            <!-- Name -->
                            <div class="space-y-2">
                                <x-input-label for="name" :value="__('Name')" class="text-gray-700 font-medium text-sm" />
                                <x-text-input 
                                    id="name" 
                                    name="name" 
                                    type="text" 
                                    class="block w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 bg-gray-50 focus:bg-white transition-all duration-200 px-4 py-3 text-gray-900 placeholder-gray-400 shadow-sm" 
                                    :value="old('name', $user->name)" 
                                    required 
                                    autofocus 
                                    autocomplete="name" 
                                />
                                <x-input-error class="mt-2 text-red-600 text-sm" :messages="$errors->get('name')" />
                            </div>

                            <!-- Email -->
                            <div class="space-y-2">
                                <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium text-sm" />
                                <x-text-input 
                                    id="email" 
                                    name="email" 
                                    type="email" 
                                    class="block w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 bg-gray-50 focus:bg-white transition-all duration-200 px-4 py-3 text-gray-900 placeholder-gray-400 shadow-sm" 
                                    :value="old('email', $user->email)" 
                                    required 
                                    autocomplete="username" 
                                />
                                <x-input-error class="mt-2 text-red-600 text-sm" :messages="$errors->get('email')" />

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-3 p-4 bg-red-50 rounded-2xl border border-red-100">
                                        <p class="text-sm text-red-700">
                                            {{ __('Your email address is unverified.') }}
                                            <button 
                                                form="send-verification" 
                                                class="ml-1 font-medium text-red-600 hover:text-red-700 underline underline-offset-2 focus:outline-none focus:ring-2 focus:ring-red-600 focus:ring-opacity-20 rounded-md transition-colors duration-200"
                                            >
                                                {{ __('Click here to re-send the verification email.') }}
                                            </button>
                                        </p>

                                        @if (session('status') === 'verification-link-sent')
                                            <p class="mt-2 font-medium text-sm text-green-700">
                                                {{ __('A new verification link has been sent to your email address.') }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-4 pt-2">
                                <x-primary-button class="bg-red-600 hover:bg-red-700 focus:bg-red-700 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 active:bg-red-900 transition-all duration-200 px-6 py-2.5 rounded-2xl font-medium">
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
                                        x-init="setTimeout(() => show = false, 3000)"
                                        class="text-sm text-green-700 font-medium bg-green-50 px-3 py-1 rounded-full"
                                    >
                                        {{ __('Saved successfully') }}
                                    </p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>

            <!-- Update Password -->
<!-- Update Password -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="border-l-4 border-red-600 p-8" x-data="passwordForm()">
            <section>
                <header class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                        {{ __('Update Password') }}
                    </h2>
                    <p class="mt-2 text-gray-600 text-sm leading-relaxed">
                        {{ __('Ensure your account is using a long, random password to stay secure.') }}
                    </p>
                </header>

                <form method="post" action="{{ route('profile-change.password') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <!-- Current Password -->
                    <div class="space-y-2">
                        <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-gray-700 font-medium text-sm" />
                        <div class="relative">
                            <input 
                                id="update_password_current_password" 
                                name="current_password" 
                                x-bind:type="showCurrentPassword ? 'text' : 'password'"
                                class="block w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-red-600 
                                    focus:ring-2 focus:ring-opacity-20 bg-gray-50 focus:bg-white transition-all 
                                    duration-200 px-4 py-3 pr-12 text-gray-900 placeholder-gray-400 shadow-sm" 
                                autocomplete="current-password" 
                            />

                            <!-- Toggle eye -->
                            <button type="button" 
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
                                @click="showCurrentPassword = !showCurrentPassword">
                                <!-- Eye -->
                                <svg x-show="!showCurrentPassword" xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                                            9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <!-- Eye off -->
                                <svg x-show="showCurrentPassword" xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 
                                            0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 
                                            6.18A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 
                                            9.542 7a9.959 9.959 0 01-4.046 5.032M15 12a3 3 0 
                                            11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- New Password -->
                    <div class="space-y-2">
                        <x-input-label for="update_password_password" :value="__('New Password')" class="text-gray-700 font-medium text-sm" />
                        <div class="relative">
                            <input 
                                id="update_password_password" 
                                name="password" 
                                x-bind:type="showNewPassword ? 'text' : 'password'"
                                x-model="newPassword"
                                class="block w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-red-600 
                                    focus:ring-2 focus:ring-opacity-20 bg-gray-50 focus:bg-white transition-all 
                                    duration-200 px-4 py-3 pr-12 text-gray-900 placeholder-gray-400 shadow-sm" 
                                autocomplete="new-password" 
                            />

                            <!-- Toggle eye -->
                            <button type="button" 
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
                                @click="showNewPassword = !showNewPassword">
                                <svg x-show="!showNewPassword" xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                                            9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showNewPassword" xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 
                                            0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 
                                            6.18A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 
                                            9.542 7a9.959 9.959 0 01-4.046 5.032M15 12a3 3 0 
                                            11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-gray-700 font-medium text-sm" />
                        <div class="relative">
                            <input 
                                id="update_password_password_confirmation" 
                                name="password_confirmation" 
                                x-bind:type="showConfirmPassword ? 'text' : 'password'"
                                x-model="confirmPassword"
                                class="block w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-red-600 
                                    focus:ring-2 focus:ring-opacity-20 bg-gray-50 focus:bg-white transition-all 
                                    duration-200 px-4 py-3 pr-12 text-gray-900 placeholder-gray-400 shadow-sm" 
                                autocomplete="new-password" 
                            />

                            <!-- Toggle eye -->
                            <button type="button" 
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600"
                                @click="showConfirmPassword = !showConfirmPassword">
                                <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 
                                            9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" 
                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 
                                            0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.18 
                                            6.18A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 
                                            9.542 7a9.959 9.959 0 01-4.046 5.032M15 12a3 3 0 
                                            11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                        d="M3 3l18 18"/>
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-600 text-sm" />
                    </div>

                    <!-- Save Button -->
                    <div class="flex items-center gap-4 pt-2">
                        <x-primary-button class="bg-red-600 hover:bg-red-700 focus:bg-red-700 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 active:bg-red-900 transition-all duration-200 px-6 py-2.5 rounded-2xl font-medium">
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
                                x-init="setTimeout(() => show = false, 3000)"
                                class="text-sm text-green-700 font-medium bg-green-50 px-3 py-1 rounded-full"
                            >
                                {{ __('Password updated successfully') }}
                            </p>
                        @endif
                    </div>
                </form>
            </section>
        </div>
    </div>


            <!-- Delete Account -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="border-l-4 border-red-600 p-8">
                    <section class="space-y-6">
                        <header>
                            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">
                                {{ __('Delete Account') }}
                            </h2>
                            <p class="mt-2 text-gray-600 text-sm leading-relaxed">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                            </p>
                        </header>

                        <x-danger-button
                            x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                            class="bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 transition-all duration-200 px-6 py-2.5 rounded-2xl font-medium text-white shadow-sm"
                        >
                            {{ __('Delete Account') }}
                        </x-danger-button>

                        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                            <div class="bg-white rounded-3xl shadow-xl border border-gray-200 max-w-md mx-auto">
                                <form method="post" action="{{ route('profile.destroy') }}" class="p-8 space-y-6">
                                    @csrf
                                    @method('delete')

                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                                            </svg>
                                        </div>
                                        <h2 class="text-xl font-bold text-gray-900 mb-2">
                                            {{ __('Are you sure you want to delete your account?') }}
                                        </h2>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                        </p>
                                    </div>

                                    <div class="space-y-2">
                                        <x-input-label for="password" value="{{ __('Password') }}" class="text-gray-700 font-medium text-sm" />
                                        <x-text-input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="block w-full rounded-2xl border-gray-200 focus:border-red-600 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 bg-gray-50 focus:bg-white transition-all duration-200 px-4 py-3 text-gray-900 shadow-sm"
                                            placeholder="{{ __('Enter your password') }}"
                                        />
                                        <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600 text-sm" />
                                    </div>

                                    <div class="flex gap-3 pt-2">
                                        <x-secondary-button x-on:click="$dispatch('close')" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-2xl py-2.5 font-medium transition-all duration-200">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-danger-button class="flex-1 bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:ring-red-600 focus:ring-2 focus:ring-opacity-20 rounded-2xl py-2.5 font-medium text-white transition-all duration-200">
                                            {{ __('Delete Account') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </div>
                        </x-modal>
                    </section>
                </div>
            </div>

        </div>
    </div>
<script>
function passwordForm() {
    return {
        currentPassword: '',
        newPassword: '',
        confirmPassword: '',
        showCurrentPassword: false,
        showNewPassword: false,
        showConfirmPassword: false,
    }
}
</script>
</x-app-layout>