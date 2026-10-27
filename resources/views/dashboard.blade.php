@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Koperasi')

@section('content')

    <div class="row">

        <div class="col-lg-4 col-12">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Anggota</h3>
                    <p>Data Anggota Koperasi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('anggotas.index') }}"
                    class="small-box-footer">
                    Lihat Data <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-12">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Simpanan</h3>
                    <p>Transaksi Simpanan Anggota</p>
                </div>
                <div class="icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <a href="{{ route('simpanans.index') }}"
                    class="small-box-footer">
                    Lihat Simpanan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        @if(auth()->user()?->role === 'admin')
            <div class="col-lg-4 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>Pengguna</h3>
                        <p>Manajemen User</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <a href="{{ route('users.index') }}"
                        class="small-box-footer">
                        Kelola User <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        @endif

    </div>
    
    <div class="col-lg-4 col-md-6">
    <div class="small-box bg-danger">
        <div class="inner">
            <h3>Transaksi</h3>
            <p>Riwayat Transaksi Koperasi</p>
        </div>
        <div class="icon">
            <i class="fas fa-exchange-alt"></i>
        </div>
        <a href="{{ route('transaksi.index') }}" class="small-box-footer">
            Lihat Transaksi <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Selamat Datang</h3>
        </div>
        <div class="card-body">
            Selamat datang, <strong>{{ auth()->user()->name }}</strong>,
            di aplikasi KoperasiKu.
        </div>
    </div>

@endsection