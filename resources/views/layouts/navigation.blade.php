<nav x-data="{ 
        open: false, 
        userDropdownOpen: false,
        scrolled: false 
    }" 
     x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 10)"
     :class="{ 'bg-red-600/95': scrolled, 'bg-red-600/80': !scrolled }"
     class="text-white shadow-lg sticky top-0 z-50 border-b border-red-800/30 backdrop-blur-md transition-all duration-300"
     style="background: linear-gradient(135deg, #EF4444 0%, #DC2626 30%, #B91C1C 70%, #e03c3c 100%);">

    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo with improved animation -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center space-x-2 group relative"
                   aria-label="Go to Dashboard">
                    <x-application-logo class="block h-9 w-auto fill-current text-white group-hover:scale-110 transition-all duration-300 drop-shadow-md" />
                    <span class="font-extrabold text-xl tracking-wide text-white group-hover:text-red-200 transition-colors duration-300">
                        GSSM
                    </span>
                    <!-- Subtle glow effect on hover -->
                    <div class="absolute inset-0 rounded-lg opacity-0 group-hover:opacity-20 bg-white transition-opacity duration-300"></div>
                </a>
            </div>



            <!-- User Dropdown with improved UX -->
            <div class="hidden sm:flex sm:items-center">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" 
                            @click.away="open = false"
                            :aria-expanded="open"
                            aria-haspopup="true"
                            class="flex items-center px-4 py-2 text-sm font-medium rounded-xl bg-red-500/80 hover:bg-red-600 shadow-md transition-all duration-300 focus:ring-2 focus:ring-red-300 focus:ring-opacity-50 backdrop-blur-sm group">
                        
                        <!-- User Avatar (optional) -->
                        {{-- <div class="w-6 h-6 rounded-full bg-red-600 flex items-center justify-center mr-3 text-xs font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div> --}}
                        
                        <span class="mr-2 hidden md:inline text-white font-semibold truncate max-w-32">
                            {{ Auth::user()->name }}
                        </span>
                        
                        <svg class="w-4 h-4 text-white transition-transform duration-300" 
                             :class="{ 'rotate-180': open }"
                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 origin-top-right">
                        
                        <div class="py-2 bg-white/95 backdrop-blur-md text-gray-800 shadow-xl rounded-xl border border-red-100/40 ring-1 ring-black/5">
                            <!-- User Info Header -->
                            <div class="px-4 py-3 border-b border-red-100">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            
                            <!-- Menu Items -->
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    {{ __('Profile') }}
                                </a>
                                
                                <!-- Add more menu items as needed -->
                                {{--
                                <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Settings
                                </a>
                                --}}
                            </div>
                            
                            <!-- Logout -->
                            <div class="border-t border-red-100 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:text-red-800 hover:bg-red-50 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Mobile Hamburger -->
            <div class="sm:hidden">
                <button @click="open = !open" 
                        :aria-expanded="open"
                        aria-label="Toggle navigation menu"
                        class="p-2 rounded-lg text-white hover:bg-red-700/50 focus:outline-none focus:ring-2 focus:ring-red-300 transition-all duration-200 backdrop-blur-sm">
                    <svg class="h-6 w-6 transition-transform duration-300" 
                         :class="{ 'rotate-90': open }"
                         stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" 
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" 
                              class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Responsive Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="sm:hidden bg-red-900/95 text-white border-t border-red-800/50 backdrop-blur-md shadow-lg">
        
        <!-- Navigation Links -->
        <div class="pt-3 pb-2 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" 
               class="flex items-center px-3 py-3 rounded-lg text-base font-medium transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-red-800 text-red-100' : 'text-white hover:bg-red-800/50 hover:text-red-100' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                {{ __('Dashboard') }}
            </a>
            
            <!-- Add more mobile navigation items as needed -->
        </div>

        <!-- Enhanced User Section -->
        <div class="pt-4 pb-4 border-t border-red-800/50">
            <!-- User Info with better layout -->
            <div class="px-4 mb-3">
                <div class="flex items-center space-x-3 p-3 bg-red-800/30 rounded-lg backdrop-blur-sm">
                    <div class="relative flex-shrink-0">
                        <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-400 rounded-full border-2 border-white shadow-sm animate-pulse"></span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-base text-white truncate">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-red-200 truncate">{{ Auth::user()->email }}</div>
                    </div>
                </div>
            </div>

            <!-- Action Links -->
            <div class="px-4 space-y-1">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center px-3 py-3 rounded-lg text-white hover:bg-red-800/50 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    {{ __('Profile') }}
                </a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full px-3 py-3 rounded-lg text-red-300 hover:bg-red-700/50 hover:text-white transition-colors duration-200">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>