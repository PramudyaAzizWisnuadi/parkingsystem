<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Register - {{ config('app.name', 'MD Parking System') }}</title>
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

            .register-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                width: 100%;
                max-width: 450px;
                position: relative;
            }

            .register-header {
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                color: white;
                padding: 2rem;
                text-align: center;
                position: relative;
            }

            .register-header::before {
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
                font-size: 3.5rem;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1;
            }

            .register-title {
                font-size: 1.8rem;
                font-weight: 600;
                margin: 0;
                position: relative;
                z-index: 1;
            }

            .register-subtitle {
                font-size: 1rem;
                opacity: 0.9;
                margin-top: 0.5rem;
                position: relative;
                z-index: 1;
            }

            .register-form {
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
                border-color: #28a745;
                background: white;
                box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            }

            .form-icon {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                font-size: 1.1rem;
            }

            .btn-register {
                background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                border: none;
                border-radius: 12px;
                padding: 12px 30px;
                color: white;
                font-weight: 600;
                font-size: 1rem;
                width: 100%;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
            }

            .btn-register:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
            }

            .btn-register:active {
                transform: translateY(0);
            }

            .role-selection {
                margin-bottom: 1.5rem;
            }

            .role-option {
                border: 2px solid #e9ecef;
                border-radius: 12px;
                padding: 1rem;
                margin-bottom: 0.5rem;
                cursor: pointer;
                transition: all 0.3s ease;
                background: #f8f9fa;
            }

            .role-option:hover {
                border-color: #28a745;
                background: white;
            }

            .role-option.selected {
                border-color: #28a745;
                background: rgba(40, 167, 69, 0.1);
            }

            .role-option input[type="radio"] {
                margin-right: 0.5rem;
            }

            .role-icon {
                font-size: 1.5rem;
                margin-right: 0.5rem;
                color: #28a745;
            }

            .register-footer {
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
                top: 15%;
                animation-delay: 0s;
            }

            .car-2 {
                top: 35%;
                animation-delay: 5s;
            }

            .car-3 {
                top: 55%;
                animation-delay: 10s;
            }

            .car-4 {
                top: 75%;
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
                border-top: 3px solid #28a745;
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
                .register-container {
                    margin: 10px;
                }

                .register-header {
                    padding: 1.5rem;
                }

                .parking-icon {
                    font-size: 3rem;
                }

                .register-title {
                    font-size: 1.5rem;
                }

                .register-form {
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

        <div class="register-container">
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <div class="text-center">
                    <small>Creating account...</small>
                </div>
            </div>

            <div class="register-header">
                <div class="parking-icon">
                    <i class="fas fa-user-plus"></i>
                </div>
                <h1 class="register-title">Create Account</h1>
                <p class="register-subtitle">Join {{ config('app.name', 'MD Parking System') }}</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="register-form" id="registerForm">
                @csrf

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <!-- Name -->
                <div class="form-group">
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                        class="form-control @error('name') is-invalid @enderror" placeholder="Full Name" required
                        autofocus autocomplete="name">
                    <i class="fas fa-user form-icon"></i>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Email Address" required
                        autocomplete="username">
                    <i class="fas fa-envelope form-icon"></i>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Role Selection -->
                <div class="role-selection">
                    <label class="form-label">Select Role:</label>
                    <div class="role-option" onclick="selectRole('petugas')">
                        <input type="radio" name="role" value="petugas" id="role_petugas" checked>
                        <i class="fas fa-user-tie role-icon"></i>
                        <strong>Petugas</strong> - Parking Attendant
                    </div>
                    <div class="role-option" onclick="selectRole('admin')">
                        <input type="radio" name="role" value="admin" id="role_admin">
                        <i class="fas fa-user-shield role-icon"></i>
                        <strong>Admin</strong> - System Administrator
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <input id="password" type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password" required
                        autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        <i class="fas fa-eye" id="passwordIcon"></i>
                    </button>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <input id="password_confirmation" type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="Confirm Password" required autocomplete="new-password">
                    <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation')">
                        <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                    </button>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus me-2"></i>
                    Create Account
                </button>
            </form>

            <div class="register-footer">
                <p class="mb-0">
                    Already have an account?
                    <a href="{{ route('login') }}" class="login-link">
                        Sign In
                    </a>
                </p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function selectRole(role) {
                // Remove selected class from all options
                document.querySelectorAll('.role-option').forEach(option => {
                    option.classList.remove('selected');
                });

                // Add selected class to clicked option
                event.currentTarget.classList.add('selected');

                // Check the radio button
                document.getElementById('role_' + role).checked = true;
            }

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

            // Form submission with loading
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                document.getElementById('loading').style.display = 'block';
            });

            // Add some interactivity
            document.addEventListener('DOMContentLoaded', function() {
                // Set initial selected role
                selectRole('petugas');

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
                const registerBtn = document.querySelector('.btn-register');
                registerBtn.addEventListener('mouseenter', function() {
                    this.innerHTML = '<i class="fas fa-rocket me-2"></i>Let\'s Start!';
                });

                registerBtn.addEventListener('mouseleave', function() {
                    this.innerHTML = '<i class="fas fa-user-plus me-2"></i>Create Account';
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
