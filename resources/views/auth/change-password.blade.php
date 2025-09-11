<x-guest-layout>
    <style>
        .login-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .login-header h1 {
            font-size: 2.25rem;
            font-weight: 800;
            margin-bottom: 0.75rem;
            background: linear-gradient(135deg, #dc2626, #991b1b, #7f1d1d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.025em;
        }

        .login-header p {
            color: #6b7280;
            font-size: 1rem;
            font-weight: 500;
            line-height: 1.5;
        }

        .status-message {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
            color: #166534;
            padding: 1rem 1.25rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            font-size: 0.875rem;
            font-weight: 500;
            border: 1px solid #86efac;
            position: relative;
            overflow: hidden;
        }

        .status-message::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: #22c55e;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .input-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.75rem;
            display: block;
            transition: color 0.2s ease;
        }

        .input-container {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            font-size: 1rem;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.8);
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #dc2626;
            outline: none;
            background: white;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
            transform: translateY(-1px);
        }

        .form-input:focus + .input-label {
            color: #dc2626;
        }

        .form-input::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* Password input with eye icon */
        .password-input {
            padding-right: 3.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #dc2626;
            background: rgba(220, 38, 38, 0.1);
        }

        .password-toggle svg {
            width: 1.25rem;
            height: 1.25rem;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message::before {
            content: '⚠';
            font-size: 1rem;
        }

        /* Password Strength Meter */
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

        .strength-text {
            font-size: 0.75rem;
            font-weight: 500;
            margin-top: 0.5rem;
            transition: color 0.3s ease;
        }

        /* Password Requirements */
        .requirements-box {
            margin-top: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
        }

        .requirements-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: #4b5563;
            margin-bottom: 0.75rem;
        }

        .requirement-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.75rem;
            color: #6b7280;
            transition: all 0.3s ease;
        }

        .requirement-item:last-child {
            margin-bottom: 0;
        }

        .requirement-icon {
            width: 1rem;
            height: 1rem;
            margin-right: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.625rem;
            transition: all 0.3s ease;
        }

        .requirement-met {
            color: #10b981;
        }

        .requirement-met .requirement-icon {
            background: #10b981;
            color: white;
            border-color: #10b981;
        }

        /* Match indicator */
        .match-text {
            font-size: 0.75rem;
            margin-top: 0.5rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        /* Button styling */
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .login-btn {
            width: 100%;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, #dc2626, #991b1b, #7f1d1d);
            color: white;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #991b1b, #7f1d1d, #dc2626);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.4);
        }

        .login-btn:hover::before {
            left: 100%;
        }

        .login-btn:active {
            transform: translateY(0px);
        }

        /* Secondary button style */
        .secondary-btn {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
            width: 100%;
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .secondary-btn:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -5px rgba(107, 114, 128, 0.4);
        }

        .secondary-btn:active {
            transform: translateY(0px);
        }

        /* Side-by-side buttons on larger screens */
        @media (min-width: 480px) {
            .button-container {
                flex-direction: row;
                gap: 1rem;
            }
            
            .login-btn,
            .secondary-btn {
                flex: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .login-header h1 {
                font-size: 2rem;
            }
            
            .login-header {
                margin-bottom: 2.5rem;
            }
        }

        @media (max-width: 640px) {
            .login-header h1 {
                font-size: 1.75rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }
            
            .button-container {
                flex-direction: column;
            }
        }
    </style>

    <div class="login-header">
        <h1>Change Password</h1>
        <p>Secure your account with a strong new password</p>
    </div>

    @if(session('success'))
        <div class="status-message">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('change-password.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="password" class="input-label">New Password</label>
            <div class="input-container">
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="form-input password-input text-black" 
                    required 
                    placeholder="Enter your new password"
                    oninput="checkPasswordStrength(this.value)"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('password')">
                    <svg id="eye-password" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            
            <!-- Password Strength Meter -->
            <div class="strength-meter">
                <div id="strengthBar" class="strength-fill" style="width: 0%; background-color: #d1d5db;"></div>
            </div>
            <p id="strengthText" class="strength-text">Password strength will be shown here</p>
            
            <!-- Password Requirements -->
  
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation" class="input-label">Confirm New Password</label>
            <div class="input-container">
                <input 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    type="password" 
                    class="form-input password-input text-black" 
                    required 
                    placeholder="Confirm your new password"
                    oninput="checkPasswordMatch()"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                    <svg id="eye-password_confirmation" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <p id="matchText" class="match-text"></p>
            @error('password_confirmation')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="button-container">
            <button type="submit" class="login-btn">
                Change Password
            </button>
            <a href="{{ url()->previous() }}" class="secondary-btn">
                Go Back
            </a>
        </div>
    </form>

    <!-- Password Requirements -->
    <div class="requirements-box">
        <p class="requirements-title">Password Requirements:</p>
        <div class="requirement-item" id="req-length">
            <span class="requirement-icon">✓</span>
            At least 8 characters
        </div>
        <div class="requirement-item" id="req-uppercase">
            <span class="requirement-icon">✓</span>
            One uppercase letter
        </div>
        <div class="requirement-item" id="req-lowercase">
            <span class="requirement-icon">✓</span>
            One lowercase letter
        </div>
        <div class="requirement-item" id="req-number">
            <span class="requirement-icon">✓</span>
            One number
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