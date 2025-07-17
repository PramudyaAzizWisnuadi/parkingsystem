@extends('layouts.parking')

@section('title', 'Konfigurasi Tiket - ' . config('app.name'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Konfigurasi Tiket</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Pengaturan Tiket</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('ticket-config.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Company Information -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Informasi Perusahaan</h6>
                            </div>
                            <div class="col-md-6">
                                <label for="company_title" class="form-label">Judul Tiket</label>
                                <input type="text" class="form-control" id="company_title" name="company_title"
                                    value="{{ config('ticket.company.title') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company_name" class="form-label">Nama Perusahaan</label>
                                <input type="text" class="form-control" id="company_name" name="company_name"
                                    value="{{ config('ticket.company.name') }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="company_address" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="company_address" name="company_address"
                                    value="{{ config('ticket.company.address') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="company_phone" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="company_phone" name="company_phone"
                                    value="{{ config('ticket.company.phone') }}">
                            </div>
                        </div>

                        <!-- Paper Settings -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Pengaturan Kertas</h6>
                            </div>
                            <div class="col-md-6">
                                <label for="paper_width" class="form-label">Lebar Kertas</label>
                                <input type="text" class="form-control" id="paper_width" name="paper_width"
                                    value="{{ config('ticket.paper.width') }}" required>
                            </div>
                        </div>

                        <!-- Font Settings -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Pengaturan Font</h6>
                            </div>
                            <div class="col-md-3">
                                <label for="font_size_base" class="form-label">Ukuran Font Dasar</label>
                                <input type="text" class="form-control" id="font_size_base" name="font_size_base"
                                    value="{{ config('ticket.font.size_base') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="font_size_title" class="form-label">Ukuran Font Judul</label>
                                <input type="text" class="form-control" id="font_size_title" name="font_size_title"
                                    value="{{ config('ticket.font.size_title') }}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="font_size_info" class="form-label">Ukuran Font Info</label>
                                <input type="text" class="form-control" id="font_size_info" name="font_size_info"
                                    value="{{ config('ticket.font.size_info') }}" required>
                            </div>
                        </div>

                        <!-- Content Settings -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Pengaturan Konten</h6>
                            </div>
                            <div class="col-md-6">
                                <label for="thank_you_text" class="form-label">Teks Terima Kasih</label>
                                <input type="text" class="form-control" id="thank_you_text" name="thank_you_text"
                                    value="{{ config('ticket.content.thank_you_text') }}" required>
                            </div>
                        </div>

                        <!-- Display Options -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <h6 class="fw-bold">Opsi Tampilan</h6>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_company_info"
                                        name="show_company_info"
                                        {{ config('ticket.content.show_company_info') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_company_info">
                                        Tampilkan Informasi Perusahaan
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_separator"
                                        name="show_separator"
                                        {{ config('ticket.content.show_separator') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_separator">
                                        Tampilkan Pemisah
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="show_thank_you"
                                        name="show_thank_you"
                                        {{ config('ticket.content.show_thank_you') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="show_thank_you">
                                        Tampilkan Terima Kasih
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="auto_print" name="auto_print"
                                        {{ config('ticket.auto_print.enabled') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="auto_print">
                                        Auto Print Tiket
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Konfigurasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Preview Tiket</h5>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <a href="{{ route('parking.print', 1) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-eye"></i> Lihat Preview
                        </a>
                    </div>
                    <hr>
                    <small class="text-muted">
                        <strong>Catatan:</strong> Setelah mengubah konfigurasi, Anda dapat melihat preview tiket untuk
                        memastikan tampilan sudah sesuai keinginan.
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection
