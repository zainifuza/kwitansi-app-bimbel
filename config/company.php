<?php

return [
    // Ubah nilai-nilai ini sesuai identitas perusahaan/lembaga bimbingan belajar Anda,
    // atau atur lewat file .env agar tidak perlu mengubah kode.

    'name'      => env('COMPANY_NAME', 'Bimbingan Belajar Cerdas Bangsa'),
    'address'   => env('COMPANY_ADDRESS', 'Jl. Pendidikan No. 123, Medan, Sumatera Utara'),
    'phone'     => env('COMPANY_PHONE', '(061) 1234-5678'),
    'email'     => env('COMPANY_EMAIL', 'info@cerdasbangsa.id'),

    // Letakkan file logo di public/images/logo.png
    'logo'      => env('COMPANY_LOGO', 'images/logo.png'),

    // Letakkan file stempel (PNG transparan) di public/images/stempel.png
    'stempel'   => env('COMPANY_STEMPEL', 'images/stempel.png'),

    // Nama default yang tertera di kolom "Penerima" jika tidak diisi di form
    'penerima'  => env('COMPANY_PENERIMA', 'Admin Keuangan'),
];
