<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>404 - Halaman Tidak Ditemukan | {{ config('app.name', 'Sistem Parkir') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <!-- SweetAlert2 -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Arial', sans-serif;
                overflow-x: hidden;
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
                color: #ffc107;
                margin-bottom: 1rem;
                animation: bounce 2s infinite;
            }

            @keyframes bounce {

                0%,
                20%,
                50%,
                80%,
                100% {
                    transform: translateY(0);
                }

                40% {
                    transform: translateY(-20px);
                }

                60% {
                    transform: translateY(-10px);
                }
            }

            .error-code {
                font-size: 6rem;
                font-weight: 900;
                color: #ffc107;
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

            .search-suggestions {
                text-align: left;
                margin: 2rem 0;
            }

            .search-suggestions li {
                margin: 0.5rem 0;
                color: #666;
            }

            .search-suggestions i {
                color: #007bff;
                margin-right: 0.5rem;
            }

            .search-box {
                margin: 2rem 0;
            }

            .search-box input {
                border-radius: 25px;
                padding: 10px 20px;
                border: 2px solid #e9ecef;
                width: 100%;
                font-size: 1rem;
            }

            .search-box input:focus {
                outline: none;
                border-color: #007bff;
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            }

            .quick-links {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 1.5rem;
                margin: 2rem 0;
                border-left: 4px solid #007bff;
            }

            .quick-links h5 {
                color: #007bff;
                margin-bottom: 1rem;
            }

            .quick-links a {
                color: #007bff;
                text-decoration: none;
                display: block;
                margin: 0.5rem 0;
                transition: color 0.3s ease;
            }

            .quick-links a:hover {
                color: #0056b3;
                text-decoration: underline;
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

            .lost-car {
                position: absolute;
                font-size: 2rem;
                color: #ffc107;
                animation: wander 20s linear infinite;
            }

            @keyframes wander {
                0% {
                    left: -100px;
                    top: 20%;
                }

                25% {
                    left: 50vw;
                    top: 80%;
                }

                50% {
                    left: 100vw;
                    top: 40%;
                }

                75% {
                    left: 30vw;
                    top: 10%;
                }

                100% {
                    left: -100px;
                    top: 60%;
                }
            }

            .road-sign {
                position: absolute;
                font-size: 1.5rem;
                color: #28a745;
                animation: flash 3s ease-in-out infinite;
            }

            @keyframes flash {

                0%,
                100% {
                    opacity: 0.3;
                }

                50% {
                    opacity: 1;
                }
            }

            .sign-1 {
                top: 10%;
                right: 10%;
            }

            .sign-2 {
                top: 70%;
                left: 10%;
            }

            .sign-3 {
                top: 40%;
                right: 20%;
            }
        </style>
    </head>

    <body>
        <div class="animated-bg">
            <div class="lost-car"><i class="fas fa-car"></i></div>
            <div class="road-sign sign-1"><i class="fas fa-road"></i></div>
            <div class="road-sign sign-2"><i class="fas fa-map-signs"></i></div>
            <div class="road-sign sign-3"><i class="fas fa-direction"></i></div>
        </div>

        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-search"></i>
            </div>

            <h1 class="error-code">404</h1>
            <h2 class="error-title">Halaman Tidak Ditemukan</h2>

            <div class="parking-icon">
                <i class="fas fa-parking"></i>
            </div>

            <p class="error-message">
                Ups! Seperti mobil yang tersesat di area parkir, halaman yang Anda cari tidak dapat ditemukan.
                Mungkin halaman ini telah dipindahkan atau tidak pernah ada.
            </p>

            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Cari halaman yang Anda butuhkan..."
                    onkeypress="if(event.key==='Enter') searchPage()">
            </div>

            <div class="quick-links">
                <h5><i class="fas fa-link"></i> Tautan Cepat</h5>
                <a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="{{ route('parking.index') }}"><i class="fas fa-car"></i> Data Parkir</a>
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('vehicle-types.index') }}"><i class="fas fa-cogs"></i> Jenis Kendaraan</a>
                        <a href="{{ route('reports.index') }}"><i class="fas fa-chart-bar"></i> Laporan</a>
                    @endif
                @endauth
                <a href="{{ route('profile.edit') }}"><i class="fas fa-user"></i> Profil</a>
            </div>

            <div class="quick-links">
                <h5><i class="fas fa-question-circle"></i> Saran Pencarian</h5>
                <ul class="search-suggestions">
                    <li><i class="fas fa-arrow-right"></i> Periksa ejaan URL</li>
                    <li><i class="fas fa-arrow-right"></i> Gunakan menu navigasi</li>
                    <li><i class="fas fa-arrow-right"></i> Kembali ke halaman sebelumnya</li>
                    <li><i class="fas fa-arrow-right"></i> Hubungi administrator jika masalah berlanjut</li>
                </ul>
            </div>

            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="btn-custom">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </a>

                <a href="{{ route('parking.index') }}" class="btn-custom">
                    <i class="fas fa-parking"></i> Data Parkir
                </a>

                <a href="javascript:history.back()" class="btn-custom btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="mt-4">
                <small class="text-muted">
                    <i class="fas fa-map-marker-alt"></i>
                    Sistem Parkir - Navigasi yang Mudah dan Terpercaya
                </small>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Simple search functionality
            function searchPage() {
                const query = document.getElementById('searchInput').value.toLowerCase();
                const suggestions = {
                    'dashboard': '{{ route('dashboard') }}',
                    'parkir': '{{ route('parking.index') }}',
                    'parking': '{{ route('parking.index') }}',
                    'data': '{{ route('parking.index') }}',
                    'kendaraan': '{{ route('vehicle-types.index') }}',
                    'vehicle': '{{ route('vehicle-types.index') }}',
                    'laporan': '{{ route('reports.index') }}',
                    'report': '{{ route('reports.index') }}',
                    'profil': '{{ route('profile.edit') }}',
                    'profile': '{{ route('profile.edit') }}',
                    'login': '{{ route('login') }}',
                    'home': '{{ route('dashboard') }}'
                };

                for (const [key, url] of Object.entries(suggestions)) {
                    if (query.includes(key)) {
                        window.location.href = url;
                        return;
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Halaman Tidak Ditemukan',
                    text: 'Silakan gunakan menu navigasi atau tautan cepat.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            }

            // Add interactivity
            document.addEventListener('DOMContentLoaded', function() {
                const errorIcon = document.querySelector('.error-icon');
                errorIcon.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.3s ease';
                });

                errorIcon.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });

                // Search input focus effect
                const searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'scale(1.02)';
                    this.parentElement.style.transition = 'transform 0.3s ease';
                });

                searchInput.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'scale(1)';
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
            });
        </script>
    </body>

</html>
