@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3>Edit Anggota</h3>
                <p class="text-muted mb-0">
                    Perbarui data {{ $anggota->nama }}.
                </p>
            </div>
            <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">
                Kembali
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <strong>Formulir Perubahan Data</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('anggota.update', $anggota) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('anggota.form')
                </form>
            </div>
        </div>

    </div>
@endsection