<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $kwitansi->nomor_kwitansi }}</title>
    <style>
        @page { size: A5 landscape; margin: 10mm; }
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
    {!! $tailwindCss !!}
</head>
<body class="text-slate-800 text-[11px]">
    <div class="border-b-2 border-slate-800 pb-3 mb-5">
        <table class="w-full border-collapse">
            <tr>
                <td class="align-top">
                    @if(file_exists(public_path(config('company.logo'))))
                        <img class="h-14 w-14 object-contain mr-3" src="{{ public_path(config('company.logo')) }}" alt="Logo">
                    @endif
                    <span class="text-sm font-bold uppercase">{{ config('company.name') }}</span><br>
                    <span class="text-slate-500">{{ config('company.address') }}</span><br>
                    <span class="text-slate-500">Telp: {{ config('company.phone') }} | Email: {{ config('company.email') }}</span>
                </td>
                <td class="align-top text-right">
                    <div class="text-xl font-bold tracking-[3px]">KWITANSI</div>
                    <div class="text-slate-500">No: {{ $kwitansi->nomor_kwitansi }}</div>
                </td>
            </tr>
        </table>
    </div>

    <table class="w-full border-collapse mb-5">
        <tr><td class="py-1 text-slate-500 w-40 align-top">Sudah terima dari</td><td class="py-1 w-3 align-top">:</td><td class="py-1"><strong>{{ $kwitansi->nama_pembeli }}</strong></td></tr>
        <tr><td class="py-1 text-slate-500 align-top">Paket Bimbingan Belajar</td><td class="py-1 align-top">:</td><td class="py-1"><strong>{{ $kwitansi->nama_paket }}</strong></td></tr>
        <tr><td class="py-1 text-slate-500 align-top">Untuk pembayaran</td><td class="py-1 align-top">:</td><td class="py-1">{{ $kwitansi->tujuan_pembelian }}</td></tr>
        <tr><td class="py-1 text-slate-500 align-top">Terbilang</td><td class="py-1 align-top">:</td><td class="py-1"><em>{{ $terbilang }}</em></td></tr>
        <tr><td class="py-1 text-slate-500 align-top">Tanggal</td><td class="py-1 align-top">:</td><td class="py-1">{{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</td></tr>
    </table>

    <div class="border-2 border-slate-800 px-4 py-2 text-right w-40 ml-auto">
        <div class="text-slate-500 text-[9px]">Jumlah</div>
        <div class="text-base font-bold">Rp {{ number_format($kwitansi->harga, 0, ',', '.') }}</div>
    </div>

    <div class="mt-5 ml-auto text-center w-48">
        <div>{{ config('company.address') }}, {{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}</div>
        <div>Penerima,</div>
        <div class="h-13"></div>
        <div class="border-t border-slate-800 pt-1 font-bold">{{ $kwitansi->nama_penerima ?: config('company.penerima') }}</div>
    </div>
</body>
</html>
