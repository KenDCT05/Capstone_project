<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Great Shepherd School of Magalang - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #8B1538 0%, #B91C1C 30%, #DC2626 70%, #EF4444 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        
        .glass-card {
            background: rgba(139, 21, 56, 0.3);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .floating-animation {
            animation: float 8s ease-in-out infinite;
        }
        
        .floating-animation:nth-child(2) {
            animation-delay: -2s;
        }
        
        .floating-animation:nth-child(3) {
            animation-delay: -4s;
        }
        
        .floating-animation:nth-child(4) {
            animation-delay: -6s;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(2deg); }
            50% { transform: translateY(-25px) rotate(0deg); }
            75% { transform: translateY(-10px) rotate(-2deg); }
        }
        
        .hover-lift {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .hover-lift:hover {
            transform: translateY(-3px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #16A34A 0%, #22C55E 100%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 197, 94, 0.4);
            background: linear-gradient(135deg, #15803D 0%, #16A34A 100%);
        }
        
        .feature-check {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
        }
        
        .book-icon-bg {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
        }
        
        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg">
    <!-- Floating Background Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="floating-animation absolute top-20 left-10 w-24 h-24 bg-white bg-opacity-5 rounded-full"></div>
        <div class="floating-animation absolute top-1/3 right-20 w-32 h-32 bg-white bg-opacity-5 rounded-full"></div>
        <div class="floating-animation absolute bottom-1/3 left-20 w-16 h-16 bg-white bg-opacity-5 rounded-full"></div>
        <div class="floating-animation absolute bottom-20 right-10 w-28 h-28 bg-white bg-opacity-5 rounded-full"></div>
        <div class="floating-animation absolute top-1/2 left-1/2 w-20 h-20 bg-white bg-opacity-3 rounded-full"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 py-12 relative z-10">
        <div class="w-full max-w-6xl">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-24 h-24 book-icon-bg rounded-3xl mb-8 pulse-animation">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-4 tracking-tight">Welcome to Great Shepherd School of Magalang</h1>
                <p class="text-medium text-white text-opacity-90 max-w-3xl mx-auto leading-relaxed">Your partner in molding your <span class="font-semibold text-white">beloved children</span> to be <span class="font-bold text-white ">G</span>odly, <span class="font-bold text-white ">S</span>uccessful, <span class="font-bold text-white  ">S</span>ignificant, <span class="font-bold text-white ">M</span>odel.</p>
            </div>

            <!-- Main Card -->
            <div class="glass-card rounded-3xl p-8 md:p-12 hover-lift">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <!-- Left Side - Content -->
                    <div class="space-y-8">
                        <div>
                            <h2 class="text-3xl font-bold text-black-900 mb-4">LMS</h2>
                            <p class="text-lg text-white text-opacity-90 font-medium mb-6">Learning Management System</p>
                            <p class="text-white text-opacity-80 text-base leading-relaxed">
                                Experience the future of education with our smart and intuitive classroom platform. 
                                Built for learners, parents, and educators to thrive in the digital age.
                            </p>
                        </div>
                        
                        <!-- Features -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 feature-check rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-white text-opacity-90 text-base">Interactive Learning Experience</span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 feature-check rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-white text-opacity-90 text-base">Progress Tracking & Analytics</span>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 feature-check rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <span class="text-white text-opacity-90 text-base">Early Warning System</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side - CTA -->
                    <div class="text-center space-y-6">
                        <div class="glass-effect rounded-3xl p-8 hover-lift">
                            <div class="w-20 h-20 book-icon-bg rounded-3xl mx-auto mb-6 flex items-center justify-center">
                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-white mb-4">Ready to Start?</h3>
                            <p class="text-white text-opacity-80 mb-6 text-base">Join other learners and educators already using our platform.</p>
                            
                            <!-- Login Button -->
                            <button onclick="handleLogin()" class="btn-primary w-full text-white font-bold py-3 px-6 rounded-2xl text-lg hover-lift">
                                Log In to Your Account
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->

        </div>
    </div>

    <script>
        function handleLogin() {
            window.location.href = "{{ route('login') }}";
        }
        
        // Enhanced interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.hover-lift');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px) scale(1.02)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });

            // Add subtle parallax effect to floating elements
            document.addEventListener('mousemove', function(e) {
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;
                
                const floatingElements = document.querySelectorAll('.floating-animation');
                floatingElements.forEach((element, index) => {
                    const speed = (index + 1) * 0.5;
                    const x = (mouseX - 0.5) * speed;
                    const y = (mouseY - 0.5) * speed;
                    element.style.transform += ` translate(${x}px, ${y}px)`;
                });
            });
        });
    </script>
</body>
</html>