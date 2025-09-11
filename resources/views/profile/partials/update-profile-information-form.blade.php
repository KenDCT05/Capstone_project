<section>
    <header class="mb-6">
        <h2 class="text-xl font-semibold text-red-800">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-red-600/80">
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
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-red-700" />
            <x-text-input 
                id="name" 
                name="name" 
                type="text" 
                class="mt-1 block w-full rounded-xl border-red-300 focus:border-red-500 focus:ring-red-500 bg-white/80 shadow-sm" 
                :value="old('name', $user->name)" 
                required 
                autofocus 
                autocomplete="name" 
            />
            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-red-700" />
            <x-text-input 
                id="email" 
                name="email" 
                type="email" 
                class="mt-1 block w-full rounded-xl border-red-300 focus:border-red-500 focus:ring-red-500 bg-white/80 shadow-sm" 
                :value="old('email', $user->email)" 
                required 
                autocomplete="username" 
            />
            <x-input-error class="mt-2 text-red-600" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-red-700">
                        {{ __('Your email address is unverified.') }}

                        <button 
                            form="send-verification" 
                            class="ml-2 text-sm font-medium text-red-600 hover:text-red-800 underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 rounded-md"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-red-600 hover:bg-red-700 focus:ring-red-500">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
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
