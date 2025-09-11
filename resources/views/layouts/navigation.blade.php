<nav x-data="{ open: false }" 
     class="text-white shadow-lg sticky top-0 z-40 border-b border-red-800/30 backdrop-blur-md"
     style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 30%, #B91C1C 70%, #7F1D1D 100%);">

    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
                    <x-application-logo class="block h-9 w-auto fill-current text-white group-hover:scale-110 transition-transform duration-300" />
                    <span class="font-extrabold text-xl tracking-wide text-white group-hover:text-red-200">GSSM</span>
                </a>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-4 py-2 text-sm font-medium rounded-xl bg-red-800 hover:bg-red-700 shadow-md transition-all duration-300 focus:ring-2 focus:ring-red-500">
                            <span class="mr-2 hidden md:inline text-white font-semibold">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 text-white transition-transform duration-300 group-hover:rotate-180" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="py-2 bg-white text-gray-800 shadow-xl rounded-xl border border-red-100/40">
                            <x-dropdown-link :href="route('profile.edit')" class="text-sm hover:bg-red-50 hover:text-red-700 px-3 py-2 rounded-md">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                            <div class="border-t border-red-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault(); this.closest('form').submit();"
                                                 class="text-sm text-red-600 hover:text-red-800 hover:bg-red-50 px-3 py-2 rounded-md">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="sm:hidden">
                <button @click="open = !open" 
                        class="p-2 rounded-lg text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-transform duration-200">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-red-900/95 text-white border-t border-red-800/50 backdrop-blur-md">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="block px-3 py-2 rounded-md hover:bg-red-800 transition-colors">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-3 border-t border-red-800">
            <div class="px-4 flex items-center space-x-3">
                <div class="relative">
                    <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('storage/images/default-profile.png') }}"
                         alt="{{ auth()->user()->name }}"
                         class="w-12 h-12 rounded-full object-cover ring-2 ring-white">
                    <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-white animate-pulse"></span>
                </div>
                <div>
                    <div class="font-semibold text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-red-200">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')" class="block px-3 py-2 rounded-md hover:bg-red-800">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();"
                                           class="block px-3 py-2 rounded-md text-red-300 hover:bg-red-700 hover:text-white">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
