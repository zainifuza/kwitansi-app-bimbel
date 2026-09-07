<?php

namespace App\Http\Controllers;

use App\Helpers\Terbilang;
use App\Models\Kwitansi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KwitansiController extends Controller
{
    /**
     * Menampilkan daftar semua kwitansi.
     */
    public function index()
    {
        $kwitansis = Kwitansi::latest()->paginate(10);

        return view('kwitansi.index', compact('kwitansis'));
    }

    /**
     * Menampilkan form pembuatan kwitansi baru.
     */
    public function create()
    {
        return view('kwitansi.create');
    }

    /**
     * Menyimpan kwitansi baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pembeli'     => 'required|string|max:255',
            'nama_paket'       => 'required|string|max:255',
            'harga'            => 'required|numeric|min:0',
            'tujuan_pembelian' => 'required|string',
            'tanggal'          => 'required|date',
            'nama_penerima'    => 'nullable|string|max:255',
        ]);

        $validated['nomor_kwitansi'] = Kwitansi::generateNomor();

        $kwitansi = Kwitansi::create($validated);

        return redirect()
            ->route('kwitansi.show', $kwitansi)
            ->with('success', 'Kwitansi berhasil dibuat.');
    }

    /**
     * Menampilkan detail / cetak kwitansi.
     */
    public function show(Kwitansi $kwitansi)
    {
        $terbilang = Terbilang::make((float) $kwitansi->harga) . ' Rupiah';

        return view('kwitansi.show', compact('kwitansi', 'terbilang'));
    }

    /**
     * Mengunduh kwitansi dalam format PDF.
     */
    public function download(Kwitansi $kwitansi)
    {
        $terbilang = Terbilang::make((float) $kwitansi->harga) . ' Rupiah';
        $tailwindCss = '';
        $manifestPath = public_path('build/manifest.json');

        if (is_file($manifestPath)) {
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $stylesheet = $manifest['resources/css/app.css']['file'] ?? null;
            $stylesheetPath = $stylesheet ? public_path('build/' . $stylesheet) : null;

            if ($stylesheetPath && is_file($stylesheetPath)) {
                $tailwindCss = file_get_contents($stylesheetPath);
            }
        }

        $pdf = Pdf::loadView('kwitansi.pdf', compact('kwitansi', 'terbilang', 'tailwindCss'))
            ->setPaper('a5', 'landscape');

        $filename = str_replace(['/', '\\'], '-', $kwitansi->nomor_kwitansi);

        return $pdf->download('kwitansi-' . $filename . '.pdf');
    }

    /**
     * Menghapus kwitansi.
     */
    public function destroy(Kwitansi $kwitansi)
    {
        $kwitansi->delete();

        return redirect()
            ->route('kwitansi.index')
            ->with('success', 'Kwitansi berhasil dihapus.');
    }
}
