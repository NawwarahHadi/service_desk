<x-guest-layout>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('status'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('status') }}',
                    confirmButtonColor: '#667eea'
                });
            @endif
        });
    </script>
    @endpush

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

        /* Login card */
        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 3rem 2.5rem;
            max-width: 450px;
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
            width: 120px;
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

        .invalid-feedback {
            color: #f56565;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Checkbox styles */
        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            border: 2px solid #cbd5e0;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: #4a5568;
            margin-left: 0.5rem;
            cursor: pointer;
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

        /* Alert */
        .alert {
            border-radius: 10px;
            border: none;
            animation: fadeIn 0.5s ease-out;
        }

        .alert-success {
            background-color: #c6f6d5;
            color: #22543d;
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
                width: 100px;
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
          color:#667eea; /* matches your theme */
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

        <div class="auth-title">Welcome Back</div>
        <div class="auth-subtitle">Sign in to manage your service desk.</div>

        @if (session('status'))
            <div class="alert alert-success py-2 px-3 mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="mb-4">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                       placeholder="Enter your email">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 position-relative">
                <label for="password" class="form-label">Password</label>
                <div style="position:relative">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password" required autocomplete="current-password"
                           placeholder="Enter your password">
                    <button type="button" id="togglePassword" class="password-toggle" aria-pressed="false" title="Show password">
                        <i id="eyeOpen" class="bi bi-eye" aria-hidden="true"></i>
                        <i id="eyeClosed" class="bi bi-eye-slash" aria-hidden="true" style="display:none"></i>
                    </button>
                </div>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <a class="auth-link" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3">
                Log In
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account?
            <a href="{{ route('register') }}" class="auth-link">Register now</a>
        </div>

        @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const pwd = document.getElementById('password');
  const btn = document.getElementById('togglePassword');
  const eyeOpen = document.getElementById('eyeOpen');
  const eyeClosed = document.getElementById('eyeClosed');
  let hideTimeout = null;

  btn.addEventListener('click', function (e) {
    e.preventDefault();
    if (pwd.type === 'password') {
      pwd.type = 'text';
      eyeOpen.style.display = 'none';
      eyeClosed.style.display = 'inline';
      btn.setAttribute('aria-pressed', 'true');
      btn.title = 'Hide password';

      if (hideTimeout) clearTimeout(hideTimeout);
      hideTimeout = setTimeout(() => {
        pwd.type = 'password';
        eyeOpen.style.display = 'inline';
        eyeClosed.style.display = 'none';
        btn.setAttribute('aria-pressed', 'false');
        btn.title = 'Show password';
        hideTimeout = null;
      }, 3000); // 3000ms = 3 seconds
    } else {
      // hide immediately if already visible
      pwd.type = 'password';
      eyeOpen.style.display = 'inline';
      eyeClosed.style.display = 'none';
      btn.setAttribute('aria-pressed', 'false');
      btn.title = 'Show password';
      if (hideTimeout) { clearTimeout(hideTimeout); hideTimeout = null; }
    }
  });
});
</script>
@endpush

</x-guest-layout>
