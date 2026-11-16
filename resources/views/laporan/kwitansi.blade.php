<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kwitansi Pembayaran</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            border: 2px solid #333;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 3px;
        }

        .subtitle {
            text-align: center;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 9px 5px;
            vertical-align: top;
        }

        .amount {
            border: 1px solid #333;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
        }

        .signature {
            text-align: center;
            padding-top: 35px;
        }

        .footer {
            font-size: 9px;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">

        <h2>KOPERASI SIMPAN PINJAM</h2>

        <p class="subtitle">
            BUKTI PEMBAYARAN ANGSURAN
        </p>

        <hr>

        <table>
            <tr>
                <td width="30%">Nomor Kwitansi</td>
                <td>
                    : {{ $pembayaran->kode_pembayaran }}
                </td>
            </tr>
            <tr>
                <td>Tanggal Pembayaran</td>
                <td>
                    : {{ $pembayaran->tanggal_bayar->format('d-m-Y') }}
                </td>
            </tr>
            <tr>
                <td>Nama Anggota</td>
                <td>
                    : {{ $pembayaran->angsuran->pinjaman->anggota->nama }}
                </td>
            </tr>
            <tr>
                <td>Nomor Pinjaman</td>
                <td>
                    : {{ $pembayaran->angsuran->pinjaman_id }}
                </td>
            </tr>
            <tr>
                <td>Angsuran Ke</td>
                <td>
                    : {{ $pembayaran->angsuran->angsuran_ke }}
                </td>
            </tr>
            <tr>
                <td>Jumlah Pembayaran</td>
                <td>
                    <div class="amount">
                        Rp {{ number_format($pembayaran->jumlah_bayar, 2, ',', '.') }}
                    </div>
                </td>
            </tr>
            <tr>
                <td>Alokasi Pokok</td>
                <td>
                    : Rp {{ number_format($pembayaran->pokok_dibayar, 2, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Alokasi Bunga</td>
                <td>
                    : Rp {{ number_format($pembayaran->bunga_dibayar, 2, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td>Keterangan</td>
                <td>
                    : {{ $pembayaran->keterangan ?? '-' }}
                </td>
            </tr>
        </table>

        <table>
            <tr>
                <td width="60%"></td>
                <td class="signature">
                    Petugas Koperasi
                    <br><br><br><br>
                    <strong>
                        {{ $pembayaran->petugas->name ?? 'Petugas' }}
                    </strong>
                </td>
            </tr>
        </table>

        <div class="footer">
            Simpan bukti pembayaran ini sebagai arsip transaksi.
        </div>

    </div>

</body>
</html>