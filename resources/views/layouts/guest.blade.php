    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'LMS') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

  
</head>
<body class="font-sans antialiased maroon-gradient-bg text-white">
    
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-8 relative z-10 floating-shapes">    
        {{-- Larger Auth Card --}}
     
            
        
            <div>
                {{ $slot }}
            </div>
      

        {{-- Enhanced Footer --}}
        <div class="mt-10 text-center text-sm text-white/70 space-y-3">
            <div class="flex items-center justify-center space-x-3">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 maroon-accent bg-white rounded-full p-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">Capstone Project 2025</span>
                </div>
            </div>
            <div class="flex items-center justify-center space-x-6 text-white/60">
                <span>Built with Laravel</span>
                <span>•</span>
                <span>Tailwind CSS</span>
                <span>•</span>
                <span>Modern Design</span>
            </div>
        </div>

        {{-- Mobile scroll indicator --}}
        <div class="fixed bottom-6 left-1/2 transform -translate-x-1/2 md:hidden">
            <div class="animate-bounce bg-white/10 rounded-full p-2">
                <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>
    </div>
</body>
</html>