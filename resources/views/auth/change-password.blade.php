<x-guest-layout>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #7c2d12 0%, #dc2626 25%, #be185d  75%, #7c2d12 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .strength-meter {
            height: 6px;
            background: #f3f4f6;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 8px;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .strength-fill {
            height: 100%;
            transition: all 0.4s ease;
            border-radius: 3px;
        }
        
        .input-shimmer {
            position: relative;
            overflow: hidden;
        }
        
        .input-shimmer::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.6s;
            z-index: 1;
            pointer-events: none;
        }
        
        .input-shimmer:focus-within::before {
            left: 100%;
        }
        
        .floating-particles {
            position: fixed;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }
        
        .particle {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: particle-float 15s infinite linear;
        }
        
        @keyframes particle-float {
            0% { 
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { 
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }
        
        .success-pulse {
            animation: success-pulse 0.6s ease-out;
        }
        
        @keyframes success-pulse {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .requirement-check {
            transition: all 0.3s ease;
        }
        
        .requirement-met {
            color: #10b981;
        }
        
        .requirement-met .check-icon {
            background: #10b981;
            color: white;
            border-radius: 50%;
        }
    </style>

    <!-- Floating Particles Background -->
    <div class="floating-particles">
        <div class="particle" style="left: 10%; width: 4px; height: 4px; animation-delay: 0s;"></div>
        <div class="particle" style="left: 20%; width: 6px; height: 6px; animation-delay: 2s;"></div>
        <div class="particle" style="left: 30%; width: 3px; height: 3px; animation-delay: 4s;"></div>
        <div class="particle" style="left: 40%; width: 5px; height: 5px; animation-delay: 6s;"></div>
        <div class="particle" style="left: 60%; width: 4px; height: 4px; animation-delay: 8s;"></div>
        <div class="particle" style="left: 70%; width: 7px; height: 7px; animation-delay: 10s;"></div>
        <div class="particle" style="left: 80%; width: 3px; height: 3px; animation-delay: 12s;"></div>
        <div class="particle" style="left: 90%; width: 5px; height: 5px; animation-delay: 14s;"></div>
    </div>

    <div class="min-h-screen flex items-center justify-center p-4 relative z-10">
        <!-- Password Change Form Section -->
        <div class="w-full max-w-md">
            <div class="glass-effect shadow-2xl rounded-3xl overflow-hidden border border-white/20 ">
                <div class="bg-gradient-to-br from-red-600 via-red-700 to-pink-600 px-8 py-8 relative">
                    <!-- Animated background pattern -->
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent transform -skew-x-12 animate-pulse"></div>
                    </div>
                    
                    <div class="relative z-10 text-center">
                        <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm transform hover:scale-110 transition-transform duration-300">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2">Change Your Password</h2>
                        <p class="text-white/90 text-sm">Secure your account with a strong new password</p>
                    </div>
                </div>
                
                <div class="p-8">
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 rounded-xl flex items-center success-pulse">
                            <div class="w-6 h-6 mr-3 flex-shrink-0 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">
                                    <svg class="w-4 h-4 inline mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    New Password *
                                </label>
                                <div class="input-shimmer relative">
                                    <input type="password" 
                                           name="password" 
                                           id="password"
                                           required 
                                           oninput="checkPasswordStrength(this.value)"
                                           class="w-full px-4 py-4 pr-12 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-300 outline-none text-gray-800 bg-white/80 backdrop-blur-sm shadow-sm hover:shadow-md" 
                                           placeholder="Enter your new password...">
                                    <button type="button" 
                                            onclick="togglePassword('password')"
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-600 transition-colors duration-200 z-10">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="eye-password">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                
                                <!-- Password Strength Meter -->

                                @error('password')
                                    <p class="text-red-600 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                                
                                <!-- Password Requirements -->
                                
                            </div>
                            
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-800 mb-3">
                                    <svg class="w-4 h-4 inline mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Confirm New Password *
                                </label>
                                <div class="input-shimmer relative">
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation"
                                           required 
                                           oninput="checkPasswordMatch()"
                                           class="w-full px-4 py-4 pr-12 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 transition-all duration-300 outline-none text-gray-800 bg-white/80 backdrop-blur-sm shadow-sm hover:shadow-md" 
                                           placeholder="Confirm your new password...">
                                    <button type="button" 
                                            onclick="togglePassword('password_confirmation')"
                                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-red-600 transition-colors duration-200 z-10">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="eye-password_confirmation">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <p id="matchText" class="text-xs text-gray-500 mt-1"></p>
                                @error('password_confirmation')
                                    <p class="text-red-600 text-sm mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-red-600 via-red-700 to-pink-600 hover:from-red-700 hover:via-red-800 hover:to-pink-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl flex items-center justify-center group">
                                    <svg class="w-5 h-5 mr-2 group-hover:rotate-12 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="group-hover:tracking-wide transition-all duration-300">Change Password</span>
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <!-- Enhanced Security Tips -->
                    <div class="strength-meter">
                    <div id="strengthBar" class="strength-fill bg-gray-300" style="width: 0%"></div>
                    </div>
                    <p id="strengthText" class="text-xs text-gray-500 mt-1">Password strength will be shown here</p>
                                
                    <div class="mt-3 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                    <p class="text-xs font-semibold text-gray-700 mb-2">Password Requirements:</p>
                                    <div class="space-y-1 text-xs">
                                        <div id="req-length" class="flex items-center requirement-check text-gray-500">
                                            <span class="w-4 h-4 mr-2 flex items-center justify-center border border-gray-300 rounded-full text-xs check-icon">✓</span>
                                            At least 8 characters
                                        </div>
                                        <div id="req-uppercase" class="flex items-center requirement-check text-gray-500">
                                            <span class="w-4 h-4 mr-2 flex items-center justify-center border border-gray-300 rounded-full text-xs check-icon">✓</span>
                                            One uppercase letter
                                        </div>
                                        <div id="req-lowercase" class="flex items-center requirement-check text-gray-500">
                                            <span class="w-4 h-4 mr-2 flex items-center justify-center border border-gray-300 rounded-full text-xs check-icon">✓</span>
                                            One lowercase letter
                                        </div>
                                        <div id="req-number" class="flex items-center requirement-check text-gray-500">
                                            <span class="w-4 h-4 mr-2 flex items-center justify-center border border-gray-300 rounded-full text-xs check-icon">✓</span>
                                            One number
                                        </div>
                                    </div>
                                </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eyeIcon = document.getElementById('eye-' + fieldId);
            
            if (field.type === 'password') {
                field.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.52 6.52m12.122 12.122L15.293 15.293m0 0L12 12m3.293 3.293l3.35 3.35"/>
                `;
            } else {
                field.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                `;
            }
        }

        function checkPasswordStrength(password) {
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            const requirements = {
                length: password.length >= 8,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password)
            };
            
            // Update requirement indicators
            Object.keys(requirements).forEach(req => {
                const element = document.getElementById(`req-${req}`);
                if (requirements[req]) {
                    element.classList.add('requirement-met');
                } else {
                    element.classList.remove('requirement-met');
                }
            });
            
            const score = Object.values(requirements).filter(Boolean).length;
            let strength, color, width;
            
            switch (score) {
                case 0:
                case 1:
                    strength = 'Very Weak';
                    color = '#ef4444';
                    width = '20%';
                    break;
                case 2:
                    strength = 'Weak';
                    color = '#f97316';
                    width = '40%';
                    break;
                case 3:
                    strength = 'Good';
                    color = '#eab308';
                    width = '70%';
                    break;
                case 4:
                    strength = 'Strong';
                    color = '#22c55e';
                    width = '100%';
                    break;
            }
            
            strengthBar.style.backgroundColor = color;
            strengthBar.style.width = width;
            strengthText.textContent = `Password strength: ${strength}`;
            strengthText.style.color = color;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const matchText = document.getElementById('matchText');
            
            if (confirmation === '') {
                matchText.textContent = '';
                return;
            }
            
            if (password === confirmation) {
                matchText.textContent = '✓ Passwords match';
                matchText.style.color = '#22c55e';
            } else {
                matchText.textContent = '✗ Passwords do not match';
                matchText.style.color = '#ef4444';
            }
        }
    </script>
</x-guest-layout> 