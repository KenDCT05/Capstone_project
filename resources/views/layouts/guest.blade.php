<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GSSM') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .split-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Logo Side */
        .logo-side {
            flex: 1;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .logo-side::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(220, 38, 38, 0.1) 0%, transparent 70%);
            animation: float 20s ease-in-out infinite;
        }

        .logo-container {
            position: relative;
            z-index: 10;
            width: 400px;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: logoFloat 15s ease-in-out infinite;
        }

        .logo-container svg,
        .logo-container img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            opacity: 1;
        }

        /* Form Side */
        .form-side {
            flex: 1;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 50%, #7f1d1d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .form-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(220, 38, 38, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(153, 27, 27, 0.03) 0%, transparent 50%);
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 2rem;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 4rem 3rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            min-height: 70vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #dc2626, #991b1b, #7f1d1d);
            border-radius: 1.5rem 1.5rem 0 0;
        }

        .auth-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 35px 70px -12px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.9);
        }

        /* Decorative Elements */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .shape-1 {
            width: 100px;
            height: 100px;
            top: 10%;
            right: 15%;
            animation: floatShape 18s ease-in-out infinite;
        }

        .shape-2 {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 10%;
            animation: floatShape 15s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 80px;
            height: 80px;
            top: 60%;
            right: 25%;
            animation: floatShape 20s ease-in-out infinite;
            animation-delay: -5s;
        }

        /* Footer */
        .split-footer {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            right: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 20;
        }

        .footer-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 2rem;
            padding: 0.75rem 1.5rem;
            color: white;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .tech-stack {
            display: flex;
            gap: 1rem;
            color: #f1f5f9;
            font-size: 0.875rem;
        }

        .tech-item {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        @keyframes logoFloat {
            0%, 100% { 
                transform: scale(1) rotate(0deg); 
                opacity: 0.9;
            }
            50% { 
                transform: scale(1.05) rotate(2deg); 
                opacity: 1;
            }
        }

        @keyframes floatShape {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg); 
                opacity: 0.5;
            }
            33% { 
                transform: translateY(-30px) translateX(20px) rotate(120deg); 
                opacity: 0.8;
            }
            66% { 
                transform: translateY(20px) translateX(-15px) rotate(240deg); 
                opacity: 0.3;
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .split-layout {
                flex-direction: column;
            }

            .logo-side {
                min-height: 40vh;
            }

            .form-side {
                min-height: 60vh;
                padding: 1.5rem;
            }

            .logo-container {
                width: 300px;
                height: 300px;
            }

            .auth-card {
                padding: 2.5rem 2rem;
            }

            .split-footer {
                position: relative;
                bottom: auto;
                left: auto;
                right: auto;
                margin-top: 2rem;
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }

        @media (max-width: 640px) {
            .logo-side {
                min-height: 30vh;
            }

            .form-side {
                min-height: 70vh;
                padding: 1rem;
            }

            .logo-container {
                width: 200px;
                height: 200px;
            }

            .auth-card {
                padding: 2rem 1.5rem;
            }

            .tech-stack {
                flex-direction: column;
                gap: 0.5rem;
            }

            .floating-shapes {
                display: none;
            }
        }

        /* Accessibility improvements */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="split-layout">
        {{-- Logo Side --}}
        <div class="logo-side">
            <div class="floating-shapes">
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                <div class="shape shape-3"></div>
            </div>
            
            <div class="logo-container">
                <x-application-logo />
            </div>

        </div>

        {{-- Form Side --}}
        <div class="form-side">
            <div class="form-container">
                    <!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<!-- Error Messages -->
@if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif
    @if(session('info'))
        <div class="info-message">
            {{ session('info') }}
        </div>
    @endif
                <div class="auth-card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    {{-- Split Footer --}}
    <div class="split-footer">
        <div class="tech-item">
            <span>Capstone Project 2025</span>
        </div>
        
        <div class="tech-stack">
            <div class="tech-item">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span>Laravel</span>
            </div>
            <div class="tech-item">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                </svg>
                <span>Tailwind CSS</span>
            </div>
            <div class="tech-item">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                </svg>
                <span>Modern Design</span>
            </div>
        </div>
    </div>
</body>
</html>