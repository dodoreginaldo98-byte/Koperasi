@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <h3 class="mb-1">Data Anggota</h3>
                <p class="text-muted mb-0">
                    Kelola data anggota koperasi simpan pinjam.
                </p>
            </div>
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                + Tambah Anggota
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
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Data belum dapat disimpan.</strong>
                Periksa kembali kolom yang ditandai pada formulir.
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <form method="GET" action="{{ route('anggota.index') }}"
                    class="row g-2 mb-3">
                    <div class="col-md-6">
                        <input type="text" name="search"
                            class="form-control"
                            placeholder="Cari nomor anggota, NIK, nama, atau HP..."
                            value="{{ $keyword }}">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>
                        <a href="{{ route('anggota.index') }}"
                            class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>No.</th>
                                <th>No. Anggota</th>
                                <th>NIK</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>No. HP</th>
                                <th>Tanggal Bergabung</th>
                                <th>Status</th>
                                <th style="min-width: 190px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($anggota as $item)
                                <tr>
                                    <td>
                                        {{ $anggota->firstItem() + $loop->index }}
                                    </td>
                                    <td>{{ $item->no_anggota }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>
                                        {{ $item->jenis_kelamin === 'L'
                                            ? 'Laki-laki' : 'Perempuan' }}
                                    </td>
                                    <td>{{ $item->no_hp }}</td>
                                    <td>
                                        {{ $item->tanggal_bergabung->format('d-m-Y') }}
                                    </td>
                                    <td>
                                        @if($item->status === 'aktif')
                                            <span class="badge text-bg-success">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="badge text-bg-secondary">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            <a href="{{ route('anggota.show', $item) }}"
                                                class="btn btn-sm btn-info text-white">
                                                Detail
                                            </a>

                                            <a href="{{ route('anggota.edit', $item) }}"
                                                class="btn btn-sm btn-warning">
                                                Edit
                                            </a>

                                            <form
                                                action="{{ route('anggota.destroy', $item) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        Data anggota belum tersedia.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
                    <small class="text-muted">
                        Menampilkan {{ $anggota->firstItem() ?? 0 }}–{{ $anggota->lastItem() ?? 0 }}
                        dari {{ $anggota->total() }} anggota
                    </small>
                    {{ $anggota->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection