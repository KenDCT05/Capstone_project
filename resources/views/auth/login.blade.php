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
        }

        .password-toggle:hover {
            color: #dc2626;
            background: rgba(220, 38, 38, 0.1);
        }

        .password-toggle svg {
            width: 1.25rem;
            height: 1.25rem;
        }



        .checkbox-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 2rem 0 2.5rem 0;
        }

        .checkbox-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #4b5563;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .checkbox-input {
            width: 1.125rem;
            height: 1.125rem;
            border: 2px solid #d1d5db;
            border-radius: 0.375rem;
            appearance: none;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .checkbox-input:checked {
            background: linear-gradient(135deg, #dc2626, #991b1b);
            border-color: #dc2626;
        }

        .checkbox-input:checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 0.75rem;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .forgot-link {
            font-size: 0.875rem;
            color: #dc2626;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .forgot-link:hover {
            color: #991b1b;
            text-decoration: underline;
        }

        /* Button container for proper layout */
        .button-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 1rem;
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

        /* Secondary button style for "GO BACK" */
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
            
            .checkbox-group {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
                margin: 1.5rem 0 2rem 0;
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
        <h1>Welcome to GSSM!</h1>
        <p>Ready to learn? Sign in to continue your journey.</p>
    </div>

    @if (session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="input-label">Email Address</label>
            <div class="input-container">
                <input 
                    id="email" 
                    name="email" 
                    type="email" 
                    class="form-input text-black" 
                    required 
                    autofocus 
                    placeholder="you@example.com"
                    value="{{ old('email') }}"
                    autocomplete="email"
                >
            </div>
        </div>

        <div class="form-group">
            <label for="password" class="input-label">Password</label>
            <div class="input-container">
                <input 
                    id="password" 
                    name="password" 
                    type="password" 
                    class="form-input password-input text-black" 
                    required 
                    placeholder="Enter your password"
                    autocomplete="current-password"
                >
                <button type="button" class="password-toggle" onclick="togglePassword()">
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                    </svg>
                </button>
            </div>

        </div>

        <div class="checkbox-group">
            <label class="checkbox-label">
                <input type="checkbox" name="remember" class="checkbox-input">
                Keep me signed in
            </label>
            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">
                    Forgot Password?
                </a>
            @endif
        </div>

        <div class="button-container">
            <button type="submit" class="login-btn">
                Sign In
            </button>
            <a href="/" class="secondary-btn">
                Go Back
            </a>
        </div>
    </form>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.style.display = 'none';
                eyeOffIcon.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIcon.style.display = 'block';
                eyeOffIcon.style.display = 'none';
            }
        }
    </script>
</x-guest-layout>