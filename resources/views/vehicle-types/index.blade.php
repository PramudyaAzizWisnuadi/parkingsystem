@extends('layouts.parking')

@section('title', 'Master Kendaraan - Sistem Parkir')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Master Kendaraan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('vehicle-types.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Jenis Kendaraan
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if ($vehicleTypes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kendaraan</th>
                                <th>Tarif Flat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vehicleTypes as $index => $vehicleType)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $vehicleType->name }}</td>
                                    <td>Rp {{ number_format($vehicleType->flat_rate, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($vehicleType->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('vehicle-types.show', $vehicleType->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <a href="{{ route('vehicle-types.edit', $vehicleType->id) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('vehicle-types.destroy', $vehicleType->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                data-id="{{ $vehicleType->id }}" data-name="{{ $vehicleType->name }}">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada jenis kendaraan</p>
                    <a href="{{ route('vehicle-types.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Jenis Kendaraan
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const vehicleName = this.getAttribute('data-name');

                    Swal.fire({
                        icon: 'warning',
                        title: 'Konfirmasi Hapus',
                        text: `Apakah Anda yakin ingin menghapus jenis kendaraan "${vehicleName}"?`,
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
            });
        });
    </script>
@endpush
