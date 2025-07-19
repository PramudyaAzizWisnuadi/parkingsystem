@extends('layouts.parking')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('parking.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> <span class="d-none d-sm-inline">Kendaraan Masuk</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-6 col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">
                    <i class="fas fa-car"></i> <span class="d-none d-sm-inline">Transaksi</span> Hari Ini
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $stats['today_transactions'] }}</h5>
                    <p class="card-text">Kendaraan masuk</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">
                    <i class="fas fa-money-bill-wave"></i> <span class="d-none d-sm-inline">Pendapatan</span> Hari Ini
                </div>
                <div class="card-body">
                    <h5 class="card-title">Rp {{ number_format($stats['today_revenue'], 0, ',', '.') }}</h5>
                    <p class="card-text">Total pendapatan</p>
                </div>
            </div>
        </div>
        @if (Auth::check() && Auth::user()->role === 'admin')
            <div class="col-6 col-md-3">
                <div class="card text-white bg-info mb-3">
                    <div class="card-header">
                        <i class="fas fa-chart-line"></i> <span class="d-none d-sm-inline">Total</span> Transaksi
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $stats['total_transactions'] }}</h5>
                        <p class="card-text">Keseluruhan</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">
                        <i class="fas fa-coins"></i> <span class="d-none d-sm-inline">Total</span> Pendapatan
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h5>
                        <p class="card-text">Keseluruhan</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if (Auth::check() && Auth::user()->role === 'admin')
        <!-- Charts Section - Only for Admin -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card chart-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-chart-pie text-primary"></i> Distribusi Kendaraan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="vehicleTypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card chart-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-chart-line text-success"></i> Pendapatan 7 Hari Terakhir
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card chart-card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="fas fa-chart-bar text-info"></i> Transaksi Harian (30 Hari Terakhir)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="dailyTransactionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Transaksi Terbaru</h5>
                </div>
                <div class="card-body">
                    @if ($recentTransactions->count() > 0)
                        <div class="table-responsive">
                            <table id="recentTransactionsTable" class="table table-striped">
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
                                    @foreach ($recentTransactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction->ticket_number }}</td>
                                            <td>{{ $transaction->license_plate }}</td>
                                            <td>{{ $transaction->vehicleType->name }}</td>
                                            <td>Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                            <td>{{ $transaction->formatted_entry_time }}</td>
                                            <td>
                                                <a href="{{ route('parking.show', $transaction->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i> <span
                                                        class="d-none d-lg-inline">Detail</span>
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
                            <p class="text-muted">Belum ada transaksi</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            $('#recentTransactionsTable').DataTable({
                responsive: true,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
                },
                paging: false,
                searching: false,
                info: false,
                ordering: false,
                columnDefs: [{
                    targets: [5], // Aksi column
                    orderable: false,
                    searchable: false
                }]
            });
        });

        @if (Auth::check() && Auth::user()->role === 'admin')
            // Chart.js configurations for admin

            // Vehicle Type Distribution Chart
            const vehicleTypeCtx = document.getElementById('vehicleTypeChart').getContext('2d');
            fetch('/api/chart-data/vehicle-types')
                .then(response => response.json())
                .then(data => {
                    new Chart(vehicleTypeCtx, {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: [
                                    '#FF6384',
                                    '#36A2EB',
                                    '#FFCE56',
                                    '#4BC0C0',
                                    '#9966FF',
                                    '#FF9F40'
                                ],
                                borderWidth: 2,
                                borderColor: '#fff'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 15,
                                        usePointStyle: true
                                    }
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.label + ': ' + context.parsed + ' kendaraan';
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading vehicle types chart:', error);
                });

            // Revenue Chart (Last 7 Days)
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            fetch('/api/chart-data/revenue-weekly')
                .then(response => response.json())
                .then(data => {
                    new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Pendapatan (Rp)',
                                data: data.data,
                                borderColor: '#28a745',
                                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                                borderWidth: 3,
                                fill: true,
                                tension: 0.4,
                                pointBackgroundColor: '#28a745',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 5
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return 'Rp ' + value.toLocaleString('id-ID');
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading revenue chart:', error);
                });

            // Daily Transaction Chart (Last 30 Days)
            const dailyTransactionCtx = document.getElementById('dailyTransactionChart').getContext('2d');
            fetch('/api/chart-data/daily-transactions')
                .then(response => response.json())
                .then(data => {
                    new Chart(dailyTransactionCtx, {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Jumlah Transaksi',
                                data: data.data,
                                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                                borderColor: '#36A2EB',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return context.parsed.y + ' transaksi';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => {
                    console.error('Error loading daily transactions chart:', error);
                });
        @endif
    </script>
@endpush
