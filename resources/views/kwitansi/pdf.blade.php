<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $kwitansi->nomor_kwitansi }}</title>
    <style>
        @page { size: A5 landscape; margin: 10mm; }
        body { color: #1e293b; font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { border-bottom: 2px solid #1e293b; padding-bottom: 12px; margin-bottom: 18px; }
        .header-table, .receipt-table { width: 100%; border-collapse: collapse; }
        .header-table td { vertical-align: top; }
        .logo { height: 58px; width: 58px; object-fit: contain; margin-right: 12px; }
        .company { font-size: 14px; font-weight: bold; text-transform: uppercase; }
        .muted { color: #64748b; }
        .title { font-size: 20px; font-weight: bold; letter-spacing: 3px; text-align: right; }
        .number { text-align: right; color: #64748b; }
        .receipt-table { margin-bottom: 18px; }
        .receipt-table td { padding: 4px 0; vertical-align: top; }
        .label { color: #64748b; width: 165px; }
        .colon { width: 12px; }
        .amount { border: 2px solid #1e293b; padding: 8px 16px; text-align: right; width: 150px; margin-left: auto; }
        .amount-label { color: #64748b; font-size: 9px; }
        .amount-value { font-size: 16px; font-weight: bold; }
        .signature { margin-top: 18px; margin-left: auto; text-align: center; width: 190px; }
        .signature-space { height: 52px; }
        .signature-name { border-top: 1px solid #1e293b; padding-top: 4px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <table class="header-table">
            <tr>
                <td>
                    @if(file_exists(public_path(config('company.logo'))))
                        <img class="logo" src="{{ public_path(config('company.logo')) }}" alt="Logo">
                    @endif
                    <span class="company">{{ config('company.name') }}</span><br>
                    <span class="muted">{{ config('company.address') }}</span><br>
                    <span class="muted">Telp: {{ config('company.phone') }} | Email: {{ config('company.email') }}</span>
                </td>
                <td>
                    <div class="title">KWITANSI</div>
                    <div class="number">No: {{ $kwitansi->nomor_kwitansi }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="receipt-table">
        <tr><td class="label">Sudah terima dari</td><td class="colon">:</td><td><strong>{{ $kwitansi->nama_pembeli }}</strong></td></tr>
        <tr><td class="label">Paket Bimbingan Belajar</td><td class="colon">:</td><td><strong>{{ $kwitansi->nama_paket }}</strong></td></tr>
        <tr><td class="label">Untuk pembayaran</td><td class="colon">:</td><td>{{ $kwitansi->tujuan_pembelian }}</td></tr>
        <tr><td class="label">Terbilang</td><td class="colon">:</td><td><em>{{ $terbilang }}</em></td></tr>
        <tr><td class="label">Tanggal</td><td class="colon">:</td><td>{{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</td></tr>
    </table>

    <div class="amount">
        <div class="amount-label">Jumlah</div>
        <div class="amount-value">Rp {{ number_format($kwitansi->harga, 0, ',', '.') }}</div>
    </div>

    <div class="signature">
        <div>{{ config('company.address') }}, {{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</div>
        <div>Penerima,</div>
        <div class="signature-space"></div>
        <div class="signature-name">{{ $kwitansi->nama_penerima ?: config('company.penerima') }}</div>
    </div>
</body>
</html>