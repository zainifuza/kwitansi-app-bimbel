# Aplikasi Kwitansi Bimbingan Belajar (Laravel)

Aplikasi sederhana untuk membuat, menyimpan, dan mencetak kwitansi pembelian
paket bimbingan belajar. Sudah termasuk:

- Form input kwitansi (nama pembeli, nama paket, harga, tujuan pembelian, tanggal)
- Halaman kwitansi siap cetak dengan **logo perusahaan**, **alamat perusahaan**,
  area **tanda tangan**, dan area **stempel**
- Nomor kwitansi otomatis (format `KW/YYYYMMDD/0001`)
- Jumlah harga otomatis dalam angka & terbilang (huruf)
- Daftar riwayat kwitansi + hapus
- Migrasi tabel `kwitansis`

---

## 1. Cara Instalasi

> Karena file di sini hanya berisi **kode kustom fitur kwitansi**
> (bukan seluruh framework Laravel), langkah pertama adalah membuat project
> Laravel kosong, baru kemudian menyalin file-file dari paket ini ke dalamnya.

### a. Buat project Laravel baru
```bash
composer create-project laravel/laravel kwitansi-app
cd kwitansi-app
```

### b. Salin file dari paket ini ke project Laravel
Salin folder/file berikut (timpa/gabungkan dengan yang sudah ada di project baru):

| Dari paket ini | Ke project Laravel |
|---|---|
| `app/Models/Kwitansi.php` | `app/Models/Kwitansi.php` |
| `app/Http/Controllers/KwitansiController.php` | `app/Http/Controllers/KwitansiController.php` |
| `app/Helpers/Terbilang.php` | `app/Helpers/Terbilang.php` |
| `database/migrations/2026_09_07_000000_create_kwitansis_table.php` | `database/migrations/...` |
| `resources/views/kwitansi/*` | `resources/views/kwitansi/*` |
| `resources/views/layouts/app.blade.php` | `resources/views/layouts/app.blade.php` |
| `config/company.php` | `config/company.php` |
| `routes/web.php` | `routes/web.php` (timpa file default) |
| `public/images/` | `public/images/` |

### c. Tambahkan konfigurasi identitas perusahaan
Buka isi file `.env.company.example` di paket ini, salin semua barisnya
ke bagian bawah file `.env` project Laravel Anda, lalu sesuaikan nilainya.

### d. Siapkan database
Buat database MySQL kosong (misal `kwitansi_app`), lalu atur di `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kwitansi_app
DB_USERNAME=root
DB_PASSWORD=
```

### e. Jalankan migrasi
```bash
php artisan migrate
```

### f. Tambahkan logo & stempel (opsional tapi disarankan)
Letakkan file gambar Anda di:
```
public/images/logo.png       # logo perusahaan
public/images/stempel.png    # stempel, disarankan PNG transparan
```
Jika belum punya, aplikasi tetap jalan normal (logo diganti placeholder,
area stempel dikosongkan).

### g. Jalankan aplikasi
```bash
php artisan serve
```
Buka `http://127.0.0.1:8000` di browser.

---

## 2. Alur Penggunaan

1. Klik **"+ Buat Kwitansi"**.
2. Isi nama pembeli, nama paket bimbel, harga, tujuan pembelian, dan tanggal.
3. Setelah disimpan, Anda langsung diarahkan ke **halaman kwitansi siap cetak**
   berisi logo, alamat perusahaan, rincian pembayaran, jumlah terbilang,
   serta area tanda tangan & stempel penerima.
4. Klik tombol **"Cetak Kwitansi"** untuk mencetak/menyimpan sebagai PDF
   (gunakan opsi "Save as PDF" pada dialog print browser).
5. Semua kwitansi yang pernah dibuat bisa dilihat kembali di halaman daftar.

---

## 3. Struktur Tabel `kwitansis`

| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | Primary key |
| nomor_kwitansi | string, unique | Dibuat otomatis |
| nama_pembeli | string | |
| nama_paket | string | Nama paket bimbingan belajar |
| harga | decimal(15,2) | |
| tujuan_pembelian | text | |
| tanggal | date | |
| nama_penerima | string, nullable | Nama yang tertera di kolom tanda tangan |
| created_at / updated_at | timestamp | |

---

## 4. Kustomisasi

- **Ubah identitas perusahaan**: edit `config/company.php` atau variabel
  `COMPANY_*` di `.env`.
- **Ubah tata letak/gaya kwitansi**: edit `resources/views/kwitansi/show.blade.php`
  (menggunakan Tailwind CSS via CDN, tidak perlu proses build).
- **Ubah ukuran kertas cetak**: edit bagian `@page { size: A5 landscape; ... }`
  di `show.blade.php` (bisa diganti misalnya `A4`, `A5 portrait`, dst).
