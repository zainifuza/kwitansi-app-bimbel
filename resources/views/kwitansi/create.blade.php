@extends('layouts.app')

@section('title', 'Buat Kwitansi Baru')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="mb-1 text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">Kwitansi baru</p>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Buat kwitansi pembayaran</h1>
                <p class="mt-1 text-sm text-slate-500">Isi data pembayaran dengan lengkap untuk membuat kwitansi.</p>
            </div>
            <a href="{{ route('kwitansi.index') }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600">
                &larr; Kembali ke daftar
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-6 flex gap-3 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800" role="alert">
                <div class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-red-600 text-xs font-bold text-white">!</div>
                <div>
                    <p class="font-semibold">Periksa kembali data yang diisi.</p>
                    <ul class="mt-1 list-disc pl-4 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_260px] lg:items-start">
            <form action="{{ route('kwitansi.store') }}" method="POST" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf

                <div class="border-b border-slate-200 bg-slate-50 px-5 py-4 sm:px-7">
                    <h2 class="font-semibold text-slate-900">Informasi pembeli</h2>
                    <p class="mt-1 text-xs text-slate-500">Data ini akan ditampilkan pada bagian penerima pembayaran.</p>
                </div>

                <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-7">
                    <div class="sm:col-span-2">
                        <label for="nama_pembeli" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama pembeli <span class="text-red-500">*</span></label>
                        <input id="nama_pembeli" type="text" name="nama_pembeli" value="{{ old('nama_pembeli') }}" required autofocus
                               class="block w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                               placeholder="Nama orang tua / peserta didik">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="nama_paket" class="mb-1.5 block text-sm font-semibold text-slate-700">Paket bimbingan belajar <span class="text-red-500">*</span></label>
                        <input id="nama_paket" type="text" name="nama_paket" value="{{ old('nama_paket') }}" required
                               class="block w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                               placeholder="Contoh: Paket Intensif UTBK 6 Bulan">
                    </div>
                </div>

                <div class="border-y border-slate-200 bg-slate-50 px-5 py-4 sm:px-7">
                    <h2 class="font-semibold text-slate-900">Detail pembayaran</h2>
                    <p class="mt-1 text-xs text-slate-500">Pastikan nominal dan tujuan pembayaran sudah benar.</p>
                </div>

                <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-7">
                    <div>
                        <label for="harga" class="mb-1.5 block text-sm font-semibold text-slate-700">Harga <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-sm font-medium text-slate-500">Rp</span>
                            <input id="harga" type="number" name="harga" value="{{ old('harga') }}" required min="0" step="1000"
                                   class="block w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                   placeholder="1.500.000">
                        </div>
                    </div>

                    <div>
                        <label for="tanggal" class="mb-1.5 block text-sm font-semibold text-slate-700">Tanggal pembayaran <span class="text-red-500">*</span></label>
                        <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                               class="block w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="tujuan_pembelian" class="mb-1.5 block text-sm font-semibold text-slate-700">Tujuan pembelian <span class="text-red-500">*</span></label>
                        <textarea id="tujuan_pembelian" name="tujuan_pembelian" rows="3" required
                                  class="block w-full resize-y rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                                  placeholder="Contoh: Pembayaran biaya bimbingan belajar persiapan UTBK 2027">{{ old('tujuan_pembelian') }}</textarea>
                    </div>
                </div>

                <div class="border-t border-slate-200 px-5 py-6 sm:px-7">
                    <label for="nama_penerima" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama penerima <span class="font-normal text-slate-400">(opsional)</span></label>
                    <input id="nama_penerima" type="text" name="nama_penerima" value="{{ old('nama_penerima', config('company.penerima')) }}"
                           class="block w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100"
                           placeholder="Nama penerima pembayaran">
                    <p class="mt-1.5 text-xs text-slate-500">Jika dikosongkan, nama default lembaga akan digunakan.</p>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-7">
                    <a href="{{ route('kwitansi.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Batal</a>
                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">
                        Simpan &amp; Cetak Kwitansi
                    </button>
                </div>
            </form>

            <aside class="rounded-2xl border border-indigo-100 bg-indigo-50 p-5 text-indigo-950">
                <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-lg font-bold text-white">i</div>
                <h2 class="font-semibold">Petunjuk pengisian</h2>
                <ul class="mt-4 space-y-3 text-sm leading-5 text-indigo-900">
                    <li class="flex gap-2"><span class="font-bold text-indigo-500">01</span><span>Gunakan nama pembeli sesuai data pembayaran.</span></li>
                    <li class="flex gap-2"><span class="font-bold text-indigo-500">02</span><span>Masukkan harga dalam rupiah tanpa tanda titik.</span></li>
                    <li class="flex gap-2"><span class="font-bold text-indigo-500">03</span><span>Periksa kembali data sebelum menyimpan.</span></li>
                </ul>
            </aside>
        </div>
    </div>
@endsection
