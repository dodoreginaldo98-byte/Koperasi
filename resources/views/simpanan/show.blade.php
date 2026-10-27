@extends('layouts.app')

@section('title', 'Detail Simpanan')

@section('content')
    <div class="container py-4">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h3 class="mb-1">Detail Simpanan</h3>
                <p class="text-muted mb-0">{{ $simpanan->kode_transaksi }}</p>
            </div>
            <a href="{{ route('simpanans.index') }}"
                class="btn btn-outline-secondary">Kembali</a>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                Informasi Transaksi
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <tr>
                            <th style="width: 230px">Kode Transaksi</th>
                            <td>{{ $simpanan->kode_transaksi }}</td>
                        </tr>
                        <tr>
                            <th>Anggota</th>
                            <td>
                                {{ $simpanan->anggota->nama }}
                                ({{ $simpanan->anggota->no_anggota }})
                            </td>
                        </tr>
                        <tr>
                            <th>Jenis Simpanan</th>
                            <td>{{ ucfirst($simpanan->jenis) }}</td>
                        </tr>
                        <tr>
                            <th>Nominal</th>
                            <td>
                                <strong>
                                    Rp {{ number_format((float) $simpanan->nominal, 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td>{{ $simpanan->tanggal_transaksi->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ ucfirst($simpanan->status) }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $simpanan->keterangan ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th>Dibuat oleh</th>
                            <td>{{ $simpanan->pembuat->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diverifikasi oleh</th>
                            <td>{{ $simpanan->verifikator->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Waktu verifikasi</th>
                            <td>
                                {{ $simpanan->diverifikasi_pada
                                    ? $simpanan->diverifikasi_pada->format('d-m-Y H:i')
                                    : '-' }}
                            </td>
                        </tr>
                        <tr>
                            <th>Alasan penolakan</th>
                            <td>{{ $simpanan->alasan_penolakan ?: '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        @if($simpanan->status === 'menunggu')
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <strong>Proses Verifikasi</strong>
                </div>
                <div class="card-body d-flex flex-wrap gap-3">

                    <form method="POST"
                        action="{{ route('simpanan.verifikasi', $simpanan) }}"
                        onsubmit="return confirm('Verifikasi transaksi ini?')">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            Verifikasi Simpanan
                        </button>
                    </form>

                    <form method="POST"
                        action="{{ route('simpanan.tolak', $simpanan) }}"
                        class="flex-grow-1"
                        style="min-width: 260px">
                        @csrf
                        <label class="form-label">Alasan penolakan</label>
                        <textarea name="alasan_penolakan" rows="2"
                            class="form-control mb-2"
                            minlength="5" maxlength="1000"
                            required>{{ old('alasan_penolakan') }}</textarea>
                        @error('alasan_penolakan')
                            <div class="text-danger small mb-2">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Tolak transaksi ini?')">
                            Tolak Simpanan
                        </button>
                    </form>

                </div>
            </div>
        @endif

    </div>
@endsection