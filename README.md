# SI-KRONIS

Sistem Informasi Klinik untuk Penanganan Pasien Penyakit Kronis

---

## Apa Itu SI-KRONIS?

SI-KRONIS adalah platform digital untuk mengelola klinik spesialis penyakit kronis (diabetes, jantung, hipertensi, dll). Sistem ini menghubungkan pasien, dokter, perawat, dan admin dalam satu ekosistem.

---

## Fitur Utama

### 👤 Untuk Pasien
- **Booking Konsultasi** - Buat janji dengan dokter pilihan
- **Chat dengan Dokter** - Komunikasi langsung via fitur chat
- **Riwayat Medis** - Lihat semua riwayat konsultasi dan treatment
- **Resep Digital** - Akses resep dari dokter
- **Request Isi Ulang Resep** - Minta obat lanjutan tanpa harus datang
- **Upload Hasil Lab** - Unggah hasil pemeriksaan laboratorium
- **Export PDF Riwayat** - Unduh rekam medis lengkap

### 👨‍⚕️ Untuk Dokter
- **Dashboard Pribadi** - Statistik pasien dan jadwal hari ini
- **Jadwal Praktik** - Atur ketersediaan konsultasi
- **Konsultasi** - Catat anamnesis, diagnosa, dan treatment
- **Resep Digital** - Buat dan kelola resep pasien
- **Chat dengan Pasien** - Balas pesan dari pasien

### 🩺 Untuk Perawat
- **Dashboard** - Overview pasien hari ini
- **Kelola Booking** - Konfirmasi/tolak jadwal konsultasi
- **Upload Hasil Lab** - Input hasil pemeriksaan laboratorium

### ⚙️ Untuk Admin
- **Kelola Pengguna** - Data pasien, dokter, perawat
- **Manajemen Obat** - Database obat klinik
- **Template Resep** - Buat template resep standar
- **Riwayat Medis** - Lihat rekam medis semua pasien
- **Laporan** - Statistik klinik

---

## Akun Demo

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sikronis.com | password |
| Dokter | ahmad.hidayat@sikronis.com | password |
| Perawat | andi.wijaya@sikronis.com | password |
| Pasien | (bisa register sendiri) | - |

---

## Cara Menggunakan

### Login
1. Buka halaman login
2. Pilih role (pasien/register jika belum punya akun)
3. Login dengan email & password

### Pasien Baru
1. Klik "Register"
2. Isi data diri (nama, email, password)
3. Login dan mulai gunakan fitur

### Booking Konsultasi
1. Pilih menu "Konsultasi"
2. Pilih dokter dan jadwal yang tersedia
3. Isi keluhan singkat
4. Tunggu konfirmasi dari perawat

### Chat dengan Dokter
1. Pilih menu "Chat"
2. Pilih dokter yang ingin dikontak
3. Ketik pesan dan kirim

---

## Teknologi

- **Backend:** Laravel 12 (PHP 8.2+)
- **Database:** MySQL
- **Frontend:** Bootstrap 5 + Blade Templates
- **PDF:** DomPDF
- **Excel:** Maatwebsite Excel

---

## Instalasi (Developer)

```bash
# Clone repository
git clone <repo-url>
cd si-kronis

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate --seed

# Run server
php artisan serve
```

---

## Struktur Menu

```
Pasien:
├── Dashboard
├── Konsultasi (Booking)
├── Riwayat (Treatment + Export PDF)
├── Resep (+ Request Refill)
├── Chat dengan Dokter
└── Profil

Dokter:
├── Dashboard
├── Jadwal Praktik
├── Konsultasi
├── Resep
└── Chat Pasien

Perawat:
├── Dashboard
├── Booking
└── Lab

Admin:
├── Dashboard
├── Data Pasien
├── Data Dokter
├── Semua Konsultasi
├── Obat
├── Template Resep
├── Riwayat Medis
└── Laporan
```

---

## Catatan Penting

- Semua password default adalah `password` (ubah setelah login)
- Pasien harus menunggu konfirmasi booking dari perawat
- Resep hanya bisa di-refill setelah dokter menyetujui
- Chat berfungsi 2 arah antara pasien dan dokter
- Export PDF riwayat medis semua data konsultasi, resep, dan hasil lab

---

&copy; 2026 SI-KRONIS - Sistem Informasi Klinik Kronis
