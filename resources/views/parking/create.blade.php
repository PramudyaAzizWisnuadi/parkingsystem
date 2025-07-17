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
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Proses Masuk
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

                // Form validation before submit
                document.querySelector('form').addEventListener('submit', function(e) {
                    const licensePlateValue = licensePlateInput.value.trim();

                    if (licensePlateValue && !validateLicensePlate(licensePlateValue)) {
                        e.preventDefault();
                        showValidationFeedback(false);
                        licensePlateInput.focus();

                        // Show alert
                        alert('Mohon masukkan plat nomor dengan format yang sesuai regulasi Indonesia!');
                        return false;
                    }

                    // Check if vehicle type is selected
                    if (!vehicleTypeInput.value) {
                        e.preventDefault();
                        alert('Mohon pilih jenis kendaraan!');
                        return false;
                    }
                });

                // Auto focus on license plate input
                licensePlateInput.focus();
            });
        </script>
    @endpush
@endsection
