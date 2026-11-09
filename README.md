# 🏍️ MotoCheck — Sistem Pakar Diagnosa Sepeda Motor Berbasis Web

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11%2B-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/JavaScript-ES6%2B-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript">
  <img src="https://img.shields.io/badge/SQLite-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite">
</p>

---

## 📌 Tentang MotoCheck

**MotoCheck** adalah aplikasi web sistem pakar (*expert system*) yang dirancang untuk membantu pemilik sepeda motor mendeteksi dan mendiagnosa indikasi kerusakan motor secara mandiri sebelum pergi ke bengkel. 

Dengan MotoCheck, pengguna dapat:
- Mengidentifikasi akar masalah kerusakan motor berdasarkan gejala fisik yang dialami.
- Mengetahui status keputusan penggantian suku cadang secara transparan (**YA — Wajib Ganti**, **TIDAK — Bisa Diservis**, atau **KONDISIONAL — Cek Dulu**).
- Memperoleh estimasi rentang biaya suku cadang dan jasa servis yang realistis.
- Terhindar dari praktik **overcharging** atau penggantian komponen yang sebenarnya tidak diperlukan oleh oknum bengkel nakal.

---

## ✨ Fitur-Fitur Utama

### 1. 🔍 Diagnosa Kerusakan Interaktif (Sistem Pakar)
- **Checklist Gejala Multikategori**:
  - **Kategori A (Kelistrikan & Starter)**: Masalah aki drop, tombol starter mati, lampu redup, kiprok/spul tidak stabil.
  - **Kategori B (Mesin & Performa)**: Tarikan gas brebet/ngempos, knalpot berasap pekat, konsumsi BBM boros, mesin overheat & bunyi ketukan blok silinder.
  - **Kategori C (Transmisi / CVT Matic)**: Gejala getaran awal (*gredek*), decitan rumah CVT, dan keausan kampas ganda.
- **Rule Engine & Analisis Dinamis**:
  - Menghitung tingkat keparahan (*Ringan*, *Sedang*, *Berat/Kritis*).
  - Menyediakan ringkasan total estimasi biaya perbaikan suku cadang secara otomatis.
  - Memberikan panduan **Akar Masalah** dan **Solusi Pertolongan Pertama**.
- **Penyimpanan Riwayat Otomatis**: Hasil diagnosa tersimpan otomatis ke akun pengguna atau secara anonim untuk analitik sistem.

### 2. 🚦 Keputusan Penggantian Suku Cadang
Setiap hasil analisis menampilkan badge status keputusan yang jelas:
- 🔴 **YA — WAJIB GANTI**: Komponen harus diganti (contoh: Ring Piston aus, Piston macet karena oli habis) untuk menghindari kerusakan permanen pada blok silinder.
- 🟢 **TIDAK — BISA DISERVIS**: Komponen masih bisa dibersihkan, diservis, atau disetel ulang terlebih dahulu (contoh: pembersihan CVT/gredek, servis injektor/karbu).
- 🟡 **KONDISIONAL — CEK DULU**: Perlu pengujian awal sebelum memutuskan ganti (contoh: cas voltase aki terlebih dahulu).

### 3. 📅 Katalog & Jadwal Perawatan Berkala (KM Checker)
- **Cek Status Servis Berdasarkan Jarak Tempuh (KM)**: Masukkan angka odometer motor untuk melihat rekomendasi suku cadang yang jatuh tempo servis.
- **Preset KM Cepat**: Tombol pintas untuk kilometer umum (2.500, 8.000, 10.000, 15.000, 20.000, 25.000 KM).
- **Pencarian Real-Time**: Kolom pencarian responsif untuk mencari nama sparepart, interval, dan harga.
- **Filter Kategori**: Menyaring suku cadang berdasarkan kategori (*Mesin & Pelumasan*, *Pengapian & Kelistrikan*, *Transmisi / CVT*, *Pengereman*, *Filter & Saluran Udara*).

### 4. 👤 Manajemen Akun Pengguna (`/account`)
- **Riwayat Diagnosa Pribadi**: Menampilkan daftar diagnosa sebelumnya lengkap dengan gejala, tingkat keparahan, serta penyesuaian waktu lokal WIB (*Asia/Jakarta*).
- **Pengaturan Profil**: Pengguna dapat memperbarui nama lengkap dan alamat email.
- **Keamanan Kata Sandi**: Fitur ganti kata sandi dengan verifikasi kata sandi lama.
- **Hapus Akun**: Pengguna dapat menghapus akun dan riwayat diagnosa pribadinya secara permanen.

### 5. 🛡️ Dashboard & Control Center Admin (`/admin`)
- **Akses Khusus Administrator**: Proteksi berbasis role (`admin`).
- **Analitik & Metrik Utama**:
  - Total diagnosa masuk (sepanjang waktu dan hari ini).
  - Jumlah pengguna terdaftar.
  - Grafik tren aktivitas diagnosa 30 hari terakhir.
  - Top 4 jenis kerusakan yang paling sering dialami pengguna.
- **Manajemen Riwayat Semua Pengguna**: Tabel riwayat lengkap dengan fitur pencarian dan filter tingkat keparahan (*Sedang*, *Ringan*, *Berat*).
- **Ekspor Laporan**: Mengunduh seluruh riwayat diagnosa ke format CSV dengan satu klik.
- **Tinjauan Basis Pengetahuan & Katalog**: Katalog sparepart dan daftar gejala terintegrasi.

---

## 🧠 Basis Pengetahuan Sistem Pakar (Knowledge Base)

| Kode | Gejala yang Dialami | Kerusakan Terindikasi | Tingkat | Keputusan Penggantian | Estimasi Biaya |
| :---: | :--- | :--- | :---: | :---: | :---: |
| **G01** | Starter elektrik mati / tidak merespon sama sekali | Aki Drop / Lemah (*Battery Failure*) | Sedang | **Kondisional** (Cas dulu) | Rp 150.000 – Rp 250.000 |
| **G02** | Lampu depan redup / klakson lemah saat langsam | Sistem Pengisian / Spul / Kiprok | Sedang | **Tidak** (Servis/cek kabel) | Rp 50.000 – Rp 200.000 |
| **G03** | Mesin ngempos, brebet, tarikan gas kosong | Filter Udara / Injektor / Karbu Kotor | Sedang | **Tidak** (Bersihkan dulu) | Rp 35.000 – Rp 90.000 |
| **G04** | Knalpot berasap putih/hitam, boros bensin | Ring Piston Aus / Sil Klep Bocor | Berat | **Ya** (Wajib ganti) | Rp 200.000 – Rp 600.000+ |
| **G05** | Mesin overheat cepat & ketukan kasar blok silinder | Kehabisan Oli / Piston & Stang Seher Oblak | Berat | **Ya** (Overhaul darurat) | Rp 150.000 – Rp 800.000+ |
| **G06** | Suara berdecit / getaran kasar (*gredek*) awal gas | Kampas Ganda / Rumah CVT Kotor | Ringan | **Tidak** (Servis & grease) | Rp 30.000 – Rp 60.000 |

---

## 🛠️ Arsitektur & Teknologi

- **Backend Framework**: [Laravel 11 / 12](https://laravel.com/) (PHP 8.2+)
- **Database**: SQLite (default lokal) / MySQL (didukung via konfigurasi `.env`)
- **Frontend Core**:
  - Blade Templating Engine
  - [Tailwind CSS](https://tailwindcss.com/) (via CDN)
  - Custom CSS (`public/style.css` untuk antarmuka pengguna & `public/admin.css` untuk panel admin)
  - Vanilla JavaScript ES6+ (`public/app.js` untuk rule engine klien & `public/admin.js` untuk kontrol dashboard)
- **Font & Tipografi**:
  - Antarmuka Utama: *Inter* (Google Fonts)
  - Panel Admin: *DM Sans* & *Manrope* (Google Fonts)

---

## 📁 Struktur Direktori Proyek

```text
motocheck/
├── app/
│   ├── Http/Controllers/
│   │   ├── AccountController.php         # Menampilkan halaman akun pengguna
│   │   ├── AccountSettingsController.php # Update profil, ganti password, & hapus akun
│   │   ├── AdminDashboardController.php  # Dashboard & analitik admin
│   │   ├── AuthController.php            # Autentikasi (login, register, logout)
│   │   └── DiagnosisController.php       # API penyimpanan data diagnosa (/api/diagnoses)
│   ├── Models/
│   │   ├── Diagnosis.php                 # Model data diagnosa
│   │   └── User.php                      # Model data pengguna (role: user / admin)
│   └── Providers/
├── database/
│   ├── migrations/                       # Skema tabel database (users, diagnoses, dll.)
│   └── database.sqlite                   # Berkas database lokal
├── public/
│   ├── admin.css                         # Styling kustom dashboard admin
│   ├── admin.js                          # Logika interaktif admin (filter, chart, ekspor CSV)
│   ├── app.js                            # Logika sistem pakar & navigasi antarmuka utama
│   ├── style.css                         # Styling tema gelap & komponen antarmuka utama
│   └── index.html                        # Berkas antarmuka statis utama
├── resources/
│   └── views/
│       ├── account.blade.php             # Tampilan akun pengguna & riwayat diagnosa
│       ├── admin-dashboard.blade.php     # Tampilan dashboard kontrol admin
│       ├── auth.blade.php                # Tampilan formulir login & registrasi
│       └── welcome.blade.php             # Template alternatif halaman beranda
├── routes/
│   └── web.php                           # Definisi seluruh rute web dan API
├── .env.example                          # Contoh template variabel lingkungan
├── composer.json                         # Dependensi PHP & Laravel
└── README.md                             # Dokumentasi proyek
```

---

## 🚀 Panduan Instalasi & Menjalankan Aplikasi

### Persyaratan Sistem
- **PHP** versi 8.2 atau lebih tinggi (dengan ekstensi `pdo_sqlite` / `pdo_mysql`, `mbstring`, `openssl`).
- **Composer** terinstal di sistem.
- Server lokal seperti **Laragon**, **XAMPP**, atau PHP CLI built-in server.

### Langkah-Langkah Instalasi

1. **Buka Terminal / Command Prompt** dan masuk ke direktori proyek:
   ```bash
   cd c:\laragon\www\motocheck
   ```

2. **Pasang Dependensi Composer**:
   ```bash
   composer install
   ```

3. **Salin Berkas Konfigurasi Lingkungan (`.env`)**:
   ```bash
   copy .env.example .env
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Siapkan Database & Jalankan Migrasi**:
   Jika menggunakan SQLite (default):
   ```bash
   # Buat file database jika belum ada
   type nul > database\database.sqlite

   # Jalankan migrasi tabel
   php artisan migrate
   ```

6. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser di: **`http://127.0.0.1:8000`**

---

## 🔑 Manajemen Akun & Hak Akses

### 1. Akun Pengguna Biasa
- Pengguna dapat mendaftar langsung melalui menu **"Masuk / Daftar"** di halaman utama (`/register`).
- Setiap pendaftaran baru secara otomatis memiliki role **`user`**.

### 2. Akun Administrator
Untuk membuat akun dengan hak akses admin, gunakan **Laravel Tinker**:

```bash
php artisan tinker
```
Lalu jalankan perintah PHP berikut di dalam tinker:
```php
\App\Models\User::create([
    'name' => 'Admin MotoCheck',
    'email' => 'admin@motocheck.id',
    'password' => bcrypt('password123'),
    'role' => 'admin',
]);
exit;
```
Setelah itu, login menggunakan akun tersebut di `/login`. Anda akan otomatis diarahkan ke **Dashboard Admin** di `/admin`.

---

## 🧪 Menjalankan Pengujian (Testing)

Aplikasi telah dilengkapi unit & feature test untuk memastikan seluruh fungsionalitas role, autentikasi, serta logika diagnosa berjalan dengan baik:

```bash
php artisan test
```

---

## 📄 Lisensi

Proyek ini dibuat dan dikembangkan untuk keperluan edukasi dan panduan perawatan kendaraan roda dua secara mandiri. Bebas digunakan dan dikembangkan lebih lanjut.
