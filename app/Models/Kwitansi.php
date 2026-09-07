<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kwitansi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_kwitansi',
        'nama_pembeli',
        'nama_paket',
        'harga',
        'tujuan_pembelian',
        'tanggal',
        'nama_penerima',
    ];

    protected $casts = [
        'harga'   => 'decimal:2',
        'tanggal' => 'date',
    ];

    /**
     * Membuat nomor kwitansi otomatis, format: KW/YYYYMMDD/0001
     */
    public static function generateNomor(): string
    {
        $prefix = 'KW';
        $tanggal = now()->format('Ymd');
        $urutan = static::whereDate('created_at', now()->toDateString())->count() + 1;

        return sprintf('%s/%s/%04d', $prefix, $tanggal, $urutan);
    }
}
