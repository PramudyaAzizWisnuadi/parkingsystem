@extends('layouts.parking')

@section('title', 'Konfigurasi Tiket - ' . config('app.name'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-cog me-2"></i>
            Konfigurasi Tiket Parkir
        </h1>
        <div class="btn-group">
            <button type="button" class="btn btn-warning" onclick="resetConfig()">
                <i class="fas fa-undo me-1"></i>
                Reset Default
            </button>
            <button type="button" class="btn btn-secondary" onclick="showPreviewModal()">
                <i class="fas fa-eye me-1"></i>
                Preview Tiket
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Error!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.ticket-config.update') }}" method="POST" id="configForm">
        @csrf
        @method('PUT')

        <div class="row">
            <!-- Company Information -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-building me-2"></i>
                            Informasi Perusahaan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_company_title"
                                    name="show_company_title" {{ env('TICKET_SHOW_COMPANY_INFO', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_company_title">
                                    Tampilkan Judul Perusahaan
                                </label>
                            </div>
                            <input type="text" class="form-control mt-2" name="company_title"
                                value="{{ env('TICKET_TITLE', 'TIKET PARKIR') }}" placeholder="Judul Perusahaan">
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_company_name"
                                    name="show_company_name" {{ env('TICKET_SHOW_COMPANY_NAME', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_company_name">
                                    Tampilkan Nama Perusahaan
                                </label>
                            </div>
                            <input type="text" class="form-control mt-2" name="company_name"
                                value="{{ env('TICKET_COMPANY_NAME', 'Manajemen Parkir') }}" placeholder="Nama Perusahaan">
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_company_address"
                                    name="show_company_address"
                                    {{ env('TICKET_SHOW_COMPANY_ADDRESS', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_company_address">
                                    Tampilkan Alamat
                                </label>
                            </div>
                            <textarea class="form-control mt-2" name="company_address" rows="2" placeholder="Alamat Perusahaan">{{ env('TICKET_ADDRESS', '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_company_phone"
                                    name="show_company_phone" {{ env('TICKET_SHOW_COMPANY_PHONE', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_company_phone">
                                    Tampilkan Telepon
                                </label>
                            </div>
                            <input type="text" class="form-control mt-2" name="company_phone"
                                value="{{ env('TICKET_PHONE', '') }}" placeholder="Nomor Telepon">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field Settings -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2"></i>
                            Field Tiket
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_ticket_number"
                                    name="show_ticket_number"
                                    {{ env('TICKET_SHOW_TICKET_NUMBER', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_ticket_number">
                                    Tampilkan Nomor Tiket
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_license_plate"
                                    name="show_license_plate"
                                    {{ env('TICKET_SHOW_LICENSE_PLATE', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_license_plate">
                                    Tampilkan Plat Nomor
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_vehicle_type"
                                    name="show_vehicle_type" {{ env('TICKET_SHOW_VEHICLE_TYPE', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_vehicle_type">
                                    Tampilkan Jenis Kendaraan
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_entry_time"
                                    name="show_entry_time" {{ env('TICKET_SHOW_ENTRY_TIME', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_entry_time">
                                    Tampilkan Waktu Masuk
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_amount" name="show_amount"
                                    {{ env('TICKET_SHOW_AMOUNT', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_amount">
                                    Tampilkan Tarif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Settings -->
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-align-left me-2"></i>
                            Footer & Pesan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_footer_message"
                                    name="show_footer_message" {{ env('TICKET_SHOW_THANK_YOU', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_footer_message">
                                    Tampilkan Pesan Footer
                                </label>
                            </div>
                            <textarea class="form-control mt-2" name="footer_message" rows="2" placeholder="Pesan footer">{{ env('TICKET_THANK_YOU_TEXT', 'Terima kasih atas kunjungan Anda') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_separator"
                                    name="show_middle_separator"
                                    {{ env('TICKET_SHOW_SEPARATOR', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_separator">
                                    Tampilkan Garis Pemisah
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auto Print Settings -->
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-print me-2"></i>
                            Pengaturan Auto Print
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="auto_print_enabled"
                                name="auto_print_enabled" {{ env('TICKET_AUTO_PRINT', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_print_enabled">
                                Aktifkan Auto Print
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mb-4">
            <button type="button" class="btn btn-secondary me-2" onclick="window.history.back()">
                <i class="fas fa-arrow-left me-1"></i>
                Kembali
            </button>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i>
                Simpan Konfigurasi
            </button>
        </div>
    </form>

    <!-- Reset Confirmation Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Konfigurasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mereset semua konfigurasi ke nilai default?</p>
                    <p class="text-warning"><small><strong>Peringatan:</strong> Semua pengaturan kustom akan
                            hilang!</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form action="{{ route('admin.ticket-config.reset') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-undo me-1"></i>
                            Reset
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Ticket Modal -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">
                        <i class="fas fa-eye me-2"></i>
                        Preview Tiket Parkir
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Preview Real-time:</strong> Perubahan konfigurasi akan langsung terlihat di preview ini.
                    </div>
                    <div class="ticket-preview-container">
                        <div class="ticket-preview">
                            <!-- Preview content will be loaded here -->
                            <div id="previewContent">
                                <div class="loading-spinner">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2">Memuat preview...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-lightbulb me-1"></i>
                            Tips: Ubah pengaturan di form untuk melihat perubahan secara langsung
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Tutup
                    </button>
                    <button type="button" class="btn btn-primary" onclick="printPreview()">
                        <i class="fas fa-print me-1"></i>
                        Print Preview
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <style>
        .ticket-preview-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 400px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 30px;
            margin: 20px 0;
        }

        .ticket-preview {
            width: 58mm;
            max-width: 220px;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            text-align: center;
        }

        .ticket-preview h1 {
            margin: 0 0 8px 0;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .ticket-preview h2 {
            margin: 0 0 10px 0;
            font-size: 14px;
            font-weight: normal;
            color: #6c757d;
        }

        .ticket-preview .company-info {
            margin: 8px 0;
            font-size: 11px;
            color: #6c757d;
        }

        .ticket-preview .company-info p {
            margin: 2px 0;
        }

        .ticket-preview .ticket-info {
            text-align: left;
            margin: 10px 0;
            font-size: 11px;
        }

        .ticket-preview .ticket-info table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-preview .ticket-info td {
            padding: 2px 0;
            vertical-align: top;
        }

        .ticket-preview .ticket-info td:first-child {
            width: 40%;
            font-weight: 500;
        }

        .ticket-preview .ticket-info td:last-child {
            text-align: right;
            font-weight: bold;
            width: 60%;
        }

        .ticket-preview .amount {
            font-size: 13px;
            font-weight: bold;
            margin: 12px 0;
            text-align: center;
            padding: 6px 0;
            color: #28a745;
        }

        .ticket-preview .separator {
            border-top: 1px dashed #000;
            margin: 8px 0;
        }

        .ticket-preview .footer {
            margin-top: 10px;
            font-size: 10px;
            text-align: center;
            color: #6c757d;
        }

        .ticket-preview .footer p {
            margin: 2px 0;
        }

        .loading-spinner {
            text-align: center;
            padding: 40px;
        }
    </style>

    <script>
        function resetConfig() {
            const modal = new bootstrap.Modal(document.getElementById('resetModal'));
            modal.show();
        }

        function showPreviewModal() {
            const modal = new bootstrap.Modal(document.getElementById('previewModal'));
            modal.show();

            // Load preview content
            loadPreviewContent();
        }

        function loadPreviewContent() {
            const previewContent = document.getElementById('previewContent');

            // Get current form values
            const formData = new FormData(document.getElementById('configForm'));

            // Create preview HTML based on current settings
            const previewHTML = generatePreviewHTML(formData);

            // Show loading briefly then update content
            previewContent.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memperbarui preview...</p>
                </div>
            `;

            setTimeout(() => {
                previewContent.innerHTML = previewHTML;
            }, 300);
        }

        function generatePreviewHTML(formData) {
            let html = '';

            // Company Title
            if (formData.get('show_company_title')) {
                const title = formData.get('company_title') || 'TIKET PARKIR';
                html += `<h1>${title}</h1>`;
            }

            // Company Name
            if (formData.get('show_company_name')) {
                const name = formData.get('company_name') || 'Manajemen Parkir';
                html += `<h2>${name}</h2>`;
            }

            // Company Address
            if (formData.get('show_company_address')) {
                const address = formData.get('company_address');
                if (address) {
                    html += `<div class="company-info"><p>${address}</p></div>`;
                }
            }

            // Company Phone
            if (formData.get('show_company_phone')) {
                const phone = formData.get('company_phone');
                if (phone) {
                    html += `<div class="company-info"><p>${phone}</p></div>`;
                }
            }

            // Separator after company info (only if address or phone exists)
            const hasAddress = formData.get('show_company_address') && formData.get('company_address');
            const hasPhone = formData.get('show_company_phone') && formData.get('company_phone');
            if (hasAddress || hasPhone) {
                html += `<div class="separator"></div>`;
            }

            // Ticket Info
            html += `<div class="ticket-info"><table>`;

            if (formData.get('show_ticket_number')) {
                html += `<tr><td>No. Tiket</td><td>P001</td></tr>`;
            }

            if (formData.get('show_license_plate')) {
                html += `<tr><td>Plat Nomor</td><td>B 1234 CD</td></tr>`;
            }

            if (formData.get('show_vehicle_type')) {
                html += `<tr><td>Jenis</td><td>Motor</td></tr>`;
            }

            if (formData.get('show_entry_time')) {
                const now = new Date();
                const formatted = now.toLocaleDateString('id-ID') + ' ' + now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });
                html += `<tr><td>Waktu Masuk</td><td>${formatted}</td></tr>`;
            }

            html += `</table></div>`;

            // Amount
            if (formData.get('show_amount')) {
                html += `<div class="amount">Tarif: Rp 2.000</div>`;
            }

            // Footer separator (controlled by show_middle_separator)
            if (formData.get('show_middle_separator')) {
                html += `<div class="separator"></div>`;
            }

            // Footer message
            if (formData.get('show_footer_message')) {
                const message = formData.get('footer_message') || 'Terima kasih atas kunjungan Anda';
                html += `<div class="footer"><p>${message}</p></div>`;
            }

            return html;
        }

        function printPreview() {
            const previewContent = document.getElementById('previewContent').innerHTML;

            // Create a new window for printing
            const printWindow = window.open('', '_blank');
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Preview Tiket Parkir</title>
                    <style>
                        @page {
                            size: 58mm auto;
                            margin: 0;
                        }
                        body {
                            font-family: Arial, sans-serif;
                            margin: 0;
                            padding: 8px;
                            background: white;
                        }
                        .ticket-preview {
                            width: 58mm;
                            background: white;
                            font-size: 12px;
                            line-height: 1.4;
                            text-align: center;
                        }
                        .ticket-preview h1 {
                            margin: 0 0 8px 0;
                            font-size: 16px;
                            font-weight: bold;
                            color: #333;
                        }
                        .ticket-preview h2 {
                            margin: 0 0 10px 0;
                            font-size: 14px;
                            font-weight: normal;
                            color: #666;
                        }
                        .ticket-preview .company-info {
                            margin: 8px 0;
                            font-size: 11px;
                            color: #666;
                        }
                        .ticket-preview .company-info p {
                            margin: 2px 0;
                        }
                        .ticket-preview .ticket-info {
                            text-align: left;
                            margin: 10px 0;
                            font-size: 11px;
                        }
                        .ticket-preview .ticket-info table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        .ticket-preview .ticket-info td {
                            padding: 2px 0;
                            vertical-align: top;
                        }
                        .ticket-preview .ticket-info td:first-child {
                            width: 40%;
                            font-weight: 500;
                        }
                        .ticket-preview .ticket-info td:last-child {
                            text-align: right;
                            font-weight: bold;
                            width: 60%;
                        }
                        .ticket-preview .amount {
                            font-size: 13px;
                            font-weight: bold;
                            margin: 12px 0;
                            text-align: center;
                            padding: 6px 0;
                            color: #000;
                        }
                        .ticket-preview .separator {
                            border-top: 1px dashed #000;
                            margin: 8px 0;
                        }
                        .ticket-preview .footer {
                            margin-top: 10px;
                            font-size: 10px;
                            text-align: center;
                            color: #666;
                        }
                        .ticket-preview .footer p {
                            margin: 2px 0;
                        }
                    </style>
                </head>
                <body>
                    <div class="ticket-preview">
                        ${previewContent}
                    </div>
                </body>
                </html>
            `);

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }

        // Toggle dependent fields based on switches
        document.addEventListener('DOMContentLoaded', function() {
            const switches = document.querySelectorAll('.form-check-input[type="checkbox"]');

            switches.forEach(switchEl => {
                const parentDiv = switchEl.closest('.mb-3');
                const inputs = parentDiv.querySelectorAll('input:not([type="checkbox"]), textarea, select');

                function toggleInputs() {
                    inputs.forEach(input => {
                        if (switchEl.checked) {
                            input.removeAttribute('disabled');
                            input.style.opacity = '1';
                        } else {
                            input.setAttribute('disabled', 'disabled');
                            input.style.opacity = '0.5';
                        }
                    });
                }

                // Initial state
                toggleInputs();

                // On change
                switchEl.addEventListener('change', function() {
                    toggleInputs();
                    // Update preview if modal is open
                    updateLivePreview();
                });
            });

            // Add event listeners for live preview update
            const formInputs = document.querySelectorAll(
                '#configForm input, #configForm textarea, #configForm select');
            formInputs.forEach(input => {
                input.addEventListener('input', updateLivePreview);
                input.addEventListener('change', updateLivePreview);
            });
        });

        function updateLivePreview() {
            const modal = document.getElementById('previewModal');
            if (modal && modal.classList.contains('show')) {
                loadPreviewContent();
            }
        }

        // Add floating preview button
        function createFloatingPreview() {
            const floatingBtn = document.createElement('div');
            floatingBtn.innerHTML = `
                <button type="button" class="btn btn-primary btn-sm" onclick="showPreviewModal()"
                        style="position: fixed; bottom: 20px; right: 20px; z-index: 1050; border-radius: 50%; width: 60px; height: 60px; box-shadow: 0 4px 15px rgba(0,123,255,0.4);">
                    <i class="fas fa-eye"></i>
                </button>
            `;
            document.body.appendChild(floatingBtn);
        }

        // Initialize floating preview on page load
        document.addEventListener('DOMContentLoaded', function() {
            createFloatingPreview();
        });
    </script>
@endpush
