@extends('layouts.parking')

@section('title', 'Detail Transaksi - Sistem Parkir')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Transaksi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('parking.print', $parking->id) }}" class="btn btn-success" target="_blank">
                    <i class="fas fa-print"></i> Print Tiket
                </a>
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
                        <a href="{{ route('parking.print', $parking->id) }}" class="btn btn-success" target="_blank">
                            <i class="fas fa-print"></i> Print Tiket
                        </a>
                        <a href="{{ route('parking.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Transaksi Baru
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
