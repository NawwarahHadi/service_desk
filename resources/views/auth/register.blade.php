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

        /* Registration card */
        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 10;
            animation: slideUp 0.6s ease-out;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Custom scrollbar */
        .auth-card::-webkit-scrollbar {
            width: 8px;
        }

        .auth-card::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .auth-card::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        .auth-card::-webkit-scrollbar-thumb:hover {
            background: #764ba2;
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

        /* Form styles */
        .auth-form {
            animation: fadeIn 0.8s ease-out 0.3s both;
        }

        .form-label {
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-label.required::after {
            content: ' *';
            color: #f56565;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .form-control.is-invalid {
            border-color: #f56565;
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(245, 101, 101, 0.1);
        }

        .form-control.bg-light {
            background-color: #f7fafc;
            cursor: not-allowed;
        }

        .invalid-feedback {
            color: #f56565;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .text-muted {
            color: #a0aec0;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Auto-generated badge */
        .auto-badge {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-left: 0.5rem;
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
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Links */
        .auth-link {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .auth-link:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        /* Footer */
        .auth-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 0.95rem;
        }

        /* Info box */
        .info-box {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-left: 4px solid #667eea;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .info-box-icon {
            color: #667eea;
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        .info-box-text {
            color: #4a5568;
            font-size: 0.9rem;
            margin: 0;
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
        }

        .password-toggle{
          position:absolute;
          right:0.75rem;
          top:50%;
          transform:translateY(-50%);
          background:transparent;
          border:none;
          padding:0.2rem;
          display:flex;
          align-items:center;
          cursor:pointer;
          color:#667eea; /* matches theme */
        }
        .password-toggle:focus{ outline:none; }
        .password-toggle i{ display:inline-block; font-size:20px; width:20px; height:20px; line-height:1; }
    </style>

    <!-- Background decorations -->
    <div class="bg-decoration"></div>
    <div class="bg-decoration"></div>
    <div class="bg-decoration"></div>


        <!-- Logo -->
        <div class="auth-logo">
            <img src="{{ asset('metronic/assets/media/logoservicedesk.png') }}" 
                 alt="USM">
            <img src="{{ asset('metronic/assets/media/servicedeskpurple.png') }}" alt="Service Desk Logo">
        </div>

        <div class="auth-title">Create Account</div>
        <div class="auth-subtitle">Register to start managing your tickets.</div>

        <!-- Info box -->
        <!-- <div class="info-box">
            <div class="d-flex align-items-start">
                <i class="info-box-icon">ℹ️</i>
                <p class="info-box-text">
                    Your User ID will be automatically generated after successful registration.
                </p>
            </div>
        </div> -->

        <form method="POST" action="{{ route('register') }}" class="auth-form">
            @csrf

            <!-- <div class="mb-4">
                <label class="form-label">
                    User ID
                    <span class="auto-badge">Auto-generated</span>
                </label>
                <input type="text" class="form-control bg-light" value="Will be generated automatically" readonly>
            </div> -->

            <div class="mb-4">
                <label for="name" class="form-label required">Full Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                       placeholder="Enter your full name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="form-label required">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autocomplete="username"
                       placeholder="Enter your email address">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="student_id" class="form-label required">Student ID (Matric Number)</label>
                <input id="student_id" type="text" class="form-control @error('student_id') is-invalid @enderror"
                       name="student_id" value="{{ old('student_id') }}" required placeholder="e.g. 123456">
                @error('student_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 position-relative">
                <label for="password" class="form-label required">Password</label>
                <div style="position:relative">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="new-password"
                           placeholder="Create a strong password">
                    <button type="button" id="togglePassword" class="password-toggle" aria-pressed="false" title="Show password">
                        <i id="eyeOpen" class="bi bi-eye" aria-hidden="true"></i>
                        <i id="eyeClosed" class="bi bi-eye-slash" aria-hidden="true" style="display:none"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimum 8 characters</small>
            </div>

            <div class="mb-4 position-relative">
                <label for="password_confirmation" class="form-label required">Confirm Password</label>
                <div style="position:relative">
                    <input id="password_confirmation" type="password" class="form-control"
                           name="password_confirmation" required autocomplete="new-password"
                           placeholder="Re-enter your password">
                    <button type="button" id="togglePasswordConfirm" class="password-toggle" aria-pressed="false" title="Show password">
                        <i id="eyeOpenConfirm" class="bi bi-eye" aria-hidden="true"></i>
                        <i id="eyeClosedConfirm" class="bi bi-eye-slash" aria-hidden="true" style="display:none"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3">
                <i class="bi bi-person-plus"></i>
                Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account?
            <a href="{{ route('login') }}" class="auth-link">Log in</a>
        </div>

        @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  function setupToggle(btnId, inputId, openId, closedId) {
    const btn = document.getElementById(btnId);
    const input = document.getElementById(inputId);
    const eyeOpen = document.getElementById(openId);
    const eyeClosed = document.getElementById(closedId);
    if (!btn || !input) return;
    let hideTimeout = null;

    btn.addEventListener('click', function (e) {
      e.preventDefault();
      if (input.type === 'password') {
        input.type = 'text';
        if (eyeOpen) eyeOpen.style.display = 'none';
        if (eyeClosed) eyeClosed.style.display = 'inline';
        btn.setAttribute('aria-pressed', 'true');
        btn.title = 'Hide password';

        if (hideTimeout) clearTimeout(hideTimeout);
        hideTimeout = setTimeout(() => {
          input.type = 'password';
          if (eyeOpen) eyeOpen.style.display = 'inline';
          if (eyeClosed) eyeClosed.style.display = 'none';
          btn.setAttribute('aria-pressed', 'false');
          btn.title = 'Show password';
          hideTimeout = null;
        }, 3000);
      } else {
        // hide immediately if already visible
        input.type = 'password';
        if (eyeOpen) eyeOpen.style.display = 'inline';
        if (eyeClosed) eyeClosed.style.display = 'none';
        btn.setAttribute('aria-pressed', 'false');
        btn.title = 'Show password';
        if (hideTimeout) { clearTimeout(hideTimeout); hideTimeout = null; }
      }
    });

    // allow keyboard accessibility
    btn.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        btn.click();
      }
    });
  }

  setupToggle('togglePassword', 'password', 'eyeOpen', 'eyeClosed');
  setupToggle('togglePasswordConfirm', 'password_confirmation', 'eyeOpenConfirm', 'eyeClosedConfirm');
});
</script>
@endpush

</x-guest-layout>