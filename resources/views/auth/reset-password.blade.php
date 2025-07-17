<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password - {{ config('app.name', 'MD Parking System') }}</title>
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

            .reset-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                width: 100%;
                max-width: 450px;
                position: relative;
            }

            .reset-header {
                background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
                color: white;
                padding: 2rem;
                text-align: center;
                position: relative;
            }

            .reset-header::before {
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

            .reset-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1;
            }

            .reset-title {
                font-size: 1.8rem;
                font-weight: 600;
                margin: 0;
                position: relative;
                z-index: 1;
            }

            .reset-subtitle {
                font-size: 1rem;
                opacity: 0.9;
                margin-top: 0.5rem;
                position: relative;
                z-index: 1;
            }

            .reset-form {
                padding: 2rem;
            }

            .reset-description {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                border-left: 4px solid #17a2b8;
            }

            .reset-description p {
                margin: 0;
                color: #666;
                line-height: 1.5;
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
                border-color: #17a2b8;
                background: white;
                box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
            }

            .form-icon {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                font-size: 1.1rem;
            }

            .btn-reset {
                background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
                border: none;
                border-radius: 12px;
                padding: 12px 30px;
                color: white;
                font-weight: 600;
                font-size: 1rem;
                width: 100%;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
            }

            .btn-reset:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
            }

            .btn-reset:active {
                transform: translateY(0);
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

            .password-strength {
                margin-top: 0.5rem;
                padding: 0.5rem;
                border-radius: 8px;
                font-size: 0.9rem;
            }

            .password-strength.weak {
                background: #f8d7da;
                color: #721c24;
            }

            .password-strength.medium {
                background: #fff3cd;
                color: #856404;
            }

            .password-strength.strong {
                background: #d4edda;
                color: #155724;
            }

            .reset-footer {
                text-align: center;
                padding: 1.5rem;
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
            }

            .login-link {
                color: #667eea;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .login-link:hover {
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
                border-top: 3px solid #17a2b8;
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
                .reset-container {
                    margin: 10px;
                }

                .reset-header {
                    padding: 1.5rem;
                }

                .reset-icon {
                    font-size: 3rem;
                }

                .reset-title {
                    font-size: 1.5rem;
                }

                .reset-form {
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

        <div class="reset-container">
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <div class="text-center">
                    <small>Resetting password...</small>
                </div>
            </div>

            <div class="reset-header">
                <div class="reset-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h1 class="reset-title">Reset Password</h1>
                <p class="reset-subtitle">Create New Password</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="reset-form" id="resetForm">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="reset-description">
                    <p>
                        <i class="fas fa-info-circle me-2"></i>
                        Please enter your email address and create a new secure password. Make sure to use a strong
                        password for better security.
                    </p>
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Your Email Address"
                        required autofocus autocomplete="username">
                    <i class="fas fa-envelope form-icon"></i>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="New Password" required
                        autocomplete="new-password" onkeyup="checkPasswordStrength()">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="passwordIcon"></i>
                    </button>
                    <div id="passwordStrength" class="password-strength" style="display: none;"></div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirm New Password" required autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                    </button>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-reset">
                    <i class="fas fa-shield-alt me-2"></i>
                    Reset Password
                </button>
            </form>

            <div class="reset-footer">
                <p class="mb-0">
                    Remember your password?
                    <a href="{{ route('login') }}" class="login-link">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Login
                    </a>
                </p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function togglePassword(inputId) {
                const passwordInput = document.getElementById(inputId);
                const iconId = inputId === 'password' ? 'passwordIcon' : 'confirmPasswordIcon';
                const passwordIcon = document.getElementById(iconId);

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    passwordIcon.className = 'fas fa-eye-slash';
                } else {
                    passwordInput.type = 'password';
                    passwordIcon.className = 'fas fa-eye';
                }
            }

            function checkPasswordStrength() {
                const password = document.getElementById('password').value;
                const strengthDiv = document.getElementById('passwordStrength');

                if (password.length === 0) {
                    strengthDiv.style.display = 'none';
                    return;
                }

                strengthDiv.style.display = 'block';

                let score = 0;
                let feedback = '';

                // Length check
                if (password.length >= 8) score += 1;
                if (password.length >= 12) score += 1;

                // Character variety
                if (/[a-z]/.test(password)) score += 1;
                if (/[A-Z]/.test(password)) score += 1;
                if (/[0-9]/.test(password)) score += 1;
                if (/[^A-Za-z0-9]/.test(password)) score += 1;

                if (score < 3) {
                    strengthDiv.className = 'password-strength weak';
                    feedback =
                        '<i class="fas fa-exclamation-triangle me-1"></i>Weak - Use at least 8 characters with mixed case, numbers, and symbols';
                } else if (score < 5) {
                    strengthDiv.className = 'password-strength medium';
                    feedback = '<i class="fas fa-info-circle me-1"></i>Medium - Good, but could be stronger';
                } else {
                    strengthDiv.className = 'password-strength strong';
                    feedback = '<i class="fas fa-check-circle me-1"></i>Strong - Excellent password!';
                }

                strengthDiv.innerHTML = feedback;
            }

            // Form submission with loading
            document.getElementById('resetForm').addEventListener('submit', function(e) {
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
                const resetBtn = document.querySelector('.btn-reset');
                resetBtn.addEventListener('mouseenter', function() {
                    this.innerHTML = '<i class="fas fa-rocket me-2"></i>Let\'s Go!';
                });

                resetBtn.addEventListener('mouseleave', function() {
                    this.innerHTML = '<i class="fas fa-shield-alt me-2"></i>Reset Password';
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
