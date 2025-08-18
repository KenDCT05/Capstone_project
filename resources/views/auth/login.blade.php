<x-guest-layout>
    <style>
        body {
            background: linear-gradient(135deg, #7f1d1d, #991b1b);
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-card {
            background: white;
            padding: 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(127, 29, 29, 0.25);
            max-width: 420px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .login-header h1 {
            font-size: 1.75rem;
            font-weight: 800;
            background: linear-gradient(90deg, #7f1d1d, #dc2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-label {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
            display: block;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 1rem;
            margin-bottom: 1rem;
            transition: 0.2s ease;
        }

        .form-input:focus {
            border-color: #7f1d1d;
            outline: none;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: -0.5rem;
            margin-bottom: 1rem;
        }

        .checkbox-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .login-btn {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(90deg, #7f1d1d, #dc2626);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 0.75rem;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .login-btn:hover {
            background: linear-gradient(90deg, #991b1b, #ef4444);
        }

        .forgot-link {
            font-size: 0.875rem;
            color: #991b1b;
            text-decoration: none;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }
    </style>

    <div class="login-card">
        <div class="login-header">
            <h1>Sign In</h1>
            <p class="text-sm text-gray-500">to your learning dashboard</p>
        </div>

        @if (session('status'))
            <div class="text-green-700 bg-green-100 p-3 rounded-lg mb-4 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label for="email" class="input-label">Email Address</label>
            <input id="email" name="email" type="email" class="form-input text-black" required autofocus placeholder="you@example.com">
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="password" class="input-label">Password</label>
            <input id="password" name="password" type="password" class="form-input text-black" required placeholder="Enter your password">
            @error('password')
                <div class="error-message">{{ $message }}</div>
            @enderror

            <div class="checkbox-group">
                <label class="text-sm flex items-center">
                    <input type="checkbox" name="remember" class="mr-2"> Keep me signed in
                </label>
                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">Forgot Password?</a>
                @endif
            </div>

            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>
</x-guest-layout>
