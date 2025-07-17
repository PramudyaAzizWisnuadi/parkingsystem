<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>500 - Kesalahan Server | {{ config('app.name', 'Sistem Parkir') }}</title>
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
                color: #dc3545;
                margin-bottom: 1rem;
                animation: pulse 2s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                    opacity: 1;
                }

                50% {
                    transform: scale(1.05);
                    opacity: 0.8;
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
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

            .btn-danger-custom {
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            }

            .troubleshooting {
                text-align: left;
                margin: 2rem 0;
            }

            .troubleshooting li {
                margin: 0.5rem 0;
                color: #666;
            }

            .troubleshooting i {
                color: #dc3545;
                margin-right: 0.5rem;
            }

            .contact-info {
                background: #f8f9fa;
                border-radius: 10px;
                padding: 1.5rem;
                margin: 2rem 0;
                border-left: 4px solid #dc3545;
            }

            .contact-info h5 {
                color: #dc3545;
                margin-bottom: 1rem;
            }

            .contact-info p {
                margin: 0.5rem 0;
                color: #666;
            }

            .status-indicator {
                display: inline-block;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #dc3545;
                margin-right: 0.5rem;
                animation: blink 1s infinite;
            }

            @keyframes blink {

                0%,
                100% {
                    opacity: 1;
                }

                50% {
                    opacity: 0.3;
                }
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

            .broken-car {
                position: absolute;
                font-size: 2rem;
                color: #dc3545;
                animation: breakdown 4s ease-in-out infinite;
            }

            @keyframes breakdown {

                0%,
                100% {
                    transform: translateX(0) rotate(0deg);
                }

                25% {
                    transform: translateX(-5px) rotate(-2deg);
                }

                75% {
                    transform: translateX(5px) rotate(2deg);
                }
            }

            .smoke {
                position: absolute;
                font-size: 1rem;
                color: #6c757d;
                animation: smoke 3s ease-in-out infinite;
            }

            @keyframes smoke {
                0% {
                    opacity: 0;
                    transform: translateY(0);
                }

                50% {
                    opacity: 1;
                    transform: translateY(-20px);
                }

                100% {
                    opacity: 0;
                    transform: translateY(-40px);
                }
            }

            .car-1 {
                top: 20%;
                left: 20%;
            }

            .car-2 {
                top: 60%;
                right: 20%;
            }

            .smoke-1 {
                top: 15%;
                left: 25%;
                animation-delay: 0.5s;
            }

            .smoke-2 {
                top: 55%;
                right: 25%;
                animation-delay: 1s;
            }
        </style>
    </head>

    <body>
        <div class="animated-bg">
            <div class="broken-car car-1"><i class="fas fa-car-crash"></i></div>
            <div class="broken-car car-2"><i class="fas fa-car-battery"></i></div>
            <div class="smoke smoke-1"><i class="fas fa-cloud"></i></div>
            <div class="smoke smoke-2"><i class="fas fa-cloud"></i></div>
        </div>

        <div class="error-container">
            <div class="error-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <h1 class="error-code">500</h1>
            <h2 class="error-title">Kesalahan Server</h2>

            <div class="parking-icon">
                <i class="fas fa-tools"></i>
            </div>

            <p class="error-message">
                <span class="status-indicator"></span>
                Ups! Server mengalami masalah seperti mesin parkir yang rusak.
                Tim teknis kami sedang bekerja keras untuk memperbaiki masalah ini.
            </p>

            <div class="contact-info">
                <h5><i class="fas fa-info-circle"></i> Informasi Masalah</h5>
                <p><strong>Status:</strong> <span class="status-indicator"></span>Server Bermasalah</p>
                <p><strong>Waktu:</strong> {{ now()->format('d/m/Y H:i:s') }} WIB</p>
                <p><strong>Ref ID:</strong> {{ Str::random(8) }}</p>
            </div>

            <div class="contact-info">
                <h5><i class="fas fa-wrench"></i> Langkah Troubleshooting</h5>
                <ul class="troubleshooting">
                    <li><i class="fas fa-redo"></i> Refresh halaman ini dalam beberapa menit</li>
                    <li><i class="fas fa-clock"></i> Tunggu beberapa saat dan coba lagi</li>
                    <li><i class="fas fa-sign-out-alt"></i> Logout dan login kembali</li>
                    <li><i class="fas fa-phone"></i> Hubungi administrator jika masalah berlanjut</li>
                </ul>
            </div>

            <div class="contact-info">
                <h5><i class="fas fa-headset"></i> Dukungan Teknis</h5>
                <p><i class="fas fa-envelope"></i> Email: support@parkir.com</p>
                <p><i class="fas fa-phone"></i> Telepon: (021) 1234567</p>
                <p><i class="fas fa-clock"></i> Jam Operasional: 24/7</p>
            </div>

            <div class="mt-4">
                <button onclick="window.location.reload()" class="btn-custom">
                    <i class="fas fa-sync-alt"></i> Refresh Halaman
                </button>

                <a href="{{ route('dashboard') }}" class="btn-custom">
                    <i class="fas fa-home"></i> Kembali ke Dashboard
                </a>

                <a href="javascript:history.back()" class="btn-custom btn-secondary-custom">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="mt-3">
                <button onclick="reportError()" class="btn-custom btn-danger-custom">
                    <i class="fas fa-bug"></i> Laporkan Masalah
                </button>
            </div>

            <div class="mt-4">
                <small class="text-muted">
                    <i class="fas fa-shield-alt"></i>
                    Sistem Parkir - Dalam Perbaikan
                </small>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Auto refresh every 30 seconds
            let refreshInterval;

            function startAutoRefresh() {
                refreshInterval = setInterval(() => {
                    window.location.reload();
                }, 30000); // 30 seconds
            }

            function stopAutoRefresh() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }
            }

            // Report error function
            function reportError() {
                const errorDetails = {
                    timestamp: new Date().toISOString(),
                    url: window.location.href,
                    userAgent: navigator.userAgent,
                    referrer: document.referrer || 'Direct access'
                };

                // In a real application, this would send to your error tracking service
                alert(
                    'Laporan kesalahan telah dicatat. Tim teknis akan segera menindaklanjuti.\n\nRef ID: {{ Str::random(8) }}');
            }

            // Add interactivity
            document.addEventListener('DOMContentLoaded', function() {
                // Start auto refresh
                startAutoRefresh();

                // Stop auto refresh when user is active
                document.addEventListener('click', stopAutoRefresh);
                document.addEventListener('keydown', stopAutoRefresh);

                // Error icon animation
                const errorIcon = document.querySelector('.error-icon');
                errorIcon.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.3s ease';
                });

                errorIcon.addEventListener('mouseleave', function() {
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

                // Show countdown for next auto refresh
                let countdown = 30;
                const countdownElement = document.createElement('div');
                countdownElement.className = 'mt-3';
                countdownElement.innerHTML =
                    '<small class="text-muted"><i class="fas fa-clock"></i> Auto refresh dalam <span id="countdown">30</span> detik</small>';
                document.querySelector('.error-container').appendChild(countdownElement);

                const countdownInterval = setInterval(() => {
                    countdown--;
                    document.getElementById('countdown').textContent = countdown;

                    if (countdown <= 0) {
                        clearInterval(countdownInterval);
                    }
                }, 1000);
            });
        </script>
    </body>

</html>
