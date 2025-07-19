@extends('layouts.parking')

@section('title', 'Detail Jenis Kendaraan - Sistem Parkir')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Jenis Kendaraan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('vehicle-types.edit', $vehicleType->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('vehicle-types.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Informasi Jenis Kendaraan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Nama Kendaraan:</strong></td>
                            <td>{{ $vehicleType->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tarif Flat:</strong></td>
                            <td>Rp {{ number_format($vehicleType->flat_rate, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if ($vehicleType->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat pada:</strong></td>
                            <td>{{ $vehicleType->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diupdate pada:</strong></td>
                            <td>{{ $vehicleType->updated_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                    </table>
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
                        <a href="{{ route('vehicle-types.edit', $vehicleType->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Jenis Kendaraan
                        </a>
                        <form action="{{ route('vehicle-types.destroy', $vehicleType->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger w-100" id="deleteBtn">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.getElementById('deleteBtn');

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        icon: 'warning',
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus jenis kendaraan ini?',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        customClass: {
                            container: 'swal2-container-custom'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the form
                            this.closest('form').submit();
                        }
                    });
                });
            }
        });
    </script>
@endpush
