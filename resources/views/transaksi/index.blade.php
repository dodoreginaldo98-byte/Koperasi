@extends('layouts.app')

@section('title', 'Transaksi')
@section('page-title', 'Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <form method="GET" class="form-inline">
            <select name="jenis" class="form-control form-control-sm mr-2">
                <option value="">Semua Jenis</option>
                @foreach(['pokok','wajib','sukarela'] as $j)
                    <option value="{{ $j }}" @selected(request('jenis') === $j)>{{ ucfirst($j) }}</option>
                @endforeach
            </select>

            <select name="status" class="form-control form-control-sm mr-2">
                <option value="">Semua Status</option>
                @foreach(['menunggu','terverifikasi','ditolak','dibatalkan'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>

            <input type="date" name="dari" value="{{ request('dari') }}" class="form-control form-control-sm mr-2">
            <input type="date" name="sampai" value="{{ request('sampai') }}" class="form-control form-control-sm mr-2">

            <button class="btn btn-primary btn-sm mr-1">Filter</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary btn-sm">Reset</a>
        </form>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Tanggal</th>
                    <th>Anggota</th>
                    <th>Jenis</th>
                    <th class="text-right">Nominal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                    <tr>
                        <td>{{ $t->kode_transaksi }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                        <td>{{ $t->anggota->nama ?? '-' }}</td>
                        <td>{{ ucfirst($t->jenis) }}</td>
                        <td class="text-right">Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                        <td>
                            @php
                                $warna = ['menunggu'=>'warning','terverifikasi'=>'success','ditolak'=>'danger','dibatalkan'=>'secondary'][$t->status] ?? 'light';
                            @endphp
                            <span class="badge badge-{{ $warna }}">{{ ucfirst($t->status) }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted py-4">Belum ada transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
        <strong>Total terverifikasi: Rp {{ number_format($totalTerverifikasi, 0, ',', '.') }}</strong>
        {{ $transaksis->links() }}
    </div>
</div>
@endsection