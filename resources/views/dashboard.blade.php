@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4 py-4">
    <h3 class="mb-1">Dashboard</h3>
    <p class="text-muted">Selamat datang, {{ auth()->user()->name }}.</p>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Total User</div>
                    <div class="stat-number">{{ \App\Models\User::count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">User Aktif</div>
                    <div class="stat-number">{{ \App\Models\User::where('is_active', true)->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Anggota</div>
                    <div class="stat-number">-</div>
                    <small class="text-muted">Modul belum dibuat</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-muted">Simpanan</div>
                    <div class="stat-number">-</div>
                    <small class="text-muted">Modul belum dibuat</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection