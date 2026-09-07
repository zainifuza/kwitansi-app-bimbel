@extends('layouts.app')

@section('title', 'Buat Kwitansi Baru')

@section('content')
    <div class="bg-white rounded-xl shadow p-6 max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-6">
            @if(file_exists(public_path(config('company.logo'))))
                <img src="{{ asset(config('company.logo')) }}" alt="Logo" class="h-12 w-12 object-contain">
            @endif
            <div>
                <h1 class="text-xl font-bold text-slate-800">Form Kwitansi Pembelian Bimbingan Belajar</h1>
                <p class="text-sm text-slate-500">{{ config('company.name') }}</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100 border border-red-300 text-red-800 px-4 py-3">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kwitansi.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Pembeli</label>
                <input type="text" name="nama_pembeli" value="{{ old('nama_pembeli') }}" required
                       class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="Nama orang tua / peserta didik">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Paket Bimbingan Belajar</label>
                <input type="text" name="nama_paket" value="{{ old('nama_paket') }}" required
                       class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="Contoh: Paket Intensif UTBK 6 Bulan">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Harga (Rp)</label>
                <input type="number" name="harga" value="{{ old('harga') }}" required min="0" step="1000"
                       class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       placeholder="Contoh: 1500000">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tujuan Pembelian</label>
                <textarea name="tujuan_pembelian" rows="3" required
                          class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                          placeholder="Contoh: Pembayaran biaya bimbingan belajar persiapan UTBK 2027">{{ old('tujuan_pembelian') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                       class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Penerima (opsional)</label>
                <input type="text" name="nama_penerima" value="{{ old('nama_penerima', config('company.penerima')) }}"
                       class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="pt-2 flex justify-end gap-2">
                <a href="{{ route('kwitansi.index') }}" class="px-4 py-2 rounded-md border border-slate-300 text-slate-700">Batal</a>
                <button type="submit" class="px-4 py-2 rounded-md bg-indigo-600 text-white font-medium hover:bg-indigo-700">
                    Simpan &amp; Cetak Kwitansi
                </button>
            </div>
        </form>
    </div>
@endsection
