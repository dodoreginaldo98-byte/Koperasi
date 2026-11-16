@extends('layouts.app')

@section('title', 'Laporan Pinjaman')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h3>Laporan Pinjaman</h3>
            <p class="text-muted">
                Rekap pencairan dan pembayaran pinjaman koperasi.
            </p>
        </div>

        <a href="{{ route('laporan.pinjaman.pdf', request()->query()) }}"
           class="btn btn-danger"
           target="_blank">
            <i class="fas fa-file-pdf"></i> Cetak PDF
        </a>
    </div>

    {{-- Filter --}}
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form method="GET" class="row">
                <div class="col-md-4">
                    <label>Tanggal Mulai Pencairan</label>
                    <input type="date"
                           name="tanggal_mulai"
                           class="form-control"
                           value="{{ request('tanggal_mulai') }}">
                </div>

                <div class="col-md-4">
                    <label>Tanggal Akhir Pencairan</label>
                    <input type="date"
                           name="tanggal_akhir"
                           class="form-control"
                           value="{{ request('tanggal_akhir') }}">
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary mr-2">
                        <i class="fas fa-search"></i> Tampilkan
                    </button>

                    <a href="{{ route('laporan.pinjaman') }}"
                       class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Ringkasan --}}
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h4>
                        Rp {{ number_format($rekap['total_pinjaman'], 0, ',', '.') }}
                    </h4>
                    <p>Total Pencairan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h4>
                        Rp {{ number_format($rekap['total_dibayar'], 0, ',', '.') }}
                    </h4>
                    <p>Total Pembayaran Diterima</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h4>
                        Rp {{ number_format($rekap['sisa_piutang'], 0, ',', '.') }}
                    </h4>
                    <p>Sisa Piutang</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Komposisi tagihan --}}
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Komposisi Pinjaman</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Total Pokok Pinjaman</th>
                    <td>
                        Rp {{ number_format($rekap['total_pokok'], 2, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Total Bunga Terjadwal</th>
                    <td>
                        Rp {{ number_format($rekap['total_bunga'], 2, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <th>Total Tagihan Terjadwal</th>
                    <td>
                        Rp {{ number_format(
                            $rekap['total_pokok'] + $rekap['total_bunga'],
                            2,
                            ',',
                            '.'
                        ) }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Daftar pinjaman --}}
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Daftar Pinjaman Dicairkan</h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Tanggal Cair</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Total Tagihan</th>
                            <th>Sudah Dibayar</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pinjamans as $index => $pinjaman)
                            @php
                                $tagihan = $pinjaman->angsurans->sum('total_tagihan');
                                $dibayar = $pinjaman->angsurans->sum('total_dibayar');
                            @endphp

                            <tr>
                                <td>{{ $pinjamans->firstItem() + $index }}</td>
                                <td>{{ $pinjaman->anggota->nama }}</td>
                                <td>
                                    {{ $pinjaman->disbursed_at?->format('d-m-Y') }}
                                </td>
                                <td>
                                    Rp {{ number_format($pinjaman->jumlah_disetujui, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($tagihan, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($dibayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($tagihan - $dibayar, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($pinjaman->status === 'lunas')
                                        <span class="badge badge-success">Lunas</span>
                                    @else
                                        <span class="badge badge-primary">Dicairkan</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('laporan.kartu', $pinjaman->id) }}"
                                       class="btn btn-danger btn-sm"
                                       target="_blank"
                                       title="Cetak Kartu Angsuran">
                                        <i class="fas fa-file-pdf"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    Tidak ada data pinjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $pinjamans->links() }}
        </div>
    </div>

    {{-- Daftar tunggakan --}}
    <div class="card card-outline card-danger">
        <div class="card-header">
            <h3 class="card-title">
                Daftar Angsuran Menunggak
            </h3>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>Angsuran Ke</th>
                            <th>Jatuh Tempo</th>
                            <th>Total Tagihan</th>
                            <th>Sudah Dibayar</th>
                            <th>Sisa Tunggakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tunggakan as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->pinjaman->anggota->nama }}</td>
                                <td>{{ $item->angsuran_ke }}</td>
                                <td>
                                    {{ $item->jatuh_tempo->format('d-m-Y') }}
                                </td>
                                <td>
                                    Rp {{ number_format($item->total_tagihan, 0, ',', '.') }}
                                </td>
                                <td>
                                    Rp {{ number_format($item->total_dibayar, 0, ',', '.') }}
                                </td>
                                <td class="text-danger">
                                    <strong>
                                        Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                    </strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Tidak ada tunggakan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection