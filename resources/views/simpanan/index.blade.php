@extends('layouts.app')

@section('title', 'Data Simpanan')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <div>
                <h3 class="mb-1">Data Simpanan</h3>
                <p class="text-muted mb-0">Transaksi simpanan anggota koperasi.</p>
            </div>
            <a href="{{ route('simpanans.create') }}" class="btn btn-primary">
                + Tambah Simpanan
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row g-3 mb-4">
            @foreach([
                ['label' => 'Simpanan Pokok', 'value' => $rekap->total_pokok],
                ['label' => 'Simpanan Wajib', 'value' => $rekap->total_wajib],
                ['label' => 'Simpanan Sukarela', 'value' => $rekap->total_sukarela],
                ['label' => 'Total Terverifikasi', 'value' => $rekap->total_simpanan],
            ] as $card)
                <div class="col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <div class="text-muted small">{{ $card['label'] }}</div>
                            <div class="fs-5 fw-bold mt-2">
                                Rp {{ number_format((float) $card['value'], 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <form method="GET" action="{{ route('simpanans.index') }}"
                    class="row g-2 mb-4">

                    <div class="col-lg-3 col-md-6">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari kode atau nama anggota"
                            value="{{ request('search') }}">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="jenis" class="form-select">
                            <option value="">Semua jenis</option>
                            <option value="pokok" @selected(request('jenis') === 'pokok')>Pokok</option>
                            <option value="wajib" @selected(request('jenis') === 'wajib')>Wajib</option>
                            <option value="sukarela" @selected(request('jenis') === 'sukarela')>Sukarela</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="status" class="form-select">
                            <option value="">Semua status</option>
                            @foreach(['menunggu', 'terverifikasi', 'ditolak', 'dibatalkan'] as $status)
                                <option value="{{ $status }}"
                                    @selected(request('status') === $status)>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <input type="date" name="dari" class="form-control"
                            aria-label="Tanggal awal" value="{{ request('dari') }}">
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <input type="date" name="sampai" class="form-control"
                            aria-label="Tanggal akhir" value="{{ request('sampai') }}">
                    </div>

                    <div class="col-lg-1 d-grid">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>

                    <div class="col-12">
                        <a href="{{ route('simpanans.index') }}"
                            class="btn btn-sm btn-outline-secondary">Reset filter</a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Anggota</th>
                                <th>Jenis</th>
                                <th>Nominal</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th style="min-width: 230px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($simpanan as $item)
                                <tr>
                                    <td>{{ $simpanan->firstItem() + $loop->index }}</td>
                                    <td>{{ $item->kode_transaksi }}</td>
                                    <td>
                                        {{ $item->anggota->nama }}<br>
                                        <small class="text-muted">
                                            {{ $item->anggota->no_anggota }}
                                        </small>
                                    </td>
                                    <td>{{ ucfirst($item->jenis) }}</td>
                                    <td class="text-nowrap">
                                        Rp {{ number_format((float) $item->nominal, 0, ',', '.') }}
                                    </td>
                                    <td>{{ $item->tanggal_transaksi->format('d-m-Y') }}</td>
                                    <td>
                                        @php
                                            $badge = [
                                                'menunggu' => 'warning',
                                                'terverifikasi' => 'success',
                                                'ditolak' => 'danger',
                                                'dibatalkan' => 'secondary',
                                            ][$item->status];
                                        @endphp
                                        <span class="badge text-bg-{{ $badge }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('simpanans.show', $item) }}"
                                                class="btn btn-sm btn-info text-white">
                                                Detail
                                            </a>

                                            @if($item->status === 'menunggu')
                                                <a href="{{ route('simpanans.edit', $item) }}"
                                                    class="btn btn-sm btn-warning">Edit</a>

                                                <form action="{{ route('simpanans.destroy', $item) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Batalkan transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        Batalkan
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        Belum ada transaksi simpanan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <small class="text-muted">
                        Total {{ $simpanan->total() }} transaksi
                    </small>
                    {{ $simpanan->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection