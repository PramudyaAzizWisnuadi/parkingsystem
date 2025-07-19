@extends('layouts.parking')

@section('title', 'Kendaraan Masuk - ' . config('app.name'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Kendaraan Masuk</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('parking.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> <span class="d-none d-md-inline">Kembali</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('parking.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="license_plate" class="form-label">Plat Nomor Kendaraan</label>
                            <input type="text"
                                class="form-control form-control-lg @error('license_plate') is-invalid @enderror"
                                id="license_plate" name="license_plate" value="{{ old('license_plate') }}"
                                placeholder="Contoh: K 1234 ABC, K 5678 EF, atau AD 9999 AB" required autocomplete="off"
                                maxlength="12" style="text-transform: uppercase; font-weight: bold; letter-spacing: 1px;">
                            @error('license_plate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small class="text-muted">
                                    <strong>Format yang valid:</strong><br>
                                    • Wilayah 1 huruf: K 1234 ABC<br>
                                    • Wilayah 2 huruf: AD 1234 AB<br>
                                    • Otomatis diformat saat mengetik
                                </small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kendaraan</label>
                            <input type="hidden" id="vehicle_type_id" name="vehicle_type_id"
                                value="{{ old('vehicle_type_id') }}">
                            <div class="row g-2">
                                @foreach ($vehicleTypes as $vehicleType)
                                    <div class="col-6 col-md-4 col-lg-6 col-xl-4">
                                        <button type="button"
                                            class="btn btn-outline-primary vehicle-type-btn w-100 h-100 p-3"
                                            data-id="{{ $vehicleType->id }}" data-rate="{{ $vehicleType->flat_rate }}"
                                            data-name="{{ $vehicleType->name }}">
                                            <div class="d-flex flex-column">
                                                <strong class="mb-1">{{ $vehicleType->name }}</strong>
                                            </div>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                            @error('vehicle_type_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3"
                                placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                <i class="fas fa-save" id="submitIcon"></i>
                                <span id="submitText">Proses Masuk & Print Tiket</span>
                            </button>
                            <a href="{{ route('parking.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 mt-3 mt-lg-0">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informasi Tarif</h5>
                </div>
                <div class="card-body">
                    <div id="rate-info" class="alert alert-info" style="display: none;">
                        <strong>Tarif: </strong><span id="rate-amount">-</span>
                    </div>
                    <small class="text-muted">
                        Pilih jenis kendaraan untuk melihat tarif yang berlaku.
                    </small>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">
                        <i class="fas fa-keyboard text-info"></i> Keyboard Shortcuts
                    </h6>
                </div>
                <div class="card-body">
                    <small class="text-muted">
                        <strong>F1-F4:</strong> Pilih jenis kendaraan<br>
                        <strong>Ctrl+Enter:</strong> Submit form<br>
                        <strong>Ctrl+P:</strong> Print manual (jika tersedia)<br>
                        <strong>Esc:</strong> Reset form<br>
                        <strong>Tab:</strong> Navigasi antar field
                    </small>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title mb-0">Contoh Kode Wilayah</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <small class="text-muted">
                                <strong>1 Huruf:</strong><br>
                                B - Jakarta<br>
                                D - Bandung<br>
                                L - Surabaya<br>
                                N - Malang<br>
                                H - Semarang
                            </small>
                        </div>
                        <div class="col-6">
                            <small class="text-muted">
                                <strong>2 Huruf:</strong><br>
                                AA - Magelang<br>
                                BG - Palembang<br>
                                BK - Medan<br>
                                DK - Bali<br>
                                KB - Pontianak
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <style>
            .vehicle-type-btn {
                transition: all 0.3s ease;
                min-height: 80px;
                border: 2px solid #dee2e6;
            }

            .vehicle-type-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }

            .vehicle-type-btn.active {
                background-color: #0d6efd;
                border-color: #0d6efd;
                color: white;
            }

            .vehicle-type-btn.active:hover {
                background-color: #0b5ed7;
                border-color: #0a58ca;
            }

            /* Auto notification styles */
            .auto-notification {
                animation: slideInFromTop 0.5s ease-out;
                border-left: 4px solid;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .alert-success {
                border-left-color: #28a745;
            }

            .alert-info {
                border-left-color: #17a2b8;
            }

            .alert-danger {
                border-left-color: #dc3545;
            }

            /* Hidden print iframe */
            #printIframe {
                position: absolute !important;
                top: -9999px !important;
                left: -9999px !important;
                width: 1px !important;
                height: 1px !important;
                border: none !important;
                visibility: hidden !important;
                opacity: 0 !important;
            }

            @keyframes slideInFromTop {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Loading animation for submit button */
            .btn-warning .fa-spinner {
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }

            /* SweetAlert2 Custom Styles */
            .swal2-container-custom {
                z-index: 10000;
            }

            .swal2-popup {
                border-radius: 10px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                font-family: inherit;
            }

            .swal2-title {
                font-size: 1.5rem;
                font-weight: 600;
                color: #333;
                margin-bottom: 1rem;
            }

            .swal2-content {
                font-size: 1rem;
                color: #666;
                line-height: 1.5;
            }

            .swal2-confirm {
                padding: 10px 30px;
                border-radius: 5px;
                font-weight: 500;
                transition: all 0.3s ease;
            }

            .swal2-confirm:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }

            /* Toast styles */
            .swal2-toast {
                border-radius: 8px;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            }

            .swal2-toast .swal2-title {
                font-size: 1.1rem;
                margin-bottom: 0.5rem;
            }

            .swal2-toast .swal2-content {
                font-size: 0.9rem;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const vehicleTypeButtons = document.querySelectorAll('.vehicle-type-btn');
                const vehicleTypeInput = document.getElementById('vehicle_type_id');
                const rateInfo = document.getElementById('rate-info');
                const rateAmount = document.getElementById('rate-amount');
                const licensePlateInput = document.getElementById('license_plate');

                // License plate formatting function
                function formatLicensePlate(value) {
                    // Remove all non-alphanumeric characters except spaces
                    value = value.replace(/[^A-Za-z0-9\s]/g, '');

                    // Convert to uppercase
                    value = value.toUpperCase();

                    // Remove extra spaces
                    value = value.replace(/\s+/g, ' ').trim();

                    // Remove spaces for processing
                    const cleanValue = value.replace(/\s/g, '');

                    if (cleanValue.length === 0) {
                        return '';
                    }

                    // Indonesian license plate patterns:
                    // 1. Single letter region: B 1234 ABC (standard)
                    // 2. Double letter region: AA 1234 BB (some regions)

                    let formatted = '';

                    // Check if starts with 1 or 2 letters
                    const letterMatch = cleanValue.match(/^([A-Z]{1,2})/);
                    if (!letterMatch) {
                        return cleanValue; // Return as-is if doesn't start with letters
                    }

                    const regionCode = letterMatch[1];
                    const remaining = cleanValue.substring(regionCode.length);

                    // Add region code
                    formatted += regionCode;

                    if (remaining.length > 0) {
                        // Add space after region code
                        formatted += ' ';

                        // Extract numbers (1-4 digits)
                        const numberMatch = remaining.match(/^(\d{1,4})/);
                        if (numberMatch) {
                            const numbers = numberMatch[1];
                            formatted += numbers;

                            const afterNumbers = remaining.substring(numbers.length);
                            if (afterNumbers.length > 0) {
                                // Add space before suffix letters
                                formatted += ' ';

                                // Add suffix letters (1-3 characters)
                                const suffixMatch = afterNumbers.match(/^([A-Z]{1,3})/);
                                if (suffixMatch) {
                                    formatted += suffixMatch[1];
                                }
                            }
                        } else {
                            // If no numbers found, add what's remaining
                            formatted += remaining;
                        }
                    }

                    return formatted;
                }

                // Validate Indonesian license plate format
                function validateLicensePlate(value) {
                    // Remove spaces for validation
                    const cleanValue = value.replace(/\s/g, '');

                    // Indonesian license plate patterns:
                    // 1. Single letter region: B1234ABC (6-8 characters)
                    // 2. Double letter region: AA1234BB (8 characters)

                    const patterns = [
                        /^[A-Z]{1}\d{1,4}[A-Z]{1,3}$/, // Single letter region: B1234ABC
                        /^[A-Z]{2}\d{1,4}[A-Z]{1,2}$/ // Double letter region: AA1234BB
                    ];

                    return patterns.some(pattern => pattern.test(cleanValue));
                }

                // Show validation feedback
                function showValidationFeedback(isValid) {
                    const feedback = document.querySelector('#license_plate + .invalid-feedback');
                    if (!feedback) {
                        // Create feedback element if it doesn't exist
                        const feedbackElement = document.createElement('div');
                        feedbackElement.className = 'invalid-feedback';
                        licensePlateInput.parentNode.appendChild(feedbackElement);
                    }

                    if (isValid || licensePlateInput.value.trim() === '') {
                        licensePlateInput.classList.remove('is-invalid');
                        licensePlateInput.classList.add('is-valid');
                        document.querySelector('#license_plate + .invalid-feedback').style.display = 'none';
                    } else {
                        licensePlateInput.classList.add('is-invalid');
                        licensePlateInput.classList.remove('is-valid');
                        const feedbackEl = document.querySelector('#license_plate + .invalid-feedback');
                        feedbackEl.textContent = 'Format plat nomor tidak sesuai dengan regulasi Indonesia';
                        feedbackEl.style.display = 'block';
                    }
                }

                // Handle license plate input formatting
                licensePlateInput.addEventListener('input', function(e) {
                    const cursorPos = e.target.selectionStart;
                    const oldValue = e.target.value;
                    const newValue = formatLicensePlate(oldValue);

                    if (newValue !== oldValue) {
                        e.target.value = newValue;

                        // Adjust cursor position
                        let newCursorPos = cursorPos;
                        if (newValue.length > oldValue.length) {
                            newCursorPos++;
                        }
                        e.target.setSelectionRange(newCursorPos, newCursorPos);
                    }

                    // Validate format
                    if (newValue.length > 3) { // Start validating after reasonable input
                        const isValid = validateLicensePlate(newValue);
                        showValidationFeedback(isValid);
                    } else {
                        // Remove validation styling for short inputs
                        licensePlateInput.classList.remove('is-valid', 'is-invalid');
                        const feedbackEl = document.querySelector('#license_plate + .invalid-feedback');
                        if (feedbackEl) feedbackEl.style.display = 'none';
                    }
                });

                // Handle paste event
                licensePlateInput.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        const formatted = formatLicensePlate(e.target.value);
                        e.target.value = formatted;
                    }, 0);
                });

                // Handle vehicle type button clicks
                vehicleTypeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class from all buttons
                        vehicleTypeButtons.forEach(btn => btn.classList.remove('active'));

                        // Add active class to clicked button
                        this.classList.add('active');

                        // Set the hidden input value
                        const id = this.getAttribute('data-id');
                        const rate = this.getAttribute('data-rate');
                        const name = this.getAttribute('data-name');

                        vehicleTypeInput.value = id;

                        // Update rate display
                        if (rate) {
                            rateAmount.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(
                                rate);
                            rateInfo.style.display = 'block';
                        }
                    });
                });

                // Set initial state if there's an old value
                const oldValue = vehicleTypeInput.value;
                if (oldValue) {
                    const button = document.querySelector(`[data-id="${oldValue}"]`);
                    if (button) {
                        button.classList.add('active');
                        const rate = button.getAttribute('data-rate');
                        if (rate) {
                            rateAmount.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(rate);
                            rateInfo.style.display = 'block';
                        }
                    }
                }

                // Format existing license plate value if any
                if (licensePlateInput.value) {
                    licensePlateInput.value = formatLicensePlate(licensePlateInput.value);
                }

                // Form validation and AJAX submission
                document.querySelector('form').addEventListener('submit', function(e) {
                    // Hanya validasi jika submit dari tombol submit, bukan dari link lain (misal logout)
                    // Cek activeElement adalah tombol submit di form ini
                    const activeEl = document.activeElement;
                    const isSubmitBtn = activeEl && activeEl.type === 'submit' && activeEl.form === this;
                    // Atau jika submit via keyboard (Enter) di input
                    const isKeyboardSubmit = !activeEl || (activeEl.tagName === 'INPUT' || activeEl.tagName ===
                        'TEXTAREA');

                    if (isSubmitBtn || isKeyboardSubmit) {
                        e.preventDefault();

                        const licensePlateValue = licensePlateInput.value.trim();

                        if (licensePlateValue && !validateLicensePlate(licensePlateValue)) {
                            showValidationFeedback(false);
                            licensePlateInput.focus();
                            Swal.fire({
                                icon: 'error',
                                title: 'Format Plat Nomor Tidak Valid',
                                text: 'Mohon masukkan plat nomor dengan format yang sesuai regulasi Indonesia!',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33',
                                customClass: {
                                    container: 'swal2-container-custom'
                                }
                            });
                            return false;
                        }

                        // Check if vehicle type is selected
                        if (!vehicleTypeInput.value) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Jenis Kendaraan Belum Dipilih',
                                text: 'Mohon pilih jenis kendaraan terlebih dahulu!',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#ffc107',
                                customClass: {
                                    container: 'swal2-container-custom'
                                }
                            });
                            return false;
                        }

                        // Show loading state
                        const submitBtn = document.getElementById('submitBtn');
                        const submitIcon = document.getElementById('submitIcon');
                        const submitText = document.getElementById('submitText');

                        if (submitBtn && submitIcon && submitText) {
                            submitBtn.disabled = true;
                            submitIcon.className = 'fas fa-spinner fa-spin';
                            submitText.textContent = 'Memproses & Menyiapkan Tiket...';
                            submitBtn.classList.remove('btn-primary');
                            submitBtn.classList.add('btn-warning');
                        }

                        // Show processing notification
                        showNotification('info', 'Memproses transaksi...',
                            'Tiket akan otomatis terprint setelah selesai.');

                        // Prepare form data
                        const formData = new FormData(this);

                        // Submit via AJAX
                        fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .getAttribute('content')
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(err => Promise.reject(err));
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Show success message
                                    showNotification('success', 'Transaksi Berhasil!', data.message);

                                    // Auto print ticket
                                    printTicket(data.print_url, data.ticket_number);

                                    // Reset form after short delay
                                    setTimeout(() => {
                                        resetForm();
                                    }, 2000);
                                } else {
                                    throw new Error(data.message ||
                                        'Terjadi kesalahan saat memproses transaksi');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                let errorMessage = 'Terjadi kesalahan saat memproses transaksi';

                                // Handle validation errors
                                if (error.errors) {
                                    const firstError = Object.values(error.errors)[0];
                                    errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
                                } else if (error.message) {
                                    errorMessage = error.message;
                                }

                                showNotification('error', 'Gagal Memproses', errorMessage);
                                resetButtonState();
                            });
                    }
                });

                // Function to show notification
                function showNotification(type, title, message) {
                    // Configure SweetAlert2 based on type
                    let swalConfig = {
                        title: title,
                        text: message,
                        customClass: {
                            container: 'swal2-container-custom'
                        }
                    };

                    switch (type) {
                        case 'success':
                            swalConfig.icon = 'success';
                            swalConfig.confirmButtonColor = '#28a745';
                            swalConfig.timer = 3000;
                            swalConfig.showConfirmButton = false;
                            swalConfig.toast = true;
                            swalConfig.position = 'top-end';
                            break;
                        case 'info':
                            swalConfig.icon = 'info';
                            swalConfig.confirmButtonColor = '#17a2b8';
                            swalConfig.timer = 4000;
                            swalConfig.showConfirmButton = false;
                            swalConfig.toast = true;
                            swalConfig.position = 'top-end';
                            break;
                        case 'error':
                            swalConfig.icon = 'error';
                            swalConfig.confirmButtonColor = '#dc3545';
                            swalConfig.confirmButtonText = 'OK';
                            break;
                        default:
                            swalConfig.icon = 'info';
                            swalConfig.confirmButtonColor = '#6c757d';
                            swalConfig.timer = 3000;
                            swalConfig.showConfirmButton = false;
                            swalConfig.toast = true;
                            swalConfig.position = 'top-end';
                    }

                    Swal.fire(swalConfig);
                }

                // Function to print ticket using hidden iframe
                function printTicket(printUrl, ticketNumber) {
                    showNotification('info', 'Menyiapkan Print...',
                        `Memproses tiket ${ticketNumber} untuk print otomatis.`);

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
                    }, 10000); // 10 second timeout

                    // Load the ticket content
                    printIframe.onload = function() {
                        clearTimeout(loadTimeout);

                        try {
                            // Wait a moment for content to fully load
                            setTimeout(() => {
                                try {
                                    // Check if iframe content is accessible
                                    const iframeDoc = printIframe.contentDocument || printIframe
                                        .contentWindow.document;

                                    // Trigger print from iframe
                                    printIframe.contentWindow.print();

                                    showNotification('success', 'Print Berhasil',
                                        'Tiket sedang dikirim ke printer. Pastikan printer sudah siap.');

                                    // Remove iframe after print
                                    setTimeout(() => {
                                        if (printIframe.parentNode) {
                                            printIframe.remove();
                                        }
                                    }, 2000);
                                } catch (printError) {
                                    console.error('Print error:', printError);
                                    // Fallback to manual print button
                                    showNotification('info', 'Print Manual',
                                        'Auto print tidak tersedia. Gunakan tombol print manual.');
                                    addManualPrintButton(printUrl, ticketNumber);
                                    if (printIframe.parentNode) {
                                        printIframe.remove();
                                    }
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
                        }
                    };

                    // Handle iframe error
                    printIframe.onerror = function() {
                        clearTimeout(loadTimeout);
                        showNotification('error', 'Gagal Load Tiket',
                            'Tidak dapat memuat tiket untuk print. Gunakan print manual.');
                        addManualPrintButton(printUrl, ticketNumber);
                        if (printIframe.parentNode) {
                            printIframe.remove();
                        }
                    };

                    // Set iframe source to load the ticket
                    printIframe.src = printUrl;
                }

                // Function to add manual print button as fallback
                function addManualPrintButton(printUrl, ticketNumber) {
                    // Remove existing manual print button if any
                    const existingBtn = document.getElementById('manualPrintBtn');
                    if (existingBtn) {
                        existingBtn.remove();
                    }

                    // Create button container
                    const buttonContainer = document.createElement('div');
                    buttonContainer.id = 'manualPrintContainer';
                    buttonContainer.className = 'mt-3 d-flex gap-2 flex-wrap';

                    // Manual print button
                    const manualPrintBtn = document.createElement('a');
                    manualPrintBtn.id = 'manualPrintBtn';
                    manualPrintBtn.href = printUrl;
                    manualPrintBtn.target = '_blank';
                    manualPrintBtn.className = 'btn btn-success btn-lg';
                    manualPrintBtn.innerHTML = `
                        <i class="fas fa-print"></i> Print Tiket ${ticketNumber}
                    `;

                    // Download link button (alternative)
                    const downloadBtn = document.createElement('a');
                    downloadBtn.href = printUrl + '?download=1';
                    downloadBtn.target = '_blank';
                    downloadBtn.className = 'btn btn-info btn-lg';
                    downloadBtn.innerHTML = `
                        <i class="fas fa-download"></i> Download
                    `;

                    // Add buttons to container
                    buttonContainer.appendChild(manualPrintBtn);
                    buttonContainer.appendChild(downloadBtn);

                    // Insert after submit button
                    const submitBtn = document.getElementById('submitBtn');
                    submitBtn.parentNode.insertBefore(buttonContainer, submitBtn.nextSibling);

                    // Auto remove manual print buttons after 45 seconds
                    setTimeout(() => {
                        if (buttonContainer.parentNode) {
                            buttonContainer.remove();
                        }
                    }, 45000);

                    // Add info notification about manual options
                    showNotification('info', 'Opsi Manual Tersedia',
                        'Gunakan tombol Print untuk membuka di tab baru atau Download untuk menyimpan tiket.');
                }

                // Function to reset form
                function resetForm() {
                    document.querySelector('form').reset();
                    vehicleTypeInput.value = '';
                    vehicleTypeButtons.forEach(btn => btn.classList.remove('active'));
                    rateInfo.style.display = 'none';
                    licensePlateInput.classList.remove('is-valid', 'is-invalid');
                    const feedbackEl = document.querySelector('#license_plate + .invalid-feedback');
                    if (feedbackEl) feedbackEl.style.display = 'none';

                    // Remove manual print container if exists
                    const manualPrintContainer = document.getElementById('manualPrintContainer');
                    if (manualPrintContainer) {
                        manualPrintContainer.remove();
                    }

                    // Remove print iframe if exists
                    const printIframe = document.getElementById('printIframe');
                    if (printIframe) {
                        printIframe.remove();
                    }

                    resetButtonState();
                    licensePlateInput.focus();

                    showNotification('info', 'Form Reset', 'Siap untuk transaksi berikutnya.');
                }

                // Function to reset button state
                function resetButtonState() {
                    const submitBtn = document.getElementById('submitBtn');
                    const submitIcon = document.getElementById('submitIcon');
                    const submitText = document.getElementById('submitText');

                    if (submitBtn && submitIcon && submitText) {
                        submitBtn.disabled = false;
                        submitIcon.className = 'fas fa-save';
                        submitText.textContent = 'Proses Masuk & Print Tiket';
                        submitBtn.classList.remove('btn-warning');
                        submitBtn.classList.add('btn-primary');
                    }
                }

                // Auto focus on license plate input
                licensePlateInput.focus();

                // Keyboard shortcuts
                document.addEventListener('keydown', function(e) {
                    // Ctrl + Enter to submit form
                    if (e.ctrlKey && e.key === 'Enter') {
                        e.preventDefault();
                        document.querySelector('form').dispatchEvent(new Event('submit'));
                    }

                    // F1-F4 to select vehicle types quickly
                    if (e.key >= 'F1' && e.key <= 'F4') {
                        e.preventDefault();
                        const index = parseInt(e.key.replace('F', '')) - 1;
                        const buttons = document.querySelectorAll('.vehicle-type-btn');
                        if (buttons[index]) {
                            buttons[index].click();
                        }
                    }

                    // Escape to reset form
                    if (e.key === 'Escape') {
                        e.preventDefault();

                        // Check if form has any data before showing confirmation
                        const hasData = licensePlateInput.value.trim() !== '' || vehicleTypeInput.value !==
                            '' || document.getElementById('notes').value.trim() !== '';

                        if (hasData) {
                            Swal.fire({
                                icon: 'question',
                                title: 'Reset Form?',
                                text: 'Apakah Anda yakin ingin menghapus semua data yang telah diisi?',
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Reset',
                                cancelButtonText: 'Batal',
                                confirmButtonColor: '#dc3545',
                                cancelButtonColor: '#6c757d',
                                customClass: {
                                    container: 'swal2-container-custom'
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    resetForm();
                                }
                            });
                        } else {
                            resetForm();
                        }
                    }

                    // Ctrl + P for manual print (if manual print button exists)
                    if (e.ctrlKey && e.key.toLowerCase() === 'p') {
                        const manualPrintBtn = document.getElementById('manualPrintBtn');
                        if (manualPrintBtn) {
                            e.preventDefault();
                            manualPrintBtn.click();
                        }
                    }
                });

                // Detect browser capabilities for print optimization
                function detectPrintCapabilities() {
                    try {
                        // Test if we can access iframe content (will throw error in some browsers)
                        const testIframe = document.createElement('iframe');
                        testIframe.style.display = 'none';
                        document.body.appendChild(testIframe);

                        setTimeout(() => {
                            try {
                                const iframeDoc = testIframe.contentDocument || testIframe.contentWindow
                                    .document;
                                // If we can access it, iframe printing should work
                                document.body.removeChild(testIframe);
                            } catch (e) {
                                // Iframe content not accessible, may need fallback
                                document.body.removeChild(testIframe);
                                console.warn('Iframe printing may be limited in this browser');
                            }
                        }, 100);
                    } catch (e) {
                        console.warn('Browser has limited iframe capabilities');
                    }
                }

                // Run browser detection
                detectPrintCapabilities();
            });
        </script>
    @endpush
@endsection
