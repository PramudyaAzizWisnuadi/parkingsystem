@extends('layouts.parking')

@section('title', 'Hasil Laporan - Sistem Parkir')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Hasil Laporan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <form action="{{ route('reports.export') }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="start_date" value="{{ $request->start_date }}">
                    <input type="hidden" name="end_date" value="{{ $request->end_date }}">
                    <input type="hidden" name="vehicle_type_id" value="{{ $request->vehicle_type_id }}">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </button>
                </form>
                <a href="{{ route('reports.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Ringkasan Laporan</h5>
                    <p class="text-muted mb-0">
                        Periode: {{ date('d/m/Y', strtotime($request->start_date)) }} -
                        {{ date('d/m/Y', strtotime($request->end_date)) }}
                    </p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Transaksi</h5>
                                    <h3>{{ $summary['total_transactions'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-6">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pendapatan</h5>
                                    <h3>Rp {{ number_format($summary['total_revenue'], 0, ',', '.') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($summary['by_vehicle_type']->count() > 0)
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <h6>Berdasarkan Jenis Kendaraan:</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Jenis Kendaraan</th>
                                                <th>Jumlah Transaksi</th>
                                                <th>Pendapatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($summary['by_vehicle_type'] as $vehicleType => $data)
                                                <tr>
                                                    <td>{{ $vehicleType }}</td>
                                                    <td>{{ $data['count'] }}</td>
                                                    <td>Rp {{ number_format($data['revenue'], 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Detail Transaksi</h5>
                </div>
                <div class="card-body">
                    @if ($transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No. Tiket</th>
                                        <th>Plat Nomor</th>
                                        <th class="d-none d-md-table-cell">Jenis Kendaraan</th>
                                        <th>Tarif</th>
                                        <th class="d-none d-sm-table-cell">Waktu Masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->ticket_number }}</td>
                                            <td>{{ $transaction->license_plate }}</td>
                                            <td class="d-none d-md-table-cell">{{ $transaction->vehicleType->name }}</td>
                                            <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                            <td class="d-none d-sm-table-cell">{{ $transaction->formatted_entry_time }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada transaksi pada periode yang dipilih</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
