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
            'status_pembayaran' => 'required|in:LUNAS,BELUM LUNAS,CICILAN',
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

        $logoPath = public_path(config('company.logo'));
        $logoData = null;
        if (file_exists($logoPath)) {
            $logoData = 'data:image/' . pathinfo($logoPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoPath));
        }

        $stempelPath = public_path(config('company.stempel'));
        $stempelData = null;
        if (file_exists($stempelPath)) {
            $stempelData = 'data:image/' . pathinfo($stempelPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($stempelPath));
        }

        $logoLunasPath = public_path(config('company.logo_lunas'));
        $logoLunasData = null;
        if (file_exists($logoLunasPath)) {
            $logoLunasData = 'data:image/' . pathinfo($logoLunasPath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($logoLunasPath));
        }

        $signaturePath = public_path(config('company.signature'));
        $signatureData = null;
        if (file_exists($signaturePath)) {
            $signatureData = 'data:image/' . pathinfo($signaturePath, PATHINFO_EXTENSION) . ';base64,' . base64_encode(file_get_contents($signaturePath));
        }

        $pdf = Pdf::loadView('kwitansi.pdf', compact('kwitansi', 'terbilang', 'logoData', 'stempelData', 'logoLunasData', 'signatureData'))
            ->setPaper('a5', 'portrait')
            ->setOption('isRemoteEnabled', false);

        $filename = str_replace(['/', '\\'], '-', date('his') . '-' . $kwitansi->nomor_kwitansi);

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
