@extends('layouts.app')

@section('title', 'Pengaturan Kwitansi')

@section('content')
    <div class="mx-auto max-w-4xl">
        <div class="mb-6">
            <p class="mb-1 text-xs font-bold uppercase tracking-[0.18em] text-indigo-600">Pengaturan</p>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Identitas kwitansi</h1>
            <p class="mt-1 text-sm text-slate-500">Data ini akan digunakan pada halaman kwitansi dan file PDF.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <p class="font-semibold">Periksa kembali isian berikut:</p>
                <ul class="mt-1 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('settings.company.update') }}" method="POST" enctype="multipart/form-data" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            @csrf
            @method('PUT')

            <div class="border-b border-slate-200 bg-slate-50 px-5 py-4 sm:px-7">
                <h2 class="font-semibold text-slate-900">Informasi lembaga</h2>
                <p class="mt-1 text-xs text-slate-500">Atur informasi yang tampil di bagian header kwitansi.</p>
            </div>

            <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-7">
                <div class="sm:col-span-2">
                    <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama perusahaan / lembaga</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $settings['name']) }}" required class="block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat</label>
                    <textarea id="address" name="address" rows="2" required class="block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">{{ old('address', $settings['address']) }}</textarea>
                </div>
                <div>
                    <label for="phone" class="mb-1.5 block text-sm font-semibold text-slate-700">Nomor telepon</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $settings['phone']) }}" class="block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                </div>
                <div>
                    <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $settings['email']) }}" class="block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                </div>
                <div class="sm:col-span-2">
                    <label for="penerima" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama penerima default</label>
                    <input id="penerima" type="text" name="penerima" value="{{ old('penerima', $settings['penerima']) }}" required class="block w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm shadow-sm outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100">
                </div>
            </div>

            <div class="border-y border-slate-200 bg-slate-50 px-5 py-4 sm:px-7">
                <h2 class="font-semibold text-slate-900">Logo dan stempel</h2>
                <p class="mt-1 text-xs text-slate-500">Format PNG atau JPG, maksimal 2 MB. Gambar akan tampil di kwitansi dan PDF.</p>
            </div>

            <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-7">
                @foreach (['logo' => 'Logo lembaga', 'stempel' => 'Stempel lembaga'] as $key => $label)
                    <div>
                        <label for="{{ $key }}" class="mb-2 block text-sm font-semibold text-slate-700">{{ $label }}</label>
                        <div class="mb-3 flex h-24 items-center justify-center rounded-lg border border-dashed border-slate-300 bg-slate-50 p-2">
                            @if (file_exists(public_path($settings[$key])))
                                <img src="{{ asset($settings[$key]) }}" alt="{{ $label }}" class="h-full max-w-full object-contain">
                            @else
                                <span class="text-xs text-slate-400">Belum ada gambar</span>
                            @endif
                        </div>
                        <input id="{{ $key }}" type="file" name="{{ $key }}" accept=".png,.jpg,.jpeg" class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-2 file:font-semibold file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                @endforeach
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-7">
                <a href="{{ route('kwitansi.index') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-100">Batal</a>
                <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-200">Simpan pengaturan</button>
            </div>
        </form>
    </div>
@endsection
