@extends('layouts.app')

@section('title', 'Detail Anggota')

@section('content')
<div class="container-fluid py-4">  
    <div class="d-flex justify-content-between align-items-center mb-4">  
        <h3>Detail Anggota</h3>  
        <div class="d-flex gap-2">  
            <a href="{{ route('anggota.edit', $anggota) }}" class="btn btn-warning">Edit</a>  
            <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">Kembali</a>  
        </div>  
    </div>  

    <div class="card border-0 shadow-sm">  
        <div class="card-header bg-primary text-white">  
            Informasi Anggota Koperasi  
        </div>  
        <div class="card-body">  
            <div class="table-responsive">  
                <table class="table table-bordered">  
                    <tr>  
                        <th style="width: 220px;">Nomor Anggota</th>  
                        <td>{{ $anggota->no_anggota }}</td>  
                    </tr>  
                    <tr>  
                        <th>NIK</th>  
                        <td>{{ $anggota->nik }}</td>  
                    </tr>  
                    <tr>  
                        <th>Nama Lengkap</th>  
                        <td>{{ $anggota->nama }}</td>  
                    </tr>  
                    <tr>  
                        <th>Jenis Kelamin</th>  
                        <td>{{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>  
                    </tr>  
                    <tr>  
                        <th>Tempat, Tanggal Lahir</th>  
                        <td>  
                            {{ $anggota->tempat_lahir ?? '-' }},  
                            {{ $anggota->tanggal_lahir ? $anggota->tanggal_lahir->format('d-m-Y') : '-' }}  
                        </td>  
                    </tr>  
                    <tr>  
                        <th>Alamat</th>  
                        <td>{{ $anggota->alamat }}</td>  
                    </tr>  
                    <tr>  
                        <th>Nomor HP</th>  
                        <td>{{ $anggota->no_hp }}</td>  
                    </tr>  
                    <tr>  
                        <th>Email</th>  
                        <td>{{ $anggota->email ?? '-' }}</td>  
                    </tr>  
                    <tr>  
                        <th>Tanggal Bergabung</th>  
                        <td>{{ $anggota->tanggal_bergabung->format('d-m-Y') }}</td>  
                    </tr>  
                    <tr>  
                        <th>Status</th>  
                        <td>{{ ucfirst($anggota->status) }}</td>  
                    </tr>  
                </table>  
            </div>  
        </div>  
    </div>  
</div>  
@endsection