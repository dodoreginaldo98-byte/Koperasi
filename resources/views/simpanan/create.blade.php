@extends('layouts.app')

@section('title', 'Tambah Simpanan')

@section('content')
    <div class="container py-4">
        <h3 class="mb-1">Tambah Simpanan</h3>
        <p class="text-muted">Transaksi baru akan berstatus menunggu.</p>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('simpanans.store') }}" method="POST">
                    @csrf
                    @include('simpanan._form')
                </form>
            </div>
        </div>
    </div>
@endsection