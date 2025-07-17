@extends('layouts.parking')

@section('title', 'Laporan - Sistem Parkir')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Laporan Parkir</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.generate') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}"
                                        required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date" value="{{ old('end_date', date('Y-m-d')) }}"
                                        required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="mb-3">
                                    <label for="vehicle_type_id" class="form-label">Jenis Kendaraan</label>
                                    <select class="form-select @error('vehicle_type_id') is-invalid @enderror"
                                        id="vehicle_type_id" name="vehicle_type_id">
                                        <option value="">Semua Jenis</option>
                                        @foreach ($vehicleTypes as $vehicleType)
                                            <option value="{{ $vehicleType->id }}"
                                                {{ old('vehicle_type_id') == $vehicleType->id ? 'selected' : '' }}>
                                                {{ $vehicleType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <div class="mb-3">
                                    <label class="form-label d-none d-md-block">&nbsp;</label>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Tampilkan Laporan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
                        <h4>Laporan Parkir</h4>
                        <p class="text-muted">Pilih tanggal dan filter untuk menampilkan laporan parkir</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
