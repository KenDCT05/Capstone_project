<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-red-800">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-red-600/80">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('change-password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-red-700" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full rounded-xl border-red-300 focus:border-red-500 focus:ring-red-500 bg-white/80 shadow-sm" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-600" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-red-700" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full rounded-xl border-red-300 focus:border-red-500 focus:ring-red-500 bg-white/80 shadow-sm" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-600" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-red-700" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full rounded-xl border-red-300 focus:border-red-500 focus:ring-red-500 bg-white/80 shadow-sm" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <!-- Save Button -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-red-600 hover:bg-red-700 focus:ring-red-500">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-red-600"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
