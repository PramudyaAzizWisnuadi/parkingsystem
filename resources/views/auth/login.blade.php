<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - {{ config('app.name', 'MD Parking System') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding: 20px;
            }

            .login-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                width: 100%;
                max-width: 400px;
                position: relative;
            }

            .login-header {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                padding: 2rem;
                text-align: center;
                position: relative;
            }

            .login-header::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
                animation: pulse 4s ease-in-out infinite;
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                    opacity: 0.5;
                }

                50% {
                    transform: scale(1.1);
                    opacity: 0.8;
                }
            }

            .parking-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1;
            }

            .login-title {
                font-size: 1.8rem;
                font-weight: 600;
                margin: 0;
                position: relative;
                z-index: 1;
            }

            .login-subtitle {
                font-size: 1rem;
                opacity: 0.9;
                margin-top: 0.5rem;
                position: relative;
                z-index: 1;
            }

            .login-form {
                padding: 2rem;
            }

            .form-group {
                margin-bottom: 1.5rem;
                position: relative;
            }

            .form-control {
                border: 2px solid #e9ecef;
                border-radius: 12px;
                padding: 12px 50px 12px 20px;
                font-size: 1rem;
                transition: all 0.3s ease;
                background: #f8f9fa;
            }

            .form-control:focus {
                border-color: #667eea;
                background: white;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }

            .form-icon {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                font-size: 1.1rem;
            }

            .btn-login {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                border-radius: 12px;
                padding: 12px 30px;
                color: white;
                font-weight: 600;
                font-size: 1rem;
                width: 100%;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }

            .btn-login:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            }

            .btn-login:active {
                transform: translateY(0);
            }

            .remember-me {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1.5rem;
            }

            .form-check {
                display: flex;
                align-items: center;
            }

            .form-check-input {
                margin-right: 0.5rem;
            }

            .forgot-password {
                color: #667eea;
                text-decoration: none;
                font-size: 0.9rem;
                transition: color 0.3s ease;
            }

            .forgot-password:hover {
                color: #5a6fd8;
                text-decoration: underline;
            }

            .login-footer {
                text-align: center;
                padding: 1.5rem;
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
            }

            .register-link {
                color: #667eea;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .register-link:hover {
                color: #5a6fd8;
                text-decoration: underline;
            }

            .alert {
                border-radius: 12px;
                margin-bottom: 1rem;
                border: none;
                padding: 1rem;
            }

            .alert-danger {
                background: #f8d7da;
                color: #721c24;
            }

            .alert-success {
                background: #d4edda;
                color: #155724;
            }

            .password-toggle {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: #6c757d;
                cursor: pointer;
                font-size: 1.1rem;
                padding: 0;
                z-index: 2;
            }

            .password-toggle:hover {
                color: #495057;
            }

            .animated-cars {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: -1;
                opacity: 0.1;
            }

            .car {
                position: absolute;
                font-size: 2rem;
                color: white;
                animation: drive 15s linear infinite;
            }

            @keyframes drive {
                0% {
                    left: -100px;
                }

                100% {
                    left: 100vw;
                }
            }

            .car-1 {
                top: 20%;
                animation-delay: 0s;
            }

            .car-2 {
                top: 40%;
                animation-delay: 5s;
            }

            .car-3 {
                top: 60%;
                animation-delay: 10s;
            }

            .car-4 {
                top: 80%;
                animation-delay: 3s;
            }

            .loading {
                display: none;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background: rgba(255, 255, 255, 0.9);
                padding: 1rem;
                border-radius: 12px;
                z-index: 1000;
            }

            .spinner {
                border: 3px solid #f3f3f3;
                border-top: 3px solid #667eea;
                border-radius: 50%;
                width: 30px;
                height: 30px;
                animation: spin 1s linear infinite;
                margin: 0 auto 10px;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            @media (max-width: 480px) {
                .login-container {
                    margin: 10px;
                }

                .login-header {
                    padding: 1.5rem;
                }

                .parking-icon {
                    font-size: 3rem;
                }

                .login-title {
                    font-size: 1.5rem;
                }

                .login-form {
                    padding: 1.5rem;
                }
            }
        </style>
    </head>

    <body>
        <div class="animated-cars">
            <div class="car car-1"><i class="fas fa-car"></i></div>
            <div class="car car-2"><i class="fas fa-truck"></i></div>
            <div class="car car-3"><i class="fas fa-motorcycle"></i></div>
            <div class="car car-4"><i class="fas fa-bus"></i></div>
        </div>

        <div class="login-container">
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <div class="text-center">
                    <small>Sedang masuk...</small>
                </div>
            </div>

            <div class="login-header">
                <div class="parking-icon">
                    <i class="fas fa-parking"></i>
                </div>
                <h1 class="login-title">{{ config('app.name', 'MD Parking System') }}</h1>
                <p class="login-subtitle">Sistem Manajemen Parkir</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                @csrf

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" required
                        autofocus autocomplete="username">
                    <i class="fas fa-envelope form-icon"></i>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                        autocomplete="current-password">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordIcon"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="remember-me">
                    <div class="form-check">
                        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                        <label for="remember_me" class="form-check-label">
                            Remember me
                        </label>
                    </div>

                    @if (Route::has('password.request'))
                        <a class="forgot-password" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>
                    Sign In
                </button>
            </form>

            <div class="login-footer">
                <p class="mb-0">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="register-link">
                        Create Account
                    </a>
                </p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const passwordIcon = document.getElementById('passwordIcon');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordIcon.className = 'fas fa-eye-slash';
                } else {
                    passwordInput.type = 'password';
                    passwordIcon.className = 'fas fa-eye';
                }
            }

            // Form submission with loading
            document.getElementById('loginForm').addEventListener('submit', function(e) {
                document.getElementById('loading').style.display = 'block';
            });

            // Add some interactivity
            document.addEventListener('DOMContentLoaded', function() {
                // Focus effects
                const inputs = document.querySelectorAll('.form-control');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.style.transform = 'translateY(-2px)';
                        this.parentElement.style.transition = 'transform 0.3s ease';
                    });

                    input.addEventListener('blur', function() {
                        this.parentElement.style.transform = 'translateY(0)';
                    });
                });

                // Button hover effects
                const loginBtn = document.querySelector('.btn-login');
                loginBtn.addEventListener('mouseenter', function() {
                    this.innerHTML = '<i class="fas fa-rocket me-2"></i>Let\'s Go!';
                });

                loginBtn.addEventListener('mouseleave', function() {
                    this.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Sign In';
                });

                // Auto-hide alerts after 5 seconds
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.style.opacity = '0';
                        alert.style.transition = 'opacity 0.5s ease';
                        setTimeout(() => {
                            alert.style.display = 'none';
                        }, 500);
                    }, 5000);
                });
            });
        </script>
    </body>

</html>
