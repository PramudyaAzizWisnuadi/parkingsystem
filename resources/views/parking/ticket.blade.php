<!DOCTYPE html>
<html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <meta name="theme-color" content="#007bff">
        <title>{{ config('ticket.company.title') }} - {{ $parking->ticket_number }}</title>
        <style>
            :root {
                --primary-color: #007bff;
                --secondary-color: #6c757d;
                --success-color: #28a745;
                --danger-color: #dc3545;
                --warning-color: #ffc107;
                --light-gray: #f8f9fa;
                --border-color: #dee2e6;
                --text-dark: #333;
                --text-muted: #6c757d;
            }

            * {
                box-sizing: border-box;
            }

            body {
                font-family: 'Arial', 'Helvetica', sans-serif;
                margin: 0;
                padding: 0;
                background-color: white;
                font-size: 14px;
                line-height: 1.4;
                color: var(--text-dark);
            }

            .ticket {
                width: 100%;
                max-width: 58mm;
                padding: 8px;
                margin: 0 auto;
                text-align: center;
                background-color: white;
            }

            .ticket h1 {
                margin: 0 0 8px 0;
                font-size: 16px;
                font-weight: bold;
                color: var(--text-dark);
            }

            .ticket h2 {
                margin: 0 0 10px 0;
                font-size: 14px;
                font-weight: normal;
                color: var(--text-muted);
            }

            .company-info {
                text-align: center;
                margin: 8px 0;
                font-size: 12px;
                color: var(--text-muted);
            }

            .company-info p {
                margin: 2px 0;
            }

            .ticket-info {
                text-align: left;
                margin: 10px 0;
                font-size: 12px;
            }

            .ticket-info table {
                width: 100%;
                border-collapse: collapse;
                margin: 0;
            }

            .ticket-info td {
                padding: 2px 0;
                vertical-align: top;
                font-size: 12px;
            }

            .ticket-info td:first-child {
                width: 40%;
                font-weight: 500;
                text-align: left;
            }

            .ticket-info td:last-child {
                text-align: right;
                font-weight: bold;
                width: 60%;
            }

            .amount {
                font-size: 14px;
                font-weight: bold;
                margin: 12px 0;
                text-align: center;
                border-top: 1px dashed #000;
                border-bottom: 1px dashed #000;
                padding: 6px 0;
                color: var(--success-color);
            }

            .footer {
                margin-top: 10px;
                font-size: 11px;
                text-align: center;
                line-height: 1.2;
                color: var(--text-muted);
            }

            .footer p {
                margin: 2px 0;
            }

            .copy-label {
                margin: 8px 0;
                font-size: 12px;
                font-weight: bold;
                color: var(--danger-color);
                text-align: center;
                border: 1px dashed var(--danger-color);
                padding: 4px;
                background-color: rgba(220, 53, 69, 0.1);
                border-radius: 4px;
            }

            .separator {
                border-top: 1px dashed #000;
                margin: 8px 0;
            }

            .no-print {
                display: none;
            }

            /* Mobile-specific improvements */
            @media screen and (max-width: 768px) {
                body {
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    padding: 20px 10px;
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }

                .ticket-container {
                    background: white;
                    border-radius: 15px;
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
                    padding: 20px;
                    margin-bottom: 20px;
                    width: 100%;
                    max-width: 400px;
                    backdrop-filter: blur(10px);
                    border: 1px solid rgba(255, 255, 255, 0.2);
                }

                .ticket {
                    max-width: none;
                    padding: 0;
                    box-shadow: none;
                    border: none;
                }

                .ticket h1 {
                    font-size: 20px;
                    color: var(--primary-color);
                    margin-bottom: 5px;
                }

                .ticket h2 {
                    font-size: 16px;
                    margin-bottom: 15px;
                }

                .company-info {
                    font-size: 13px;
                    margin: 15px 0;
                }

                .ticket-info {
                    font-size: 14px;
                    margin: 20px 0;
                    background: var(--light-gray);
                    padding: 15px;
                    border-radius: 10px;
                }

                .ticket-info td {
                    padding: 8px 0;
                    font-size: 14px;
                }

                .amount {
                    font-size: 18px;
                    padding: 15px;
                    margin: 20px 0;
                    border-radius: 10px;
                    background: linear-gradient(135deg, var(--success-color), #20c997);
                    color: white;
                    border: none;
                    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
                }

                .footer {
                    font-size: 13px;
                    margin-top: 15px;
                }

                .copy-label {
                    margin: 15px 0;
                    font-size: 14px;
                    padding: 10px;
                    border-radius: 8px;
                    background-color: rgba(220, 53, 69, 0.15);
                }

                .no-print {
                    display: block;
                    width: 100%;
                    max-width: 400px;
                }

                .action-buttons {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                    width: 100%;
                }

                .action-buttons button,
                .action-buttons a {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    padding: 15px 20px;
                    border: none;
                    border-radius: 12px;
                    font-size: 16px;
                    font-weight: 600;
                    text-decoration: none;
                    cursor: pointer;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                    min-height: 50px;
                }

                .btn-primary {
                    background: linear-gradient(135deg, var(--primary-color), #0056b3);
                    color: white;
                }

                .btn-secondary {
                    background: linear-gradient(135deg, var(--secondary-color), #545b62);
                    color: white;
                }

                .btn-primary:hover,
                .btn-primary:active {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(0, 123, 255, 0.3);
                }

                .btn-secondary:hover,
                .btn-secondary:active {
                    transform: translateY(-2px);
                    box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
                }

                .mobile-header {
                    text-align: center;
                    margin-bottom: 20px;
                    color: white;
                }

                .mobile-header h3 {
                    margin: 0;
                    font-size: 24px;
                    font-weight: 700;
                    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                }

                .mobile-header p {
                    margin: 5px 0 0 0;
                    font-size: 16px;
                    opacity: 0.9;
                }
            }

            /* Desktop and larger screens */
            @media screen and (min-width: 769px) {
                body {
                    background-color: #f0f0f0;
                    padding: 40px 20px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    min-height: 100vh;
                }

                .ticket-container {
                    background: white;
                    border-radius: 10px;
                    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                    margin-bottom: 30px;
                }

                .ticket {
                    border: 1px solid var(--border-color);
                    box-shadow: none;
                }

                .no-print {
                    display: block;
                    text-align: center;
                }

                .action-buttons {
                    display: flex;
                    gap: 15px;
                    justify-content: center;
                    flex-wrap: wrap;
                }

                .action-buttons button,
                .action-buttons a {
                    padding: 12px 24px;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                    font-size: 14px;
                    font-weight: 500;
                    text-decoration: none;
                    transition: all 0.2s ease;
                    min-width: 120px;
                }

                .btn-primary {
                    background-color: var(--primary-color);
                    color: white;
                }

                .btn-secondary {
                    background-color: var(--secondary-color);
                    color: white;
                }

                .btn-primary:hover {
                    background-color: #0056b3;
                    transform: translateY(-1px);
                }

                .btn-secondary:hover {
                    background-color: #545b62;
                    transform: translateY(-1px);
                }
            }

            /* Print styles */
            @media print {
                @page {
                    size: 58mm auto;
                    margin: 0;
                }

                body {
                    background: white !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    font-family: 'Arial', 'Helvetica', sans-serif !important;
                }

                .mobile-header,
                .no-print {
                    display: none !important;
                }

                .ticket-container {
                    background: white !important;
                    border-radius: 0 !important;
                    box-shadow: none !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    width: 58mm !important;
                    max-width: 58mm !important;
                }

                .ticket {
                    width: 58mm !important;
                    max-width: 58mm !important;
                    padding: 4mm !important;
                    margin: 0 !important;
                    box-shadow: none !important;
                    border: none !important;
                    border-radius: 0 !important;
                    text-align: center !important;
                }

                .ticket h1 {
                    font-size: 14px !important;
                    margin: 0 0 8px 0 !important;
                    font-weight: bold !important;
                    text-align: center !important;
                }

                .ticket h2 {
                    font-size: 12px !important;
                    margin: 0 0 10px 0 !important;
                    font-weight: normal !important;
                    text-align: center !important;
                }

                .company-info {
                    font-size: 10px !important;
                    background: transparent !important;
                    border-radius: 0 !important;
                    padding: 0 !important;
                    margin: 8px 0 !important;
                    text-align: center !important;
                }

                .company-info p {
                    margin: 2px 0 !important;
                }

                .ticket-info {
                    text-align: left !important;
                    margin: 10px 0 !important;
                    padding: 0 !important;
                    background: transparent !important;
                    border-radius: 0 !important;
                    font-size: 12px !important;
                }

                .ticket-info table {
                    width: 100% !important;
                    border-collapse: collapse !important;
                    margin: 0 !important;
                }

                .ticket-info tr {
                    display: table-row !important;
                }

                .ticket-info td {
                    display: table-cell !important;
                    padding: 2px 0 !important;
                    font-size: 12px !important;
                    vertical-align: top !important;
                }

                .ticket-info td:first-child {
                    text-align: left !important;
                    width: 40% !important;
                    font-weight: 500 !important;
                }

                .ticket-info td:last-child {
                    text-align: right !important;
                    width: 60% !important;
                    font-weight: bold !important;
                }

                .amount {
                    font-size: 14px !important;
                    font-weight: bold !important;
                    background: white !important;
                    color: black !important;
                    border-top: 1px dashed #000 !important;
                    border-bottom: 1px dashed #000 !important;
                    padding: 6px 0 !important;
                    margin: 12px 0 !important;
                    border-radius: 0 !important;
                    box-shadow: none !important;
                    text-align: center !important;
                }

                .separator {
                    border-top: 1px dashed #000 !important;
                    margin: 8px 0 !important;
                }

                .footer {
                    font-size: 11px !important;
                    background: transparent !important;
                    border-radius: 0 !important;
                    padding: 0 !important;
                    margin-top: 10px !important;
                    text-align: center !important;
                    line-height: 1.2 !important;
                }

                .footer p {
                    margin: 2px 0 !important;
                }

                .copy-label {
                    font-size: 10px !important;
                    font-weight: bold !important;
                    background: transparent !important;
                    color: black !important;
                    border: 1px dashed #000 !important;
                    padding: 3px !important;
                    margin: 6px 0 !important;
                    text-align: center !important;
                    border-radius: 0 !important;
                }

                /* Ensure all text is visible and properly colored */
                * {
                    color: black !important;
                    background: transparent !important;
                    text-shadow: none !important;
                }

                /* Override any mobile gradients and maintain structure */
                .ticket h1,
                .ticket h2 {
                    background: transparent !important;
                    color: black !important;
                }

                /* Force display and maintain exact layout structure */
                .ticket,
                .ticket-container {
                    display: block !important;
                    visibility: visible !important;
                    opacity: 1 !important;
                }

                .ticket table,
                .ticket-info table {
                    display: table !important;
                    width: 100% !important;
                    border-collapse: collapse !important;
                    table-layout: fixed !important;
                }

                .ticket tr,
                .ticket-info tr {
                    display: table-row !important;
                }

                .ticket td,
                .ticket-info td {
                    display: table-cell !important;
                    vertical-align: top !important;
                    word-wrap: break-word !important;
                }

                /* Maintain exact spacing and font sizes as screen */
                .ticket * {
                    line-height: 1.4 !important;
                }

                /* Ensure consistent alignment with screen layout */
                .company-info,
                .amount,
                .footer {
                    text-align: center !important;
                }

                .ticket-info {
                    text-align: left !important;
                }
            }

            /* Loading and transition effects */
            .fade-in {
                animation: fadeIn 0.5s ease-in;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Icon styles */
            .icon {
                width: 20px;
                height: 20px;
                display: inline-block;
            }

            .icon-print::before {
                content: "🖨️";
            }

            .icon-back::before {
                content: "⬅️";
            }

            .icon-new::before {
                content: "➕";
            }
        </style>
    </head>

    <body class="fade-in">
        <!-- Mobile header (visible only on mobile) -->
        <div class="mobile-header">
            <h3>Tiket Parkir</h3>
            <p>{{ $parking->ticket_number }}</p>
        </div>

        <!-- Ticket container for better mobile presentation -->
        <div class="ticket-container">
            <div class="ticket">
                <h1>{{ config('ticket.company.title', 'SISTEM PARKIR') }}</h1>
                <h2>{{ config('ticket.company.name', 'Manajemen Parkir') }}</h2>

                @if (isset($isCopy) && $isCopy)
                    <div class="copy-label">
                        <strong>-- COPY --</strong>
                    </div>
                @endif

                @if (config('ticket.content.show_company_info', true) &&
                        (config('ticket.company.address') || config('ticket.company.phone')))
                    <div class="company-info">
                        @if (config('ticket.company.address'))
                            <p>{{ config('ticket.company.address') }}</p>
                        @endif
                        @if (config('ticket.company.phone'))
                            <p>{{ config('ticket.company.phone') }}</p>
                        @endif
                    </div>
                @endif

                @if (config('ticket.content.show_separator', true))
                    <div class="separator"></div>
                @endif

                <div class="ticket-info">
                    <table>
                        <tr>
                            <td>{{ config('ticket.labels.ticket', 'No. Tiket') }}</td>
                            <td>{{ $parking->ticket_number }}</td>
                        </tr>
                        <tr>
                            <td>{{ config('ticket.labels.license_plate', 'Plat Nomor') }}</td>
                            <td>{{ $parking->license_plate }}</td>
                        </tr>
                        <tr>
                            <td>{{ config('ticket.labels.vehicle_type', 'Jenis Kendaraan') }}</td>
                            <td>{{ $parking->vehicleType->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ config('ticket.labels.entry_time', 'Waktu Masuk') }}</td>
                            <td>{{ $parking->entry_time->format(config('ticket.content.date_format', 'd/m/Y H:i')) }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="amount">
                    {{ config('ticket.labels.rate', 'Tarif') }}: Rp {{ number_format($parking->amount, 0, ',', '.') }}
                </div>

                @if (config('ticket.content.show_separator', true))
                    <div class="separator"></div>
                @endif

                <div class="footer">
                    @if (config('ticket.content.show_thank_you', true))
                        <p>{{ config('ticket.content.thank_you_text', 'Terima kasih atas kunjungan Anda') }}</p>
                    @endif
                    <p>{{ $parking->entry_time->format(config('ticket.content.footer_date_format', 'd-m-Y H:i:s')) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="no-print">
            <div class="action-buttons">
                <a href="{{ route('parking.create') }}" class="btn-primary">
                    <span class="icon icon-new"></span>
                    Transaksi Baru
                </a>
                <button onclick="printTicket();" class="btn-primary">
                    <span class="icon icon-print"></span>
                    Print Tiket
                </button>
            </div>

            <script>
                // Auto print when page loads from redirect after create
                @if (session('auto_print') || config('ticket.auto_print.enabled', false))
                    window.onload = function() {
                        // Add a small delay for mobile devices
                        const delay = /Mobi|Android/i.test(navigator.userAgent) ? 1000 :
                            {{ config('ticket.auto_print.delay', 500) }};

                        setTimeout(function() {
                            window.print();

                            // After print dialog, show options with improved mobile experience
                            setTimeout(function() {
                                Swal.fire({
                                    icon: 'question',
                                    title: 'Tiket Sudah Dicetak?',
                                    text: 'Pilih tindakan selanjutnya:',
                                    showDenyButton: true,
                                    showCancelButton: false,
                                    confirmButtonText: 'Transaksi Baru',
                                    denyButtonText: 'Kembali ke Daftar',
                                    confirmButtonColor: '#28a745',
                                    denyButtonColor: '#6c757d',
                                    customClass: {
                                        container: 'swal2-container-custom',
                                        popup: 'swal2-mobile-popup'
                                    },
                                    // Mobile-friendly settings
                                    width: window.innerWidth < 768 ? '90%' : '400px',
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInUp animate__faster'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutDown animate__faster'
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        showLoadingAndRedirect('{{ route('parking.create') }}',
                                            'Membuat transaksi baru...');
                                    } else if (result.isDenied) {
                                        showLoadingAndRedirect('{{ route('parking.index') }}',
                                            'Kembali ke daftar...');
                                    }
                                });
                            }, 1000);
                        }, delay);
                    };
                @endif

                // Enhanced print function with mobile considerations
                function printTicket() {
                    // Show loading state on mobile
                    if (window.innerWidth < 768) {
                        const printBtn = document.querySelector('.btn-primary');
                        const originalText = printBtn.innerHTML;

                        printBtn.innerHTML =
                            '<span style="display: inline-block; animation: spin 1s linear infinite;">⚡</span> Printing...';
                        printBtn.disabled = true;

                        setTimeout(() => {
                            window.print();

                            // Reset button after print dialog
                            setTimeout(() => {
                                printBtn.innerHTML = originalText;
                                printBtn.disabled = false;
                            }, 1000);
                        }, 300);
                    } else {
                        window.print();
                    }
                }

                // Loading and redirect function
                function showLoadingAndRedirect(url, message) {
                    Swal.fire({
                        title: 'Mohon Tunggu',
                        text: message,
                        icon: 'info',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    setTimeout(() => {
                        window.location.href = url;
                    }, 800);
                }

                // Handle print completion with mobile-friendly feedback
                window.addEventListener('beforeprint', function() {
                    console.log('Printing started...');

                    // Only hide mobile header during print, keep ticket content visible
                    const mobileHeader = document.querySelector('.mobile-header');
                    if (mobileHeader) {
                        mobileHeader.style.display = 'none';
                    }

                    // Ensure ticket content is visible for print
                    const ticketContainer = document.querySelector('.ticket-container');
                    const ticket = document.querySelector('.ticket');
                    if (ticketContainer) {
                        ticketContainer.style.display = 'block';
                        ticketContainer.style.visibility = 'visible';
                    }
                    if (ticket) {
                        ticket.style.display = 'block';
                        ticket.style.visibility = 'visible';
                    }
                });

                window.addEventListener('afterprint', function() {
                    console.log('Printing completed or cancelled');

                    // Show mobile elements again after print
                    const mobileHeader = document.querySelector('.mobile-header');
                    if (mobileHeader) {
                        mobileHeader.style.display = '';
                    }

                    const ticketContainer = document.querySelector('.ticket-container');
                    if (ticketContainer) {
                        ticketContainer.style.display = '';
                        ticketContainer.style.visibility = '';
                    }

                    // Show completion message on mobile
                    if (window.innerWidth < 768) {
                        const toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });

                        toast.fire({
                            icon: 'success',
                            title: 'Print selesai!'
                        });
                    }
                });

                // Enhanced mobile touch handling
                document.addEventListener('DOMContentLoaded', function() {
                    // Add touch feedback for mobile buttons
                    if ('ontouchstart' in window) {
                        const buttons = document.querySelectorAll('.action-buttons button, .action-buttons a');

                        buttons.forEach(button => {
                            button.addEventListener('touchstart', function() {
                                this.style.transform = 'scale(0.95)';
                            });

                            button.addEventListener('touchend', function() {
                                setTimeout(() => {
                                    this.style.transform = '';
                                }, 150);
                            });
                        });
                    }

                    // Prevent accidental zoom on double tap
                    let lastTouchEnd = 0;
                    document.addEventListener('touchend', function(event) {
                        const now = (new Date()).getTime();
                        if (now - lastTouchEnd <= 300) {
                            event.preventDefault();
                        }
                        lastTouchEnd = now;
                    }, false);

                    // Add swipe gestures for navigation (mobile only)
                    if (window.innerWidth < 768) {
                        let startX, startY;

                        document.addEventListener('touchstart', function(e) {
                            startX = e.touches[0].clientX;
                            startY = e.touches[0].clientY;
                        });

                        document.addEventListener('touchmove', function(e) {
                            e.preventDefault(); // Prevent scrolling during swipe
                        }, {
                            passive: false
                        });

                        document.addEventListener('touchend', function(e) {
                            if (!startX || !startY) return;

                            const endX = e.changedTouches[0].clientX;
                            const endY = e.changedTouches[0].clientY;

                            const diffX = startX - endX;
                            const diffY = startY - endY;

                            // Swipe right to go back
                            if (Math.abs(diffX) > Math.abs(diffY) && Math.abs(diffX) > 50) {
                                if (diffX < 0) { // Swipe right
                                    showLoadingAndRedirect('{{ route('parking.index') }}', 'Kembali ke daftar...');
                                }
                            }

                            startX = null;
                            startY = null;
                        });
                    }
                });

                // CSS animation for spinning icon
                const style = document.createElement('style');
                style.textContent = `
                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                .swal2-mobile-popup {
                    font-size: 16px !important;
                }

                @media (max-width: 768px) {
                    .swal2-popup {
                        width: 90% !important;
                        max-width: 350px !important;
                    }

                    .swal2-title {
                        font-size: 20px !important;
                    }

                    .swal2-content {
                        font-size: 16px !important;
                    }

                    .swal2-confirm,
                    .swal2-deny {
                        font-size: 16px !important;
                        padding: 12px 20px !important;
                        min-height: 44px !important;
                    }
                }
            `;
                document.head.appendChild(style);
            </script>
    </body>

</html>
