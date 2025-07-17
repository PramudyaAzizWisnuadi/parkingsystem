<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forgot Password - {{ config('app.name', 'MD Parking System') }}</title>
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

            .forgot-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                overflow: hidden;
                width: 100%;
                max-width: 400px;
                position: relative;
            }

            .forgot-header {
                background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
                color: white;
                padding: 2rem;
                text-align: center;
                position: relative;
            }

            .forgot-header::before {
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

            .forgot-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                position: relative;
                z-index: 1;
            }

            .forgot-title {
                font-size: 1.8rem;
                font-weight: 600;
                margin: 0;
                position: relative;
                z-index: 1;
            }

            .forgot-subtitle {
                font-size: 1rem;
                opacity: 0.9;
                margin-top: 0.5rem;
                position: relative;
                z-index: 1;
            }

            .forgot-form {
                padding: 2rem;
            }

            .forgot-description {
                background: #f8f9fa;
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
                border-left: 4px solid #ffc107;
            }

            .forgot-description p {
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
                border-color: #ffc107;
                background: white;
                box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
            }

            .form-icon {
                position: absolute;
                right: 15px;
                top: 50%;
                transform: translateY(-50%);
                color: #6c757d;
                font-size: 1.1rem;
            }

            .btn-forgot {
                background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
                border: none;
                border-radius: 12px;
                padding: 12px 30px;
                color: white;
                font-weight: 600;
                font-size: 1rem;
                width: 100%;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
            }

            .btn-forgot:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(255, 193, 7, 0.4);
            }

            .btn-forgot:active {
                transform: translateY(0);
            }

            .forgot-footer {
                text-align: center;
                padding: 1.5rem;
                background: #f8f9fa;
                border-top: 1px solid #e9ecef;
            }

            .back-link {
                color: #667eea;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.3s ease;
            }

            .back-link:hover {
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
                border-top: 3px solid #ffc107;
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

            .steps {
                background: #e3f2fd;
                border-radius: 12px;
                padding: 1.5rem;
                margin-bottom: 2rem;
            }

            .steps h6 {
                color: #1565c0;
                margin-bottom: 1rem;
            }

            .steps ol {
                margin: 0;
                padding-left: 1.5rem;
            }

            .steps li {
                margin-bottom: 0.5rem;
                color: #666;
            }

            @media (max-width: 480px) {
                .forgot-container {
                    margin: 10px;
                }

                .forgot-header {
                    padding: 1.5rem;
                }

                .forgot-icon {
                    font-size: 3rem;
                }

                .forgot-title {
                    font-size: 1.5rem;
                }

                .forgot-form {
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

        <div class="forgot-container">
            <div class="loading" id="loading">
                <div class="spinner"></div>
                <div class="text-center">
                    <small>Sending reset link...</small>
                </div>
            </div>

            <div class="forgot-header">
                <div class="forgot-icon">
                    <i class="fas fa-key"></i>
                </div>
                <h1 class="forgot-title">Forgot Password</h1>
                <p class="forgot-subtitle">Reset Your Password</p>
            </div>

            <form method="POST" action="{{ route('password.email') }}" class="forgot-form" id="forgotForm">
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

                <div class="forgot-description">
                    <p>
                        <i class="fas fa-info-circle me-2"></i>
                        Forgot your password? No problem. Just enter your email address and we'll send you a password
                        reset link.
                    </p>
                </div>

                <div class="steps">
                    <h6><i class="fas fa-list-ol me-2"></i>How it works:</h6>
                    <ol>
                        <li>Enter your email address below</li>
                        <li>Click "Send Reset Link" button</li>
                        <li>Check your email for the reset link</li>
                        <li>Click the link to create a new password</li>
                    </ol>
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        class="form-control @error('email') is-invalid @enderror" placeholder="Your Email Address"
                        required autofocus>
                    <i class="fas fa-envelope form-icon"></i>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-forgot">
                    <i class="fas fa-paper-plane me-2"></i>
                    Send Reset Link
                </button>
            </form>

            <div class="forgot-footer">
                <p class="mb-0">
                    Remember your password?
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Login
                    </a>
                </p>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Form submission with loading
            document.getElementById('forgotForm').addEventListener('submit', function(e) {
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
                const forgotBtn = document.querySelector('.btn-forgot');
                forgotBtn.addEventListener('mouseenter', function() {
                    this.innerHTML = '<i class="fas fa-rocket me-2"></i>Send It!';
                });

                forgotBtn.addEventListener('mouseleave', function() {
                    this.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Reset Link';
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

                // Add typing effect to description
                const description = document.querySelector('.forgot-description p');
                const originalText = description.innerHTML;
                description.innerHTML = '';

                let i = 0;

                function typeWriter() {
                    if (i < originalText.length) {
                        description.innerHTML += originalText.charAt(i);
                        i++;
                        setTimeout(typeWriter, 20);
                    }
                }

                setTimeout(typeWriter, 500);
            });
        </script>
    </body>

</html>
