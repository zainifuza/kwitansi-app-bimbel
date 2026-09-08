<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $kwitansi->nomor_kwitansi }}</title>
    <style>
        @page { size: A5 portrait; margin: 10mm; }
        body {
            color: #1e293b;
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            position: relative;
        }

        /* Watermark Background */
        .watermark {
            position: fixed;
            top: 40%;
            left: 0;
            width: 100%;
            color: #d30a0a;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            opacity: 0.08;
            text-align: center;
            transform: rotate(-25deg);
            z-index: -1000;
        }

        /* Header Table */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 2px solid #d30a0a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        .header-table td { vertical-align: middle; }
        .logo-img { height: 50px; width: auto; }
        .company-name { font-size: 12px; font-weight: bold; text-transform: uppercase; color: #0f172a; }
        .company-detail { color: #64748b; font-size: 8.5px; line-height: 1.3; }
        .title-text { font-size: 18px; font-weight: bold; letter-spacing: 1.5px; color: #d30a0a; }
        .title-number { color: #64748b; font-size: 9.5px; margin-top: 2px; }

        /* Receipt Data Table */
        .receipt-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .receipt-table td { padding: 4px 0; vertical-align: top; }
        .label { color: #64748b; width: 140px; }
        .colon { width: 10px; }
        .value { color: #0f172a; }
        .terbilang-box {
            font-style: italic;
            background-color: #f8fafc;
            padding: 3px 6px;
            border-radius: 4px;
            display: inline-block;
        }

        /* Bottom Section Layout Table */
        .bottom-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .bottom-table td { vertical-align: bottom; }

        /* Amount Box */
        .amount-box {
            border: 2px solid #d30a0a;
            padding: 6px 12px;
            text-align: right;
            width: 160px;
            border-radius: 4px;
            margin-bottom: 10px;
            float: right;
        }
        .amount-label { color: #64748b; font-size: 8.5px; text-transform: uppercase; }
        .amount-value { font-size: 14px; font-weight: bold; color: #0f172a; margin-top: 2px; }
        .paid-logo { height: 95px; width: auto; display: block; }
        .payment-status { display: inline-block; border: 2px solid #64748b; color: #64748b; padding: 6px 8px; font-size: 9px; font-weight: bold; letter-spacing: 0.5px; }
        .payment-status.installment { border-color: #d97706; color: #d97706; }

        /* Signature Area */
        .signature-wrapper {
            margin-top: 25px;
            width: 170px;
            text-align: center;
            float: right;
        }
        .signature-date { font-size: 9px; color: #64748b; margin-bottom: 2px; }
        .signature-title { font-size: 9.5px; color: #334155; margin-bottom: 4px; }

        /* Container untuk penumpukan Stempel & TTD */
        .stamp-signature-container {
            position: relative;
            height: 65px;
            width: 100%;
        }
        .stamp-img {
            position: absolute;
            left: -10px;
            top: -5px;
            height: 60px;
            width: auto;
            opacity: 0.75;
            z-index: 1;
        }
        .signature-img {
            position: absolute;
            left: 50%;
            top: 5px;
            transform: translateX(-50%);
            height: 75px;
            width: auto;
            z-index: 2;
        }

        .signature-line {
            border-top: 1px solid #1e293b;
            padding-top: 4px;
            font-weight: bold;
            font-size: 9.5px;
            color: #0f172a;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <div class="watermark">{{ config('company.name') }}</div>

    {{-- HEADER (Gunakan Table menggantikan Flexbox) --}}
    <table class="header-table">
        <tr>
            <td style="width: 60px;">
                @if($logoData)
                    <img class="logo-img" src="{{ $logoData }}" alt="Logo">
                @endif
            </td>
            <td>
                <div class="company-name">{{ config('company.name') }}</div>
                <div class="company-detail">{{ config('company.address') }}</div>
                <div class="company-detail">Telp: {{ config('company.phone') }} | Email: {{ config('company.email') }}</div>
            </td>
            <td style="text-align: right; width: 140px;">
                <div class="title-text">KWITANSI</div>
                <div class="title-number">No: {{ $kwitansi->nomor_kwitansi }}</div>
            </td>
        </tr>
    </table>

    {{-- ISI KWITANSI --}}
    <table class="receipt-table">
        <tr>
            <td class="label">Sudah terima dari</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $kwitansi->nama_pembeli }}</strong></td>
        </tr>
        <tr>
            <td class="label">Paket Bimbingan Belajar</td>
            <td class="colon">:</td>
            <td class="value"><strong>{{ $kwitansi->nama_paket }}</strong></td>
        </tr>
        <tr>
            <td class="label">Untuk pembayaran</td>
            <td class="colon">:</td>
            <td class="value">{{ $kwitansi->tujuan_pembelian }}</td>
        </tr>
        <tr>
            <td class="label">Terbilang</td>
            <td class="colon">:</td>
            <td class="value"><span class="terbilang-box">{{ $terbilang }} Rupiah</span></td>
        </tr>
        <tr>
            <td class="label">Tanggal</td>
            <td class="colon">:</td>
            <td class="value">{{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    {{-- FOOTER: JUMLAH HARGA & TANDA TANGAN --}}
    <table class="bottom-table">
        <tr>
            {{-- Kotak Jumlah Harga --}}
            <td>
                <div>
                    @if($kwitansi->status_pembayaran === 'LUNAS' && $logoLunasData)
                        <img class="paid-logo" src="{{ $logoLunasData }}" alt="Lunas">
                    @else
                        <span class="payment-status {{ $kwitansi->status_pembayaran === 'CICILAN' ? 'installment' : '' }}">{{ $kwitansi->status_pembayaran }}</span>
                    @endif
                </div>
            </td>

            {{-- Area Tanda Tangan & Stempel --}}
            <td style="width: auto; text-align: right;">
                <div class="amount-box">
                    <div class="amount-label">Jumlah</div>
                    <div class="amount-value">Rp {{ number_format($kwitansi->harga, 0, ',', '.') }}</div>
                </div>
            </td>
        </tr>
        <tr>
            {{-- Kotak Jumlah Harga --}}
            <td style="width: 50%;">

            </td>

            {{-- Area Tanda Tangan & Stempel --}}
            <td style="width: 50%; text-align: right;">
                <div class="signature-wrapper">
                    <div class="signature-date">{{ config('company.city', 'Banda Aceh') }}, {{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</div>
                    <div class="signature-title">Penerima,</div>

                    <div class="stamp-signature-container">
                        @if($stempelData)
                            <img class="stamp-img" src="{{ $stempelData }}" alt="Stempel">
                        @endif
                        @if($signatureData)
                            <img class="signature-img" src="{{ $signatureData }}" alt="Signature">
                        @endif
                    </div>

                    <div class="signature-line">{{ $kwitansi->nama_penerima ?: config('company.penerima') }}</div>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
