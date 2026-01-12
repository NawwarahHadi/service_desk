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

        /* Forgot password card */
        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 480px;
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
            margin-bottom: 2rem;
        }

        .auth-logo img {
            width: 100px;
            height: auto;
            margin-bottom: 1rem;
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
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .auth-subtitle {
            font-size: 1rem;
            color: #718096;
            text-align: center;
            margin-bottom: 2rem;
        }

        /* Info box */
        .info-message {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-left: 4px solid #667eea;
            padding: 1.25rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            animation: fadeIn 0.8s ease-out 0.4s both;
        }

        .info-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: #667eea;
            color: white;
            border-radius: 50%;
            margin-right: 0.75rem;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .info-content {
            display: flex;
            align-items: start;
        }

        .info-text {
            color: #4a5568;
            font-size: 0.95rem;
            line-height: 1.6;
            margin: 0;
        }

        /* Success status */
        .status-success {
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 178, 172, 0.1) 100%);
            border-left: 4px solid #48bb78;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            color: #22543d;
            font-weight: 500;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form styles */
        .auth-form {
            animation: fadeIn 0.8s ease-out 0.5s both;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: block;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
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

        /* Button styles */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 10px;
            padding: 0.875rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            color: white;
            cursor: pointer;
            width: 100%;
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
            margin-top: 1.5rem;
        }

        .back-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .back-link svg {
            margin-right: 0.5rem;
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
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

        <!-- Logo -->
        <div class="auth-logo">
            <img src="{{ asset('metronic/assets/media/logoservicedesk.png') }}"
                 alt="USM">
            <img src="{{ asset('metronic/assets/media/servicedeskpurple.png') }}" alt="Service Desk Logo" sizes="500px">
        </div>

        <div class="auth-title">Forgot Password?</div>
        <div class="auth-subtitle">No worries, we'll send you reset instructions.</div>

        <!-- Info Message -->
        <div class="info-message">
            <div class="info-content">
                <span class="info-icon">🔒</span>
                <p class="info-text">
                    Enter your email address and we'll send you a password reset link that will allow you to choose a new one.
                </p>
            </div>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="status-success">
                ✓ {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <label for="email" class="form-label">Email Address</label>
               <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent"  @error('email') is-invalid @enderror/>
                @error('email')
                    <span class="indicator-label" style="color: red">
                            {{ $message }}
                    </span>
                 @enderror
            </div>

            <button type="submit" class="btn-primary">
                📧 Send Reset Link
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

</x-guest-layout>
