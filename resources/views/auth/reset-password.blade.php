{{-- <x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<x-guest-layout>

    <style>
        /* Purple Theme Styles */
        .auth-container {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated background circles */
        .bg-decoration {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 15s infinite ease-in-out;
        }

        .bg-decoration:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation-delay: 0s;
        }

        .bg-decoration:nth-child(2) {
            width: 250px;
            height: 250px;
            bottom: -80px;
            right: -80px;
            animation-delay: 2s;
        }

        .bg-decoration:nth-child(3) {
            width: 150px;
            height: 150px;
            top: 50%;
            right: 10%;
            animation-delay: 4s;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        /* Reset password card */
        .auth-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem 1.75rem;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo styles */
        .auth-logo {
            text-align: center;
            margin-bottom: 0.75rem;
        }

        .auth-logo img {
            width: 60px;
            height: auto;
            margin-bottom: 0.375rem;
            animation: fadeIn 0.8s ease-out 0.2s both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .auth-title {
            font-size: 1.375rem;
            font-weight: 700;
            color: #2d3748;
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .auth-subtitle {
            font-size: 0.8125rem;
            color: #718096;
            text-align: center;
            margin-bottom: 1rem;
        }

        /* Info box */
        .info-message {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-left: 4px solid #667eea;
            padding: 0.625rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            animation: fadeIn 0.8s ease-out 0.4s both;
        }

        .info-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            margin-right: 0.5rem;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .info-content {
            display: flex;
            align-items: start;
        }

        .info-text {
            color: #4a5568;
            font-size: 0.75rem;
            line-height: 1.4;
            margin: 0;
        }

        /* Form styles */
        .auth-form {
            animation: fadeIn 0.8s ease-out 0.5s both;
        }

        .form-group {
            margin-bottom: 0.75rem;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.25rem;
            font-size: 0.8125rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            width: 100%;
            background: transparent;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #f56565;
        }

        .invalid-feedback {
            color: #f56565;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        /* Password requirements */
        .password-requirements {
            background: #f7fafc;
            border-radius: 6px;
            padding: 0.625rem;
            margin-top: 0.625rem;
            font-size: 0.75rem;
        }

        .password-requirements h4 {
            color: #4a5568;
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 0.75rem;
        }

        .password-requirements ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .password-requirements li {
            color: #718096;
            padding: 0.0625rem 0;
            padding-left: 1rem;
            position: relative;
            line-height: 1.3;
        }

        .password-requirements li:before {
            content: "•";
            position: absolute;
            left: 0.25rem;
            color: #667eea;
        }

        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 0.625rem 1.25rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
            cursor: pointer;
            width: 100%;
            margin-top: 0.75rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Back link */
        .back-link {
            display: inline-flex;
            align-items: center;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
            margin-top: 0.75rem;
            font-size: 0.8125rem;
        }

        .back-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .back-link svg {
            margin-right: 0.25rem;
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .auth-card {
                padding: 2rem 1.5rem;
            }

            .auth-title {
                font-size: 1.5rem;
            }

            .auth-logo img {
                width: 80px;
            }

            .info-message {
                padding: 1rem;
            }
        }
    </style>

    <!-- Background decorations -->
    <div class="bg-decoration"></div>
    <div class="bg-decoration"></div>
    <div class="bg-decoration"></div>

    <div class="auth-card">
        <!-- Logo -->
        <div class="auth-logo">
            <img src="{{ asset('metronic/assets/media/logoservicedesk.png') }}" alt="USM">
            <img src="{{ asset('metronic/assets/media/servicedeskpurple.png') }}" alt="Service Desk Logo" sizes="500px">
        </div>

        <div class="auth-title">Reset Your Password</div>
        <div class="auth-subtitle">Create a new password for your account</div>

        <!-- Info Message -->
        <div class="info-message">
            <div class="info-content">
                <span class="info-icon">🔐</span>
                <p class="info-text">
                    Please enter your email address and choose a strong new password to secure your account.
                </p>
            </div>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="auth-form">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input type="email"
                       id="email"
                       name="email"
                       value="{{ old('email', $request->email) }}"
                       placeholder="Enter your email"
                       autocomplete="username"
                       required
                       autofocus
                       class="form-control @error('email') is-invalid @enderror" />
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">New Password</label>
                <input type="password"
                       id="password"
                       name="password"
                       placeholder="Enter new password"
                       autocomplete="new-password"
                       required
                       class="form-control @error('password') is-invalid @enderror" />
                @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Confirm new password"
                       autocomplete="new-password"
                       required
                       class="form-control @error('password_confirmation') is-invalid @enderror" />
                @error('password_confirmation')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Requirements -->
            <div class="password-requirements">
                <h4>Password Requirements:</h4>
                <ul>
                    <li>At least 8 characters long</li>
                    <li>Include uppercase and lowercase letters</li>
                    <li>Include at least one number</li>
                    <li>Include at least one special character</li>
                </ul>
            </div>

            <button type="submit" class="btn-primary">
                🔒 Reset Password
            </button>
        </form>

        <!-- Footer -->
        <div class="auth-footer">
            <a href="{{ route('login') }}" class="back-link">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Back to Login
            </a>
        </div>
    </div>

</x-guest-layout>
