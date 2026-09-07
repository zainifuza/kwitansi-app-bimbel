@extends('layouts.app')

@section('title', 'Kwitansi ' . $kwitansi->nomor_kwitansi)

@push('styles')
<style>
    @media print {
        @page { size: A5 landscape; margin: 10mm; }
    }
</style>
@endpush

@section('content')

    <div class="print:hidden mb-4 flex justify-end gap-2">
        <a href="{{ route('kwitansi.index') }}" class="px-4 py-2 rounded-md border border-slate-300 text-slate-700 bg-white">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="px-4 py-2 rounded-md bg-indigo-600 text-white font-medium hover:bg-indigo-700">
            Cetak Kwitansi
        </button>
        <a href="{{ route('kwitansi.download', $kwitansi) }}" class="px-4 py-2 rounded-md bg-emerald-600 text-white font-medium hover:bg-emerald-700">
            Unduh PDF
        </a>
    </div>

    {{-- KERTAS KWITANSI --}}
    <div class="bg-white shadow rounded-xl p-8 border-2 border-dashed border-slate-300 relative overflow-hidden">

        {{-- HEADER: LOGO + ALAMAT PERUSAHAAN --}}
        <div class="flex items-start justify-between border-b-2 border-slate-800 pb-4 mb-6">
            <div class="flex items-center gap-4">
                @if(file_exists(public_path(config('company.logo'))))
                    <img src="{{ asset(config('company.logo')) }}" alt="Logo" class="h-16 w-16 object-contain">
                @else
                    <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs text-center">
                        LOGO
                    </div>
                @endif
                <div>
                    <h1 class="text-lg font-bold text-slate-800 uppercase">{{ config('company.name') }}</h1>
                    <p class="text-sm text-slate-600">{{ config('company.address') }}</p>
                    <p class="text-sm text-slate-600">
                        Telp: {{ config('company.phone') }} &middot; Email: {{ config('company.email') }}
                    </p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-2xl font-extrabold tracking-widest text-slate-800">KWITANSI</h2>
                <p class="text-sm text-slate-500">No: {{ $kwitansi->nomor_kwitansi }}</p>
            </div>
        </div>

        {{-- ISI KWITANSI --}}
        <table class="w-full text-sm mb-6">
            <tbody>
                <tr>
                    <td class="py-1.5 w-48 text-slate-500 align-top">Sudah terima dari</td>
                    <td class="py-1.5 w-4 align-top">:</td>
                    <td class="py-1.5 font-semibold text-slate-800 align-top">{{ $kwitansi->nama_pembeli }}</td>
                </tr>
                <tr>
                    <td class="py-1.5 text-slate-500 align-top">Paket Bimbingan Belajar</td>
                    <td class="py-1.5 align-top">:</td>
                    <td class="py-1.5 font-semibold text-slate-800 align-top">{{ $kwitansi->nama_paket }}</td>
                </tr>
                <tr>
                    <td class="py-1.5 text-slate-500 align-top">Untuk pembayaran</td>
                    <td class="py-1.5 align-top">:</td>
                    <td class="py-1.5 text-slate-800 align-top">{{ $kwitansi->tujuan_pembelian }}</td>
                </tr>
                <tr>
                    <td class="py-1.5 text-slate-500 align-top">Terbilang</td>
                    <td class="py-1.5 align-top">:</td>
                    <td class="py-1.5 italic text-slate-800 align-top">{{ $terbilang }}</td>
                </tr>
                <tr>
                    <td class="py-1.5 text-slate-500 align-top">Tanggal</td>
                    <td class="py-1.5 align-top">:</td>
                    <td class="py-1.5 text-slate-800 align-top">
                        {{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}
                    </td>
                </tr>
            </tbody>
        </table>

        {{-- JUMLAH HARGA --}}
        <div class="flex justify-end mb-10">
            <div class="border-2 border-slate-800 rounded-lg px-6 py-3 text-right">
                <span class="text-xs text-slate-500 block">Jumlah</span>
                <span class="text-xl font-bold text-slate-800">
                    Rp {{ number_format($kwitansi->harga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- TANDA TANGAN & STEMPEL --}}
        <div class="flex justify-end">
            <div class="text-center w-56 relative">
                <p class="text-sm text-slate-600 mb-1">
                    {{ config('company.address') }} ({{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }})
                </p>
                <p class="text-sm text-slate-600 mb-16">Penerima,</p>

                {{-- Area stempel: ditumpuk transparan di atas area tanda tangan --}}
                @if(file_exists(public_path(config('company.stempel'))))
                    <img src="{{ asset(config('company.stempel')) }}" alt="Stempel"
                         class="h-24 w-24 object-contain absolute left-1/2 -translate-x-1/2 -top-4 opacity-80 pointer-events-none">
                @endif

                <p class="border-t border-slate-800 pt-1 font-semibold text-slate-800">
                    {{ $kwitansi->nama_penerima ?: config('company.penerima') }}
                </p>
            </div>
        </div>
    </div>
@endsection
