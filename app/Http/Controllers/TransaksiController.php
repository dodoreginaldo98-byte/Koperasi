<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $transaksis = Simpanan::with('anggota')
            ->when($request->jenis, fn ($q, $v) => $q->where('jenis', $v))
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->when($request->dari, fn ($q, $v) => $q->whereDate('tanggal_transaksi', '>=', $v))
            ->when($request->sampai, fn ($q, $v) => $q->whereDate('tanggal_transaksi', '<=', $v))
            ->latest('tanggal_transaksi')
            ->paginate(10)
            ->withQueryString();

        $totalTerverifikasi = Simpanan::where('status', 'terverifikasi')->sum('nominal');

        return view('transaksi.index', compact('transaksis', 'totalTerverifikasi'));
    }
}