<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pinjaman Anggota</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 9px;
        }

        h2,
        h3 {
            text-align: center;
            margin: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #777;
            padding: 6px;
        }

        th {
            background: #e8eef5;
        }

        .right {
            text-align: right;
        }
    </style>
</head>
<body>

    <h2>KOPERASI SIMPAN PINJAM</h2>
    <h3>LAPORAN PINJAMAN ANGGOTA</h3>

    <p align="center">
        Periode:
        {{ $periode['mulai'] ?? 'Awal' }}
        s/d
        {{ $periode['akhir'] ?? 'Sekarang' }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Total Pencairan</th>
                <th>Pokok Terjadwal</th>
                <th>Bunga Terjadwal</th>
                <th>Pembayaran Diterima</th>
                <th>Sisa Piutang</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="right">
                    Rp {{ number_format($rekap['total_pinjaman'], 2, ',', '.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($rekap['total_pokok'], 2, ',', '.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($rekap['total_bunga'], 2, ',', '.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($rekap['total_dibayar'], 2, ',', '.') }}
                </td>
                <td class="right">
                    Rp {{ number_format($rekap['sisa_piutang'], 2, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    <h3>Rincian Pinjaman</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Anggota</th>
                <th>Tanggal Pencairan</th>
                <th>Pinjaman</th>
                <th>Tagihan</th>
                <th>Dibayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pinjamans as $index => $pinjaman)
                @php
                    $tagihan = $pinjaman->angsurans->sum('total_tagihan');
                    $dibayar = $pinjaman->angsurans->sum('total_dibayar');
                @endphp

                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pinjaman->anggota->nama }}</td>
                    <td>
                        {{ $pinjaman->disbursed_at?->format('d-m-Y') }}
                    </td>
                    <td class="right">
                        {{ number_format($pinjaman->jumlah_disetujui, 2, ',', '.') }}
                    </td>
                    <td class="right">
                        {{ number_format($tagihan, 2, ',', '.') }}
                    </td>
                    <td class="right">
                        {{ number_format($dibayar, 2, ',', '.') }}
                    </td>
                    <td class="right">
                        {{ number_format($tagihan - $dibayar, 2, ',', '.') }}
                    </td>
                    <td>{{ strtoupper($pinjaman->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    <table>
        <tr>
            <td style="border: none; text-align: right;">
                Petugas Koperasi
                <br><br><br><br>
                (................................)
            </td>
        </tr>
    </table>

</body>
</html>