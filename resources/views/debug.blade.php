@extends('layouts.parking')

@section('title', 'Debug Info')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">🔍 Debug Information</h5>
                    </div>
                    <div class="card-body">
                        @auth
                            <div class="alert alert-success">
                                <h6>✅ User Authenticated</h6>
                                <ul class="mb-0">
                                    <li><strong>Name:</strong> {{ Auth::user()->name }}</li>
                                    <li><strong>Email:</strong> {{ Auth::user()->email }}</li>
                                    <li><strong>Role:</strong> {{ Auth::user()->role ?? 'NULL' }}</li>
                                    <li><strong>ID:</strong> {{ Auth::user()->id }}</li>
                                </ul>
                            </div>

                            <div class="alert alert-info">
                                <h6>🔐 Access Permissions</h6>
                                <ul class="mb-0">
                                    <li><strong>Can access parking routes:</strong>
                                        @if (in_array(Auth::user()->role, ['admin', 'petugas']))
                                            <span class="badge bg-success">✅ YES</span>
                                        @else
                                            <span class="badge bg-danger">❌ NO</span>
                                        @endif
                                    </li>
                                    <li><strong>Is Admin:</strong>
                                        @if (Auth::user()->role === 'admin')
                                            <span class="badge bg-success">✅ YES</span>
                                        @else
                                            <span class="badge bg-secondary">❌ NO</span>
                                        @endif
                                    </li>
                                    <li><strong>Is Petugas:</strong>
                                        @if (Auth::user()->role === 'petugas')
                                            <span class="badge bg-success">✅ YES</span>
                                        @else
                                            <span class="badge bg-secondary">❌ NO</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <h6>🔗 Available Routes</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Always Available:</strong>
                                        <ul>
                                            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                            <li><a href="{{ route('profile.edit') }}">Profile</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Admin/Petugas Only:</strong>
                                        <ul>
                                            <li><a href="{{ route('parking.index') }}">Parking List</a></li>
                                            <li><a href="{{ route('parking.create') }}">Create Parking</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-dark">
                                <h6>🧪 Test Access</h6>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('parking.index') }}" class="btn btn-primary btn-sm">Test Parking Index</a>
                                    <a href="{{ route('parking.create') }}" class="btn btn-success btn-sm">Test Create
                                        Parking</a>
                                    <a href="{{ route('dashboard') }}" class="btn btn-info btn-sm">Test Dashboard</a>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <h6>❌ User Not Authenticated</h6>
                                <p class="mb-0">Please <a href="{{ route('login') }}">login</a> to continue.</p>
                            </div>
                        @endauth

                        <div class="mt-3">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
