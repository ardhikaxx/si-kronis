<!-- LOGO & HEADER -->
<div align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <br><br>
  <h1>🏥 SI-KRONIS</h1>
  <p><i>Sistem Informasi Klinik untuk Penanganan Pasien Penyakit Kronis</i></p>
</div>

---

## 📋 Deskripsi

**SI-KRONIS** adalah platform digital terintegrasi untuk mengelola klinik spesialis penyakit kronis seperti diabetes, jantung, hipertensi, dan lainnya. Sistem ini menghubungkan pasien, dokter, perawat, dan admin dalam satu ekosistem yang efisien.

### 🔑 Fitur Unggulan
| Fitur | Deskripsi |
|--------|-----------|
| 🗓️ Booking Online | Jadwalkan konsultasi dengan dokter pilihan |
| 💬 Chat Langsung | Komunikasi real-time antara pasien dan dokter |
| 📄 Resep Digital | Kelola resep secara paperless |
| 🔄 Request Refill | Minta obat lanjutan tanpa datang ke klinik |
| 📊 Rekam Medis | Riwayat lengkap treatment pasien |
| 📥 Export PDF | Unduh rekam medis kapan saja |

---

## 👥 Untuk Siapa?

### 👤 Pasien
```
┌─────────────────────────────────────────────────────────────┐
│  • Booking Konsultasi        • Chat dengan Dokter          │
│  • Riwayat Medis             • Resep Digital               │
│  • Request Isi Ulang Resep   • Upload Hasil Lab           │
│  • Export PDF Riwayat        • Profil Pribadi             │
└─────────────────────────────────────────────────────────────┘
```

### 👨‍⚕️ Dokter
```
┌─────────────────────────────────────────────────────────────┐
│  • Dashboard Statistik        • Jadwal Praktik             │
│  • Kelola Konsultasi         • Resep Digital              │
│  • Chat dengan Pasien        • Template Resep            │
└─────────────────────────────────────────────────────────────┘
```

### 🩺 Perawat
```
┌─────────────────────────────────────────────────────────────┐
│  • Dashboard Overview         • Kelola Booking            │
│  • Konfirmasi/Tolak Jadwal    • Upload Hasil Lab          │
└─────────────────────────────────────────────────────────────┘
```

### ⚙️ Admin
```
┌─────────────────────────────────────────────────────────────┐
│  • Kelola Pengguna            • Manajemen Obat             │
│  • Template Resep             • Riwayat Medis             │
│  • Laporan Statistik         • Semua Konsultasi           │
└─────────────────────────────────────────────────────────────┘
```

---

## 🔐 Akun Demo

| Role | Email | Password | Aksi |
|------|-------|----------|------|
| 🛡️ Admin | `admin@sikronis.com` | `password` | [Login](#) |
| 👨‍⚕️ Dokter | `ahmad.hidayat@sikronis.com` | `password` | [Login](#) |
| 🩺 Perawat | `andi.wijaya@sikronis.com` | `password` | [Login](#) |
| 👤 Pasien | Register sendiri | `password` | [Register](#) |

> 💡 **Tips:** Semua password dapat diganti setelah login.

---

## 🚀 Cara Menggunakan

### 1. Login
```
Buka halaman login → Pilih role → Masukkan email & password
```

### 2. Pasien Baru
```
Register → Isi data diri → Login → Mulai gunakan fitur
```

### 3. Booking Konsultasi
```
Menu Konsultasi → Pilih Dokter → Pilih Jadwal → Isi Keluhan → Tunggu Konfirmasi
```

### 4. Chat dengan Dokter
```
Menu Chat → Pilih Dokter → Ketik Pesan → Kirim
```

---

## 🛠️ Teknologi

<div align="center">

| Teknologi | Badge |
|-----------|-------|
| **Laravel 12** | ![Laravel](https://img.shields.io/badge/Laravel-12.x-red) |
| **PHP 8.2+** | ![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4) |
| **MySQL** | ![MySQL](https://img.shields.io/badge/MySQL-4479A1) |
| **Bootstrap 5** | ![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3) |
| **DomPDF** | ![DomPDF](https://img.shields.io/badge/DomPDF-1.0-green) |
| **Maatwebsite Excel** | ![Excel](https://img.shields.io/badge/Excel-3.1-green) |

</div>

---

## 💻 Instalasi

```bash
# Clone repository
git clone https://github.com/ardhikaxx/si-kronis.git
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

## 📂 Struktur Menu

```
┌──────────────────────────────────────────────────────────────┐
│  PASIEN                    │  DOKTER                         │
├────────────────────────────┼────────────────────────────────┤
│  📊 Dashboard              │  📊 Dashboard                  │
│  🗓️ Konsultasi            │  📅 Jadwal Praktik             │
│  📄 Riwayat               │  🩺 Konsultasi                 │
│  💊 Resep                  │  💊 Resep Digital              │
│  💬 Chat                   │  💬 Chat Pasien                 │
│  👤 Profil                 │                                │
├────────────────────────────┼────────────────────────────────┤
│  PERAWAT                   │  ADMIN                         │
├────────────────────────────┼────────────────────────────────┤
│  📊 Dashboard              │  📊 Dashboard                  │
│  ✅ Booking                │  👥 Data Pasien                 │
│  🧪 Lab                   │  👨‍⚕️ Data Dokter               │
│                            │  💊 Obat                       │
│                            │  📝 Template Resep             │
│                            │  📄 Riwayat Medis              │
│                            │  📈 Laporan                    │
└────────────────────────────┴────────────────────────────────┘
```

---

## ⚠️ Catatan Penting

- 🔑 **Password Default:** `password` (ubah setelah login)
- ⏳ **Konfirmasi Booking:** Pasien harus menunggu konfirmasi dari perawat
- ✅ **Refill Resep:** Hanya bisa setelah dokter menyetujui
- 💬 **Chat:** Berfungsi 2 arah (pasien ↔ dokter)
- 📥 **Export PDF:** Meng包含 semua data konsultasi, resep, dan hasil lab

---

## 📄 Lisensi

MIT License - Copyright © 2026 SI-KRONIS

---

<div align="center">
  <p>Dibuat dengan ❤️ untuk kesehatan Indonesia</p>
  <p><strong>SI-KRONIS</strong> - Sistem Informasi Rekam Medis Klinik Kronis</p>
</div>
