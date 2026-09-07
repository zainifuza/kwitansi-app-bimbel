<?php

namespace App\Helpers;

class Terbilang
{
    protected static array $angka = [
        '', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas',
    ];

    /**
     * Ubah angka menjadi teks terbilang Bahasa Indonesia.
     */
    public static function make(float $number): string
    {
        $number = (int) round($number);

        if ($number < 0) {
            return 'Minus ' . trim(self::convert(abs($number)));
        }

        if ($number === 0) {
            return 'Nol';
        }

        return trim(preg_replace('/\s+/', ' ', self::convert($number)));
    }

    protected static function convert(int $number): string
    {
        if ($number < 12) {
            return self::$angka[$number];
        } elseif ($number < 20) {
            return self::convert($number - 10) . ' Belas';
        } elseif ($number < 100) {
            return self::convert(intdiv($number, 10)) . ' Puluh ' . self::convert($number % 10);
        } elseif ($number < 200) {
            return 'Seratus ' . self::convert($number - 100);
        } elseif ($number < 1000) {
            return self::convert(intdiv($number, 100)) . ' Ratus ' . self::convert($number % 100);
        } elseif ($number < 2000) {
            return 'Seribu ' . self::convert($number - 1000);
        } elseif ($number < 1000000) {
            return self::convert(intdiv($number, 1000)) . ' Ribu ' . self::convert($number % 1000);
        } elseif ($number < 1000000000) {
            return self::convert(intdiv($number, 1000000)) . ' Juta ' . self::convert($number % 1000000);
        } elseif ($number < 1000000000000) {
            return self::convert(intdiv($number, 1000000000)) . ' Miliar ' . self::convert($number % 1000000000);
        }

        return self::convert(intdiv($number, 1000000000000)) . ' Triliun ' . self::convert($number % 1000000000000);
    }
}
