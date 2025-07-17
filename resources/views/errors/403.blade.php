<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>403 - Akses Ditolak | {{ config('app.name', 'Sistem Parkir') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Arial', sans-serif;
            }

            .error-container {
                background: white;
                border-radius: 20px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                padding: 3rem;
                text-align: center;
                max-width: 600px;
                width: 90%;
                margin: 2rem;
            }

            .error-icon {
                font-size: 8rem;
                color: #dc3545;
                margin-bottom: 1rem;
                animation: shake 2s infinite;
            }

            @keyframes shake {

                0%,
                100% {
                    transform: translateX(0);
                }

                10%,
                30%,
                50%,
                70%,
                90% {
                    transform: translateX(-5px);
                }

                20%,
                40%,
                60%,
                80% {
                    transform: translateX(5px);
                }
            }

            .error-code {
                font-size: 6rem;
                font-weight: 900;
                color: #dc3545;
                margin: 0;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }

            .error-title {
                font-size: 2rem;
                color: #333;
                margin: 1rem 0;
                font-weight: 600;
            }

            .error-message {
                font-size: 1.1rem;
                color: #666;
                margin: 1.5rem 0;
                line-height: 1.6;
            }

            .parking-icon {
                font-size: 3rem;
                color: #007bff;
                margin: 1rem 0;
            }

            .btn-custom {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border: none;
                border-radius: 50px;
                padding: 12px 30px;
                color: white;
                font-weight: 600;
                text-decoration: none;
                display: inline-block;
                margin: 0.5rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }

            .btn-custom:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
                color: white;
                text-decoration: none;
            }

            .btn-secondary-custom {
                background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            }

            .features-list {
                text-align: left;
                margin: 2rem 0;
            }

            .features-list li {
                margin: 0.5rem 0;
                color: #666;
            }

            .features-list i {
                color: #007bff;
                margin-right: 0.5rem;
            }

            .contact-info {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 1.5rem;
                margin: 2rem 0;
                border-left: 4px solid #007bff;
            }

            .contact-info h5 {
                color: #007bff;
                margin-bottom: 1rem;
            }

            .contact-info p {
                margin: 0.5rem 0;
                color: #666;
            }

            @media (max-width: 768px) {
                .error-container {
                    padding: 2rem 1rem;
                }

                .error-code {
                    font-size: 4rem;
                }

                .error-title {
                    font-size: 1.5rem;
                }

                .error-icon {
                    font-size: 5rem;
                }
            }

            .animated-bg {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: -1;
                opacity: 0.1;
            }

            .car-animation {
                position: absolute;
                font-size: 2rem;
                color: #007bff;
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
        </style>
    </head>

    <body>
        <div class="animated-bg">
            <div class="car-animation car-1"><i class="fas fa-car"></i></div>
            <div class="car-animation car-2"><i class="fas fa-truck"></i></div>
            <div class="car-animation car-3"><i class="fas fa-motorcycle"></i></div>
        </div>

        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-ban"></i>
            </div>

            <h1 class="error-code">403</h1>
            <h2 class="error-title">Akses Ditolak</h2>

            <div class="parking-icon">
                <i class="fas fa-parking"></i>
            </div>

            <p class="error-message">
                Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                Seperti area parkir yang terbatas, halaman ini hanya bisa diakses oleh pengguna dengan hak akses yang
                sesuai.
            </p>

            <div class="contact-info">
                <h5><i class="fas fa-info-circle"></i> Informasi Akses</h5>
                <p><strong>Kemungkinan Penyebab:</strong></p>
                <ul class="features-list">
                    <li><i class="fas fa-user-slash"></i> Anda tidak memiliki role yang diperlukan</li>
                    <li><i class="fas fa-key"></i> Sesi login Anda telah berakhir</li>
                    <li><i class="fas fa-lock"></i> Halaman ini khusus untuk admin</li>
                    <li><i class="fas fa-clock"></i> Akses dibatasi berdasarkan waktu</li>
                </ul>
            </div>

            <div class="contact-info">
                <h5><i class="fas fa-question-circle"></i> Butuh Bantuan?</h5>
                <p><i class="fas fa-envelope"></i> Email: admin@parkir.com</p>
                <p><i class="fas fa-phone"></i> Telepon: (021) 1234567</p>
                <p><i class="fas fa-clock"></i> Jam Operasional: 08:00 - 17:00 WIB</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn-custom">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </a>

                @auth
                    <a href="{{ route('parking.index') }}" class="btn-custom">
                        <i class="fas fa-parking"></i> Data Parkir
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-custom">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                @endauth

                <a href="javascript:history.back()" class="btn-custom btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt"></i>
                    Sistem Parkir - Keamanan dan Akses Terkontrol
                </small>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Add some interactivity
            document.addEventListener('DOMContentLoaded', function() {
                // Animate error icon on hover
                const errorIcon = document.querySelector('.error-icon');
                errorIcon.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.3s ease';
                });

                errorIcon.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });

                // Add click sound effect (optional)
                const buttons = document.querySelectorAll('.btn-custom');
                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                    });
                });
            });
        </script>
    </body>

</html>
