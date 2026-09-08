@extends('layouts.app')

@section('title', 'Kwitansi ' . $kwitansi->nomor_kwitansi)

@push('styles')
<style>
    @media print {
        @page { size: A5 landscape; margin: 10mm; }
        body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
    }
</style>
@endpush

@section('content')

    <div class="mb-4 flex flex-col gap-2 print:hidden sm:flex-row sm:justify-end">
        <a href="{{ route('kwitansi.index') }}" class="inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-slate-700 hover:bg-slate-50">
            &larr; Kembali
        </a>
        <button onclick="window.print()" class="rounded-md bg-indigo-600 px-4 py-2 font-medium text-white hover:bg-indigo-700">
            Cetak Kwitansi
        </button>
        <a href="{{ route('kwitansi.download', $kwitansi) }}" class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-4 py-2 font-medium text-white hover:bg-emerald-700">
            Unduh PDF
        </a>
    </div>

    {{-- KERTAS KWITANSI --}}
    <div class="relative overflow-hidden rounded-xl border-2 border-dashed border-slate-300 bg-white p-6 shadow sm:p-8">

        {{-- HEADER: LOGO + ALAMAT PERUSAHAAN --}}
        <div class="mb-6 flex flex-col gap-4 border-b-2 border-slate-800 pb-4 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex min-w-0 items-center gap-3 sm:gap-4">
                @if(file_exists(public_path(config('company.logo'))))
                    <img src="{{ asset(config('company.logo')) }}" alt="Logo" class="h-16 w-16 object-contain shrink-0">
                @else
                    <div class="h-16 w-16 shrink-0 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs text-center">
                        LOGO
                    </div>
                @endif
                <div class="min-w-0">
                    <h1 class="break-words text-lg font-bold uppercase text-slate-800">{{ config('company.name') }}</h1>
                    <p class="break-words text-sm text-slate-600">{{ config('company.address') }}</p>
                    <p class="break-words text-sm text-slate-600">
                        Telp: {{ config('company.phone') }} &middot; Email: {{ config('company.email') }}
                    </p>
                </div>
            </div>
            <div class="text-left sm:text-right shrink-0">
                <h2 class="text-2xl font-extrabold tracking-widest text-slate-800">KWITANSI</h2>
                <p class="text-sm text-slate-500">No: {{ $kwitansi->nomor_kwitansi }}</p>
            </div>
        </div>

        {{-- ISI KWITANSI --}}
        <table class="w-full text-sm mb-6">
            <tbody>
                <tr>
                    <td class="w-32 py-1.5 align-top text-slate-500 sm:w-48">Sudah terima dari</td>
                    <td class="w-4 py-1.5 align-top">:</td>
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
                    <td class="py-1.5 italic font-medium text-slate-800 align-top capitalize bg-slate-50 px-2 py-1 rounded border border-slate-100">
                        {{ $terbilang }} Rupiah
                    </td>
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

        {{-- JUMLAH HARGA & STEMPEL LUNAS --}}
        <div class="flex items-end justify-between mb-8">
            {{-- Penanda status pembayaran diletakkan terpisah di sebelah kiri kotak total harga. --}}
            <div class="h-16 w-auto flex items-center justify-start">
                @if($kwitansi->status_pembayaran === 'LUNAS' && file_exists(public_path(config('company.logo_lunas'))))
                    <img src="{{ asset(config('company.logo_lunas')) }}" alt="Lunas"
                         class="h-36 object-contain mix-blend-multiply opacity-90" style="width:230px">
                @else
                    <span class="rounded border-2 px-3 py-2 text-sm font-extrabold tracking-wide {{ $kwitansi->status_pembayaran === 'CICILAN' ? 'border-amber-500 text-amber-600' : 'border-slate-400 text-slate-500' }}">
                        {{ $kwitansi->status_pembayaran }}
                    </span>
                @endif
            </div>

            <div class="border-2 border-slate-800 rounded-lg px-6 py-2.5 text-right min-w-48">
                <span class="text-xs text-slate-500 block font-medium uppercase tracking-wider">Jumlah</span>
                <span class="text-2xl font-black text-slate-800">
                    Rp {{ number_format($kwitansi->harga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- TANDA TANGAN & STEMPEL BASAH --}}
        <div class="flex justify-end">
            <div class="text-center w-60">
                <p class="text-sm text-slate-600 mb-1">
                    {{ config('company.city', 'Banda Aceh') }}, {{ \Carbon\Carbon::parse($kwitansi->tanggal)->translatedFormat('d F Y') }}
                </p>
                <p class="text-sm font-medium text-slate-700">Penerima,</p>

                {{-- Container khusus area TTD & Stempel --}}
                <div class="relative h-28 w-full flex items-center justify-center my-1">
                    {{-- Stempel Basah (Lapis Bawah/Transparan) --}}
                    @if(file_exists(public_path(config('company.stempel'))))
                        <img src="{{ asset(config('company.stempel')) }}" alt="Stempel"
                             class="absolute h-28 w-28 object-contain opacity-75 pointer-events-none -left-2 top-1/2 -translate-y-1/2 mix-blend-multiply">
                    @endif

                    {{-- Tanda Tangan (Lapis Atas) --}}
                    @if(file_exists(public_path(config('company.signature'))))
                        <img src="{{ asset(config('company.signature')) }}" alt="Signature"
                             class="relative z-10 h-28 w-32 object-contain pointer-events-none">
                    @endif
                </div>

                <p class="border-t border-slate-800 pt-1 font-semibold text-slate-800">
                    {{ $kwitansi->nama_penerima ?: config('company.penerima') }}
                </p>
            </div>
        </div>
    </div>
@endsection
