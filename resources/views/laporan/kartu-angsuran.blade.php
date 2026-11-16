<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kartu Angsuran Pinjaman</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
            color: #333;
        }

        h2,
        h3 {
            text-align: center;
            margin: 4px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #777;
            padding: 7px;
        }

        th {
            background: #e8eef5;
        }

        .no-border td {
            border: none;
            padding: 4px;
        }

        .text-right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .summary {
            margin-top: 15px;
        }

        .signature {
            margin-top: 40px;
            width: 100%;
        }
    </style>
</head>
<body>

    <h2>KOPERASI SIMPAN PINJAM</h2>
    <h3>KARTU ANGSURAN PINJAMAN</h3>

    <p class="subtitle">
        Dokumen administrasi pembayaran angsuran anggota
    </p>

    <table class="no-border">
        <tr>
            <td width="25%">Nama Anggota</td>
            <td width="35%">: {{ $pinjaman->anggota->nama }}</td>
            <td width="20%">Nomor Pinjaman</td>
            <td>: {{ $pinjaman->id }}</td>
        </tr>
        <tr>
            <td>Jumlah Pinjaman</td>
            <td>: Rp {{ number_format($pinjaman->jumlah_disetujui, 2, ',', '.') }}</td>
            <td>Bunga</td>
            <td>: {{ $pinjaman->bunga_persen }}% per tahun</td>
        </tr>
        <tr>
            <td>Tenor</td>
            <td>: {{ $pinjaman->tenor_bulan }} Bulan</td>
            <td>Tanggal Pencairan</td>
            <td>: {{ $pinjaman->disbursed_at?->format('d-m-Y') ?? '-' }}</td>
        </tr>
    </table>

    <h4>Jadwal Pembayaran Angsuran</h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jatuh Tempo</th>
                <th>Pokok</th>
                <th>Bunga</th>
                <th>Total Tagihan</th>
                <th>Dibayar</th>
                <th>Sisa</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pinjaman->angsurans as $angsuran)
                <tr>
                    <td class="center">{{ $angsuran->angsuran_ke }}</td>
                    <td class="center">
                        {{ $angsuran->jatuh_tempo->format('d-m-Y') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($angsuran->pokok, 2, ',', '.') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($angsuran->bunga, 2, ',', '.') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($angsuran->total_tagihan, 2, ',', '.') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($angsuran->total_dibayar, 2, ',', '.') }}
                    </td>
                    <td class="text-right">
                        {{ number_format($angsuran->sisa_tagihan, 2, ',', '.') }}
                    </td>
                    <td class="center">
                        {{ strtoupper($angsuran->status) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="summary">
        <tr>
            <th>Total Tagihan</th>
            <th>Total Dibayar</th>
            <th>Sisa Pinjaman</th>
        </tr>
        <tr>
            <td class="text-right">
                Rp {{ number_format($pinjaman->angsurans->sum('total_tagihan'), 2, ',', '.') }}
            </td>
            <td class="text-right">
                Rp {{ number_format($pinjaman->angsurans->sum('total_dibayar'), 2, ',', '.') }}
            </td>
            <td class="text-right">
                Rp {{ number_format(
                    $pinjaman->angsurans->sum('total_tagihan') - $pinjaman->angsurans->sum('total_dibayar'),
                    2,
                    ',',
                    '.'
                ) }}
            </td>
        </tr>
    </table>

    <table class="signature no-border">
        <tr>
            <td width="65%"></td>
            <td class="center">
                Petugas Koperasi
                <br><br><br><br>
                (................................)
            </td>
        </tr>
    </table>

</body>
</html>