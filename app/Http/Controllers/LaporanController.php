<?php

namespace App\Http\Controllers;

use App\Models\Angsuran;
use App\Models\PembayaranAngsuran;
use App\Models\Pinjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Laporan pinjaman dan tunggakan.
     */
    public function index(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $query = Pinjaman::with('anggota')
            ->whereIn('status', ['dicairkan', 'lunas']);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate(
                'disbursed_at',
                '>=',
                $request->tanggal_mulai
            );
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate(
                'disbursed_at',
                '<=',
                $request->tanggal_akhir
            );
        }

        $pinjamans = $query->latest('disbursed_at')
            ->paginate(15)
            ->withQueryString();

        // Rekap berdasarkan periode pencairan
        $rekapQuery = clone $query;
        $pinjamanIds = $rekapQuery->pluck('id');

        $rekap = [
            'total_pinjaman' => Pinjaman::whereIn('id', $pinjamanIds)
                ->sum('jumlah_disetujui'),

            'total_pokok' => Angsuran::whereIn('pinjaman_id', $pinjamanIds)
                ->sum('pokok'),

            'total_bunga' => Angsuran::whereIn('pinjaman_id', $pinjamanIds)
                ->sum('bunga'),

            'total_dibayar' => PembayaranAngsuran::whereHas(
                'angsuran',
                fn ($q) => $q->whereIn('pinjaman_id', $pinjamanIds)
            )->sum('jumlah_bayar'),

            'sisa_piutang' => Angsuran::whereIn('pinjaman_id', $pinjamanIds)
                ->selectRaw(
                    'COALESCE(SUM(total_tagihan - total_dibayar), 0) as total'
                )
                ->value('total'),
        ];

        $tunggakan = Angsuran::with('pinjaman.anggota')
            ->whereIn('pinjaman_id', $pinjamanIds)
            ->whereDate('jatuh_tempo', '<', today())
            ->where('status', '!=', 'lunas')
            ->orderBy('jatuh_tempo')
            ->get();

        return view('laporan.pinjaman', compact(
            'pinjamans',
            'rekap',
            'tunggakan'
        ));
    }

    /**
     * Cetak kartu angsuran PDF.
     */
    public function kartuAngsuran(Pinjaman $pinjaman)
    {
        $pinjaman->load([
            'anggota',
            'pengurus',
            'angsurans' => function ($query) {
                $query->orderBy('angsuran_ke')
                    ->with('pembayarans');
            },
        ]);

        abort_unless(
            in_array($pinjaman->status, ['dicairkan', 'lunas']),
            404,
            'Kartu angsuran belum tersedia.'
        );

        $pdf = Pdf::loadView(
            'laporan.kartu-angsuran',
            compact('pinjaman')
        )->setPaper('a4', 'portrait');

        return $pdf->stream(
            'kartu-angsuran-' . $pinjaman->id . '.pdf'
        );
    }

    /**
     * Cetak kwitansi pembayaran.
     */
    public function kwitansi(PembayaranAngsuran $pembayaran)
    {
        $pembayaran->load([
            'angsuran.pinjaman.anggota',
            'petugas',
        ]);

        $pdf = Pdf::loadView(
            'laporan.kwitansi',
            compact('pembayaran')
        )->setPaper('a5', 'landscape');

        return $pdf->stream(
            'kwitansi-' . $pembayaran->kode_pembayaran . '.pdf'
        );
    }

    /**
     * Cetak laporan PDF.
     */
    public function cetakLaporan(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
        ]);

        $query = Pinjaman::with(['anggota', 'angsurans'])
            ->whereIn('status', ['dicairkan', 'lunas']);

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('disbursed_at', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('disbursed_at', '<=', $request->tanggal_akhir);
        }

        $pinjamans = $query->orderBy('disbursed_at')->get();

        $rekap = [
            'total_pinjaman' => $pinjamans->sum('jumlah_disetujui'),

            'total_pokok' => $pinjamans->sum(
                fn ($p) => $p->angsurans->sum('pokok')
            ),

            'total_bunga' => $pinjamans->sum(
                fn ($p) => $p->angsurans->sum('bunga')
            ),

            'total_dibayar' => $pinjamans->sum(
                fn ($p) => $p->angsurans->sum('total_dibayar')
            ),

            'sisa_piutang' => $pinjamans->sum(
                fn ($p) => $p->angsurans->sum(
                    fn ($a) => (float) $a->total_tagihan
                        - (float) $a->total_dibayar
                )
            ),
        ];

        $periode = [
            'mulai' => $request->tanggal_mulai,
            'akhir' => $request->tanggal_akhir,
        ];

        $pdf = Pdf::loadView(
            'laporan.cetak-pinjaman',
            compact('pinjamans', 'rekap', 'periode')
        )->setPaper('a4', 'landscape');

        return $pdf->stream('laporan-pinjaman.pdf');
    }
}