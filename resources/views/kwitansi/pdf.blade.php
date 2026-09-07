<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $kwitansi->nomor_kwitansi }}</title>
    <style>
        @page { size: A5 portrait; margin: 12mm; }
        body { color: #1e293b; font-family: DejaVu Sans, sans-serif; font-size: 11px; margin: 0; padding: 0; position: relative; }
        .watermark { position: fixed; top: 42%; left: 0; width: 100%; color: #d30a0a; font-size: 32px; font-weight: bold; letter-spacing: 2px; opacity: 0.1; text-align: center; transform: rotate(-28deg); z-index: 0; }
        .header, .receipt-table, .amount-box, .signature-block { position: relative; z-index: 1; }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #d30404; padding-bottom: 10px; margin-bottom: 14px; }
        .logo-img { height: 55px; width: auto; }
        .company-block { margin-left: 10px; }
        .company-name { font-size: 13px; font-weight: bold; text-transform: uppercase; }
        .company-detail { color: #64748b; font-size: 9px; line-height: 1.4; }
        .title-block { text-align: right; margin-top: 10px; }
        .title-text { font-size: 20px; font-weight: bold; letter-spacing: 2px; color: #d30a0a; }
        .title-number { color: #64748b; font-size: 10px; margin-top: 2px; }
        .receipt-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .receipt-table td { padding: 4px 0; vertical-align: top; }
        .label { color: #64748b; width: 155px; }
        .colon { width: 10px; }
        .amount-box { border: 2px solid #d30a0a; padding: 8px 12px; text-align: right; display: inline-block; margin-left: auto; }
        .amount-label { color: #64748b; font-size: 9px; }
        .amount-value { font-size: 15px; font-weight: bold; }
        .signature-block { margin-top: 40px; text-align: right; }
        .signature-date { font-size: 10px; color: #64748b; }
        .stamp-img { height: auto; width: 150px; opacity: 0.8; margin-bottom: -15px; }
        .signature-line { border-top: 1px solid #1e293b; padding-top: 4px; font-weight: bold; font-size: 10px; width: 150px; margin-left: auto; }
    </style>
</head>
<body>
    <div class="watermark">{{ config('company.name') }}</div>
    <div class="header">
        <div style="display: flex; align-items: center; text-align: center;">
            @if($logoData)
                <img class="logo-img" src="{{ $logoData }}" alt="Logo">
            @endif
            <div class="company-block">
                <div class="company-name">{{ config('company.name') }}</div>
                <div class="company-detail">{{ config('company.address') }}</div>
                <div class="company-detail">Telp: {{ config('company.phone') }}, Email: {{ config('company.email') }}</div>
            </div>
        </div>
        <div class="title-block" style="align-items: center; text-align: center;">
            <div class="title-text">KWITANSI</div>
            <div class="title-number">No: {{ $kwitansi->nomor_kwitansi }}</div>
        </div>
    </div>

    <table class="receipt-table">
        <tr>
            <td class="label">Sudah terima dari</td>
            <td class="colon">:</td>
            <td><strong>{{ $kwitansi->nama_pembeli }}</strong></td>
        </tr>
        <tr>
            <td class="label">Paket Bimbingan Belajar</td>
            <td class="colon">:</td>
            <td><strong>{{ $kwitansi->nama_paket }}</strong></td>
        </tr>
        <tr>
            <td class="label">Untuk pembayaran</td>
            <td class="colon">:</td>
            <td>{{ $kwitansi->tujuan_pembelian }}</td>
        </tr>
        <tr>
            <td class="label">Terbilang</td>
            <td class="colon">:</td>
            <td><em>{{ $terbilang }}</em></td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <div class="amount-box">
        <div class="amount-label">Jumlah</div>
        <div class="amount-value">Rp {{ number_format($kwitansi->harga, 0, ',', '.') }}</div>
    </div>

    <div class="signature-block">
        <div class="signature-date">{{ config('company.name') }}, {{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</div>
        <div style="color: #64748b; font-size: 10px; margin-top: 2px;">Penerima,</div>
        @if($stempelData)
            <img class="stamp-img" src="{{ $stempelData }}" alt="Stempel">
        @endif
        <div class="signature-line">{{ $kwitansi->nama_penerima ?: config('company.penerima') }}</div>
    </div>
</body>
</html>
