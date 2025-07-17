<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error {{ $exception->getStatusCode() ?? 'Unknown' }} | {{ config('app.name', 'Sistem Parkir') }}</title>
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
                color: #6c757d;
                margin-bottom: 1rem;
                animation: rotate 3s linear infinite;
            }

            @keyframes rotate {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            .error-code {
                font-size: 6rem;
                font-weight: 900;
                color: #6c757d;
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

            .error-details {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 1.5rem;
                margin: 2rem 0;
                border-left: 4px solid #6c757d;
                text-align: left;
            }

            .error-details h5 {
                color: #6c757d;
                margin-bottom: 1rem;
            }

            .error-details p {
                margin: 0.5rem 0;
                color: #666;
                font-family: monospace;
                font-size: 0.9rem;
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
        </style>
    </head>

    <body>
        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-cog"></i>
            </div>

            <h1 class="error-code">{{ $exception->getStatusCode() ?? '???' }}</h1>
            <h2 class="error-title">
                @switch($exception->getStatusCode() ?? 0)
                    @case(400)
                        Permintaan Tidak Valid
                    @break

                    @case(401)
                        Tidak Diotorisasi
                    @break

                    @case(403)
                        Akses Ditolak
                    @break

                    @case(404)
                        Halaman Tidak Ditemukan
                    @break

                    @case(405)
                        Metode Tidak Diizinkan
                    @break

                    @case(419)
                        Halaman Kedaluwarsa
                    @break

                    @case(429)
                        Terlalu Banyak Permintaan
                    @break

                    @case(500)
                        Kesalahan Server
                    @break

                    @case(503)
                        Service Tidak Tersedia
                    @break

                    @default
                        Terjadi Kesalahan
                @endswitch
            </h2>

            <div class="parking-icon">
                <i class="fas fa-parking"></i>
            </div>

            <p class="error-message">
                @switch($exception->getStatusCode() ?? 0)
                    @case(400)
                        Permintaan yang Anda kirim tidak dapat dipahami oleh server.
                    @break

                    @case(401)
                        Anda perlu login untuk mengakses halaman ini.
                    @break

                    @case(403)
                        Anda tidak memiliki izin untuk mengakses halaman ini.
                    @break

                    @case(404)
                        Halaman yang Anda cari tidak dapat ditemukan.
                    @break

                    @case(405)
                        Metode yang digunakan tidak diizinkan untuk halaman ini.
                    @break

                    @case(419)
                        Halaman telah kedaluwarsa. Silakan refresh dan coba lagi.
                    @break

                    @case(429)
                        Anda telah membuat terlalu banyak permintaan. Silakan tunggu sebentar.
                    @break

                    @case(500)
                        Terjadi kesalahan pada server. Tim teknis akan segera memperbaiki.
                    @break

                    @case(503)
                        Layanan sementara tidak tersedia. Silakan coba lagi nanti.
                    @break

                    @default
                        Sistem parkir mengalami masalah teknis yang tidak terduga.
                @endswitch
            </p>

            @if (config('app.debug') && isset($exception))
                <div class="error-details">
                    <h5><i class="fas fa-bug"></i> Detail Error (Mode Debug)</h5>
                    <p><strong>File:</strong> {{ $exception->getFile() ?? 'Unknown' }}</p>
                    <p><strong>Line:</strong> {{ $exception->getLine() ?? 'Unknown' }}</p>
                    <p><strong>Message:</strong> {{ $exception->getMessage() ?? 'No message' }}</p>
                </div>
            @endif

            <div class="mt-4">
                @switch($exception->getStatusCode() ?? 0)
                    @case(401)
                        <a href="{{ route('login') }}" class="btn-custom">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    @break

                    @case(419)
                        <button onclick="window.location.reload()" class="btn-custom">
                            <i class="fas fa-sync-alt"></i> Refresh Halaman
                        </button>
                    @break

                    @case(429)
                        <button onclick="setTimeout(() => window.location.reload(), 5000)" class="btn-custom">
                            <i class="fas fa-clock"></i> Tunggu 5 Detik
                        </button>
                    @break

                    @default
                        <a href="{{ route('dashboard') }}" class="btn-custom">
                            <i class="fas fa-home"></i> Kembali ke Dashboard
                        </a>
                @endswitch

                <a href="javascript:history.back()" class="btn-custom btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="mt-4">
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i>
                    Sistem Parkir - Error {{ $exception->getStatusCode() ?? 'Unknown' }}
                </small>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Error icon animation
                const errorIcon = document.querySelector('.error-icon');
                errorIcon.addEventListener('mouseenter', function() {
                    this.style.animationPlayState = 'paused';
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.3s ease';
                });

                errorIcon.addEventListener('mouseleave', function() {
                    this.style.animationPlayState = 'running';
                    this.style.transform = 'scale(1)';
                });

                // Button click effects
                const buttons = document.querySelectorAll('.btn-custom');
                buttons.forEach(button => {
                    button.addEventListener('click', function() {
                        this.style.transform = 'scale(0.95)';
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 150);
                    });
                });

                // Auto redirect for certain errors
                @if (($exception->getStatusCode() ?? 0) === 419)
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000);
                @endif
            });
        </script>
    </body>

</html>
