@extends('layouts.app')

@section('title', 'Edit Simpanan')

@section('content')
    <div class="container py-4">
        <h3 class="mb-1">Edit Simpanan</h3>
        <p class="text-muted">
            Kode transaksi: {{ $simpanan->kode_transaksi }}
        </p>

        <div class="alert alert-warning">
            Hanya transaksi berstatus menunggu yang dapat diedit.
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('simpanan.update', $simpanan) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    @include('simpanan._form')
                </form>
            </div>
        </div>
    </div>
@endsection