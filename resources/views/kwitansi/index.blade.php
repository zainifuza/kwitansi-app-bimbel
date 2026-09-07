@extends('layouts.app')

@section('title', 'Daftar Kwitansi')

@section('content')
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h1 class="text-lg font-bold text-slate-800">Daftar Kwitansi Bimbingan Belajar</h1>
            <a href="{{ route('kwitansi.create') }}" class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700">
                + Buat Kwitansi
            </a>
        </div>

        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-left">
                <tr>
                    <th class="px-6 py-3">No. Kwitansi</th>
                    <th class="px-6 py-3">Pembeli</th>
                    <th class="px-6 py-3">Paket</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($kwitansis as $item)
                    <tr>
                        <td class="px-6 py-3 font-mono text-xs text-slate-600">{{ $item->nomor_kwitansi }}</td>
                        <td class="px-6 py-3 font-medium text-slate-800">{{ $item->nama_pembeli }}</td>
                        <td class="px-6 py-3">{{ $item->nama_paket }}</td>
                        <td class="px-6 py-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-3">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                        <td class="px-6 py-3 text-right space-x-2">
                            <a href="{{ route('kwitansi.show', $item) }}" class="text-indigo-600 hover:underline">Lihat / Cetak</a>
                            <form action="{{ route('kwitansi.destroy', $item) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Hapus kwitansi ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">Belum ada kwitansi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-6 py-4">
            {{ $kwitansis->links() }}
        </div>
    </div>
@endsection
