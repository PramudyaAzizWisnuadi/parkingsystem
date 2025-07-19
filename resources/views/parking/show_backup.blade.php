@extends('layouts.parking')

@section('title', 'Detail Transaksi - Sistem Parkir')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Transaksi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button id="printBtn1" class="btn btn-success">
                    <i class="fas fa-print"></i> Print Copy
                </button>
                <a href="{{ route('parking.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informasi Transaksi</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>No. Tiket:</strong></td>
                                    <td>{{ $parking->ticket_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Plat Nomor:</strong></td>
                                    <td>{{ $parking->license_plate }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Jenis Kendaraan:</strong></td>
                                    <td>{{ $parking->vehicleType->name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Tarif:</strong></td>
                                    <td>Rp {{ number_format($parking->amount, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Waktu Masuk:</strong></td>
                                    <td>{{ $parking->formatted_entry_time }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Catatan:</strong></td>
                                    <td>{{ $parking->notes ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button id="printBtn2" class="btn btn-success">
                            <i class="fas fa-print"></i> Print Copy
                        </button>
                        <a href="{{ route('parking.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Transaksi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden iframe for printing -->
    <iframe id="printFrame" style="display: none;"></iframe>
@endsection

@push('scripts')
    <script>
        // Global flag to prevent double execution
        let isPrinting = false;

        // Function to print ticket using hidden iframe (same as create.blade.php)
        function printTicket(printUrl, ticketNumber) {
            showNotification('info', 'Menyiapkan Print...', 
                `Memproses tiket ${ticketNumber} untuk print copy.`);

            // Remove existing print iframe if any
            const existingIframe = document.getElementById('printIframe');
            if (existingIframe) {
                existingIframe.remove();
            }

            // Create hidden iframe for printing
            const printIframe = document.createElement('iframe');
            printIframe.id = 'printIframe';
            printIframe.style.position = 'absolute';
            printIframe.style.top = '-9999px';
            printIframe.style.left = '-9999px';
            printIframe.style.width = '1px';
            printIframe.style.height = '1px';
            printIframe.style.border = 'none';
            printIframe.style.visibility = 'hidden';
            printIframe.style.opacity = '0';

            // Add iframe to document
            document.body.appendChild(printIframe);

            // Set timeout for loading
            let loadTimeout = setTimeout(() => {
                showNotification('error', 'Timeout Print',
                    'Print memerlukan waktu terlalu lama. Silakan print manual.');
                addManualPrintButton(printUrl, ticketNumber);
                if (printIframe.parentNode) {
                    printIframe.remove();
                }
                isPrinting = false;
            }, 10000); // 10 second timeout

            // Load the ticket content
            printIframe.onload = function() {
                clearTimeout(loadTimeout);

                try {
                    // Wait a moment for content to fully load
                    setTimeout(() => {
                        try {
                            // Trigger print from iframe
                            printIframe.contentWindow.print();

                            showNotification('success', 'Print Berhasil',
                                'Tiket copy sedang dikirim ke printer. Pastikan printer sudah siap.');

                            // Show post-print dialog after print
                            setTimeout(() => {
                                if (printIframe.parentNode) {
                                    printIframe.remove();
                                }
                                isPrinting = false;
                                showPostPrintDialog();
                            }, 2000);
                        } catch (printError) {
                            console.error('Print error:', printError);
                            showNotification('info', 'Print Manual',
                                'Auto print tidak tersedia. Gunakan tombol print manual.');
                            addManualPrintButton(printUrl, ticketNumber);
                            if (printIframe.parentNode) {
                                printIframe.remove();
                            }
                            isPrinting = false;
                        }
                    }, 1500);
                } catch (error) {
                    clearTimeout(loadTimeout);
                    console.error('Print setup error:', error);
                    showNotification('error', 'Print Error',
                        'Terjadi kesalahan saat print. Gunakan print manual.');
                    addManualPrintButton(printUrl, ticketNumber);
                    if (printIframe.parentNode) {
                        printIframe.remove();
                    }
                    isPrinting = false;
                }
            };

            // Set iframe source
            printIframe.src = printUrl;
        }

        // Add manual print button
        function addManualPrintButton(printUrl, ticketNumber) {
            const manualPrintBtn = document.createElement('button');
            manualPrintBtn.className = 'btn btn-outline-success btn-sm mt-2';
            manualPrintBtn.innerHTML = '<i class="fas fa-print"></i> Print Manual';
            manualPrintBtn.onclick = () => window.open(printUrl, '_blank');

            // Add to first card body
            const cardBody = document.querySelector('.card-body');
            if (cardBody && !document.querySelector('.manual-print-btn')) {
                manualPrintBtn.classList.add('manual-print-btn');
                cardBody.appendChild(manualPrintBtn);
            }
        }

        // Print ticket function triggered by buttons
        function printTicketFromDetail() {
            if (isPrinting) return;
            isPrinting = true;

            const printUrl = '{{ route('parking.print', ['parking' => $parking->id, 'copy' => true]) }}';
            const ticketNumber = '{{ $parking->ticket_number }}';
            
            printTicket(printUrl, ticketNumber);
        }

        // Show post print dialog
        function showPostPrintDialog() {
            Swal.fire({
                icon: 'question',
                title: 'Tiket Copy Sudah Dicetak?',
                text: 'Pilih tindakan selanjutnya:',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: 'Transaksi Baru',
                denyButtonText: 'Kembali ke Daftar',
                confirmButtonColor: '#28a745',
                denyButtonColor: '#6c757d',
                width: window.innerWidth < 768 ? '90%' : '400px'
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoadingAndRedirect('{{ route('parking.create') }}', 'Membuat transaksi baru...');
                } else if (result.isDenied) {
                    showLoadingAndRedirect('{{ route('parking.index') }}', 'Kembali ke daftar...');
                }
            });
        }

        // Notification system (same as create.blade.php)
        function showNotification(type, title, message) {
            const icon = type === 'success' ? 'success' : type === 'error' ? 'error' : 'info';
            const toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });

            toast.fire({
                icon: icon,
                title: title,
                text: message
            });
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
                didOpen: () => Swal.showLoading()
            });

            setTimeout(() => {
                window.location.href = url;
            }, 800);
        }

        // Event binding
        document.addEventListener('DOMContentLoaded', function() {
            const printBtn1 = document.getElementById('printBtn1');
            const printBtn2 = document.getElementById('printBtn2');
            
            if (printBtn1) {
                printBtn1.addEventListener('click', function(e) {
                    e.preventDefault();
                    printTicketFromDetail();
                });
            }
            
            if (printBtn2) {
                printBtn2.addEventListener('click', function(e) {
                    e.preventDefault();
                    printTicketFromDetail();
                });
            }

            // Touch feedback for mobile
            if ('ontouchstart' in window) {
                const buttons = document.querySelectorAll('.btn');
                buttons.forEach(button => {
                    button.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.95)';
                    }, { passive: true });
                    
                    button.addEventListener('touchend', function() {
                        setTimeout(() => {
                            this.style.transform = '';
                        }, 150);
                    }, { passive: true });
                });
            }
        });
    </script>

    <style>
        /* Loading button animation */
        .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile-friendly SweetAlert */
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

        /* Button hover effects */
        .btn:hover {
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .btn:active {
            transform: translateY(0);
        }
    </style>
@endpush
