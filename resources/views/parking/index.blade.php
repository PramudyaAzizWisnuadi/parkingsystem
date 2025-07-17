@extends('layouts.parking')

@section('title', 'Transaksi Parkir - ' . config('app.name'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Transaksi Parkir</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('parking.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Kendaraan Masuk
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($transactions->count() > 0)
                <div class="table-responsive">
                    <table id="transactionsTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No. Tiket</th>
                                <th>Plat Nomor</th>
                                <th>Jenis Kendaraan</th>
                                <th>Tarif</th>
                                <th>Waktu Masuk</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->ticket_number }}</td>
                                    <td>{{ $transaction->license_plate }}</td>
                                    <td>{{ $transaction->vehicleType->name }}</td>
                                    <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td>{{ $transaction->formatted_entry_time }}</td>
                                    <td>
                                        <a href="{{ route('parking.show', $transaction->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i> <span class="d-none d-lg-inline">Detail</span>
                                        </a>
                                        <a href="{{ route('parking.print', $transaction->id) }}"
                                            class="btn btn-sm btn-outline-success" target="_blank">
                                            <i class="fas fa-print"></i> <span class="d-none d-lg-inline">Print</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada transaksi parkir</p>
                    <a href="{{ route('parking.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Mulai Transaksi
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable({
                responsive: true,
                ordering: false, // Disable sorting for all columns
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                columnDefs: [{
                    targets: [5], // Aksi column
                    orderable: false,
                    searchable: false
                }],
                pageLength: 25,
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Semua"]
                ]
            });
        });
    </script>
@endpush
