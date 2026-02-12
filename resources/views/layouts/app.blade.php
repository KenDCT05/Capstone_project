<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

       @vite(['resources/css/app.css', 'resources/js/app.js'])


    <style>
        /* Custom red-maroon theme styles */
        .bg-red-maroon-gradient {
            background: linear-gradient(135deg, #fff1f2 0%, #fee2e2 50%, #fdf2f8 100%);
            /* background: linear-gradient(135deg, #8B1538 0%, #B91C1C 30%, #DC2626 70%, #EF4444 100%); */
        }

        .bg-soft-maroon {
            background: linear-gradient(to right, #a83232, #d32f2f);
        }

        .shadow-maroon {
            box-shadow: 0 10px 25px rgba(179, 38, 30, 0.15);
        }

        .border-gradient {
            border-image: linear-gradient(45deg, #7b1c1c, #a83232, #fbbf24) 1;
        }

        .text-gradient {
            background: linear-gradient(135deg, #7b1c1c, #a83232, #d32f2f);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px rgba(179, 38, 30, 0.2);
        }

        .glass-effect {
            background: rgba(168, 50, 50, 0.25);
            border: 1px solid rgba(168, 50, 50, 0.1);
        }

        @media (max-width: 768px) {
            .glass-effect {
                margin: 0 1rem;
                border-radius: 1rem;
            }
        }
    </style>
</head>
<body class="font-sans antialiased bg-red-maroon-gradient min-h-screen">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="glass-effect shadow-maroon hover-lift">
                <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                    <div class="font-semibold text-xl text-white">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="">
                    {{ $slot }}
        </main>
    </div>

    <!-- Decorative elements -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
        <div class="absolute top-10 left-10 w-32 h-32 bg-red-600/20 rounded-full blur-xl"></div>
        <div class="absolute top-1/3 right-20 w-24 h-24 bg-rose-700/30 rounded-full blur-lg"></div>
        <div class="absolute bottom-20 left-1/4 w-20 h-20 bg-red-800/25 rounded-full blur-lg"></div>
        <div class="absolute bottom-1/3 right-1/3 w-28 h-28 bg-red-700/15 rounded-full blur-xl"></div>
    </div>

    @stack('scripts')
<script>
    let startTime = Date.now();
let isActive = true;

// Track when user becomes inactive
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        isActive = false;
        logTimeSpent();
    } else {
        startTime = Date.now();
        isActive = true;
    }
});

// Log time when user leaves page
window.addEventListener('beforeunload', function() {
    if (isActive) {
        logTimeSpent();
    }
});

// Send time spent to server every 5 minutes for active users
setInterval(function() {
    if (isActive) {
        logTimeSpent();
        startTime = Date.now(); // Reset timer
    }
}, 1 * 60 * 1000); // 5 minutes

function logTimeSpent() {
    const timeSpent = Math.round((Date.now() - startTime) / 1000); // in seconds
    
    if (timeSpent > 10) { // Only log if more than 10 seconds
        fetch('/log-time-spent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                time_spent: timeSpent,
                page: window.location.pathname
            })
        }).catch(err => console.log('Time logging failed:', err));
    }
}
</script>
</body>
</html>
