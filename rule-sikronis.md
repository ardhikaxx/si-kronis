# 📋 RULE & BLUEPRINT — SI-KRONIS
## Sistem Informasi Layanan Konsultasi Penyakit Kronis

> **Stack:** Laravel 12 · Bootstrap 5 (CDN) · Custom CSS · Font Awesome 6 (CDN)  
> **Versi:** 1.0.0 | Dibuat untuk pengembangan terstruktur dan konsisten

---

## 1. IDENTITAS SISTEM

| Atribut | Detail |
|---|---|
| Nama Sistem | SI-KRONIS |
| Kepanjangan | Sistem Informasi Layanan Konsultasi Penyakit Kronis |
| Framework | Laravel 12 |
| PHP Version | >= 8.2 |
| Database | MySQL 8.x |
| Styling | Bootstrap 5.3 CDN + Custom CSS |
| Icon | Font Awesome 6 Free CDN |
| Auth | Spatie Laravel-Permission |

---

## 2. CDN RESOURCES (wajib di semua layout)

```html
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome 6 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
```

---

## 3. STRUKTUR ROLE & AKSES

### 3.1 Role yang Tersedia

| Role | Slug | Deskripsi |
|---|---|---|
| Pasien | `pasien` | Pengguna umum / penderita penyakit kronis |
| Admin | `admin` | Administrator sistem |
| Dokter | `dokter` | Dokter spesialis yang memberikan konsultasi |
| Perawat | `perawat` | Tenaga kesehatan pendukung |

### 3.2 Matriks Hak Akses (Permissions)

| Permission | Pasien | Perawat | Dokter | Admin |
|---|:---:|:---:|:---:|:---:|
| dashboard.pasien | ✅ | ❌ | ❌ | ❌ |
| dashboard.admin | ❌ | ✅ | ✅ | ✅ |
| konsultasi.booking | ✅ | ❌ | ❌ | ✅ |
| konsultasi.manage | ❌ | ✅ | ✅ | ✅ |
| dokter.manage | ❌ | ❌ | ❌ | ✅ |
| resep.create | ❌ | ❌ | ✅ | ✅ |
| resep.view | ✅ | ✅ | ✅ | ✅ |
| lab.upload | ✅ | ✅ | ❌ | ✅ |
| lab.review | ❌ | ✅ | ✅ | ✅ |
| user.manage | ❌ | ❌ | ❌ | ✅ |
| laporan.view | ❌ | ❌ | ✅ | ✅ |

---

## 4. DESAIN LAYOUT & TAMPILAN

### 4.1 Layout Pasien — Mobile-First (App-Like)

**Konsep:** Tampilan seperti aplikasi mobile dengan navigasi bottom tab.

```
┌─────────────────────────────┐
│  🏥 SI-KRONIS        🔔 👤  │  ← Top Header (fixed)
├─────────────────────────────┤
│                             │
│      [CONTENT AREA]         │
│                             │
│                             │
│                             │
├─────────────────────────────┤
│  🏠     📅     💊     👤   │  ← Bottom Navigation (fixed)
│ Home  Jadwal  Resep  Profil │
└─────────────────────────────┘
```

**Spesifikasi Layout Pasien:**
- Max-width container: `480px` (mobile feel di desktop)
- Background body: `#f0f4f8`
- Top header: `fixed-top`, height `56px`, warna primary
- Bottom nav: `fixed-bottom`, height `64px`, background white, shadow atas
- Content area: `padding-top: 70px`, `padding-bottom: 80px`
- Font: sistem sans-serif, clean

**Bottom Navigation Items:**

| Icon | Label | Route |
|---|---|---|
| `fa-house` | Beranda | `pasien.dashboard` |
| `fa-calendar-check` | Konsultasi | `pasien.konsultasi` |
| `fa-file-medical` | Riwayat | `pasien.riwayat` |
| `fa-pills` | Resep | `pasien.resep` |
| `fa-user-circle` | Profil | `pasien.profil` |

**File Layout:** `resources/views/layouts/pasien.blade.php`

---

### 4.2 Layout Admin/Dokter/Perawat — Dashboard System

**Konsep:** Tampilan sistem dashboard dengan sidebar, header, dan konten.

```
┌──────────┬──────────────────────────────────────┐
│          │  🔔 Notifikasi    Admin ▼             │  ← Header (fixed-top)
│          ├──────────────────────────────────────┤
│          │                                      │
│ SIDEBAR  │         [MAIN CONTENT]               │
│ (fixed)  │                                      │
│          │                                      │
│          │                                      │
│          │                                      │
└──────────┴──────────────────────────────────────┘
```

**Spesifikasi Layout Admin:**
- Sidebar width: `260px` (desktop) / collapsible di mobile
- Sidebar background: `#1a2035` (dark navy)
- Sidebar text: `#a0aec0`, active: `#ffffff`
- Header height: `60px`, background: `#ffffff`, shadow bawah
- Main content: `margin-left: 260px`, `padding: 24px`
- Sidebar item hover: `background: rgba(255,255,255,0.1)`, left-border accent

**Sidebar Menu — Admin:**
```
📊 Dashboard
── Manajemen Pengguna
   👥 Data Pasien
   👨‍⚕️ Data Dokter
   🏥 Data Perawat
── Konsultasi
   📅 Jadwal Konsultasi
   📋 Semua Konsultasi
── Master Data
   🏷️ Kategori Penyakit
   💊 Obat-obatan
   🔬 Panel Lab
── Laporan
   📈 Statistik
   📄 Export Data
── Pengaturan
   ⚙️ Konfigurasi
```

**Sidebar Menu — Dokter:**
```
📊 Dashboard
── Konsultasi
   📅 Jadwal Saya
   📋 Antrian Hari Ini
   🕐 Riwayat Konsultasi
── Pasien
   👥 Daftar Pasien Saya
   📁 Rekam Medis
── Resep
   💊 Tulis Resep
   📜 Riwayat Resep
── Laporan
   📊 Statistik Konsultasi
```

**Sidebar Menu — Perawat:**
```
📊 Dashboard
── Konsultasi
   📅 Jadwal Hari Ini
   ✅ Konfirmasi Booking
── Pasien
   👥 Data Pasien
   🔬 Upload Hasil Lab
── Resep
   📜 Daftar Resep
── Profil
   👤 Data Diri
```

**File Layout:** `resources/views/layouts/admin.blade.php`

---

## 5. STRUKTUR DATABASE & TABEL

### 5.1 ERD Overview

```
users ──────────────┬── user_profiles
  │                 └── role (via spatie)
  │
  ├── [sebagai pasien] ──── bookings ──── consultations ──── prescriptions
  │                              │                 │
  │                              │                 └── prescription_items
  │                              └── lab_results
  │
  ├── [sebagai dokter] ─── doctor_profiles
  │                              └── doctor_schedules
  │
  └── [sebagai perawat] ── nurse_profiles
```

---

### 5.2 Detail Tabel

#### `users`
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- name              VARCHAR(100) NOT NULL
- email             VARCHAR(150) UNIQUE NOT NULL
- email_verified_at TIMESTAMP NULL
- password          VARCHAR(255) NOT NULL
- phone             VARCHAR(20) NULL
- avatar            VARCHAR(255) NULL
- is_active         TINYINT(1) DEFAULT 1
- remember_token    VARCHAR(100)
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `user_profiles` (untuk data pasien)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- user_id           BIGINT UNSIGNED FK → users.id (CASCADE DELETE)
- nik               VARCHAR(20) UNIQUE NULL
- tanggal_lahir     DATE NULL
- jenis_kelamin     ENUM('L','P') NULL
- golongan_darah    ENUM('A','B','AB','O') NULL
- alamat            TEXT NULL
- kota              VARCHAR(100) NULL
- provinsi          VARCHAR(100) NULL
- kode_pos          VARCHAR(10) NULL
- bpjs_number       VARCHAR(30) NULL
- emergency_contact VARCHAR(100) NULL
- emergency_phone   VARCHAR(20) NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `doctor_profiles`
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- user_id           BIGINT UNSIGNED FK → users.id (CASCADE DELETE)
- nip               VARCHAR(30) UNIQUE NULL
- str_number        VARCHAR(50) NULL         -- Surat Tanda Registrasi
- spesialisasi      VARCHAR(100) NULL
- sub_spesialisasi  VARCHAR(100) NULL
- pendidikan        VARCHAR(255) NULL
- pengalaman_tahun  INT DEFAULT 0
- biaya_konsultasi  DECIMAL(10,2) DEFAULT 0
- tentang           TEXT NULL
- rating            DECIMAL(3,2) DEFAULT 0.00
- total_konsultasi  INT DEFAULT 0
- is_available      TINYINT(1) DEFAULT 1
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `nurse_profiles`
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- user_id           BIGINT UNSIGNED FK → users.id (CASCADE DELETE)
- nip               VARCHAR(30) UNIQUE NULL
- str_number        VARCHAR(50) NULL
- spesialisasi      VARCHAR(100) NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `chronic_categories` (kategori penyakit kronis)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- nama              VARCHAR(100) NOT NULL
- slug              VARCHAR(120) UNIQUE NOT NULL
- deskripsi         TEXT NULL
- icon              VARCHAR(100) NULL       -- font awesome class
- warna             VARCHAR(20) DEFAULT '#007bff'
- is_active         TINYINT(1) DEFAULT 1
- created_at        TIMESTAMP
- updated_at        TIMESTAMP

-- Contoh data:
-- Diabetes Melitus, Hipertensi, Penyakit Jantung, Asma, Gagal Ginjal, dll.
```

---

#### `patient_chronic_conditions` (pasien bisa punya banyak penyakit kronis)
```sql
- id                    BIGINT UNSIGNED PK AUTO_INCREMENT
- user_id               BIGINT UNSIGNED FK → users.id
- chronic_category_id   BIGINT UNSIGNED FK → chronic_categories.id
- diagnosed_at          DATE NULL
- catatan               TEXT NULL
- created_at            TIMESTAMP
- updated_at            TIMESTAMP

-- UNIQUE(user_id, chronic_category_id)
```

---

#### `doctor_schedules` (jadwal praktik dokter)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- doctor_id         BIGINT UNSIGNED FK → users.id
- hari              ENUM('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu')
- jam_mulai         TIME NOT NULL
- jam_selesai       TIME NOT NULL
- kuota             INT DEFAULT 10          -- maks pasien per sesi
- is_active         TINYINT(1) DEFAULT 1
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `doctor_leave` (cuti / tidak praktik)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- doctor_id         BIGINT UNSIGNED FK → users.id
- tanggal_mulai     DATE NOT NULL
- tanggal_selesai   DATE NOT NULL
- alasan            TEXT NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `bookings` (pemesanan konsultasi)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- kode_booking      VARCHAR(20) UNIQUE NOT NULL    -- format: BK-YYYYMMDD-XXXX
- patient_id        BIGINT UNSIGNED FK → users.id
- doctor_id         BIGINT UNSIGNED FK → users.id
- tanggal_konsultasi DATE NOT NULL
- jam_mulai         TIME NOT NULL
- jam_selesai       TIME NOT NULL
- keluhan           TEXT NOT NULL
- chronic_category_id BIGINT UNSIGNED FK → chronic_categories.id NULL
- tipe_konsultasi   ENUM('online','offline') DEFAULT 'online'
- status            ENUM('pending','confirmed','cancelled','completed','no_show') DEFAULT 'pending'
- catatan_pasien    TEXT NULL
- catatan_admin     TEXT NULL
- confirmed_by      BIGINT UNSIGNED FK → users.id NULL  -- perawat/admin yang konfirmasi
- confirmed_at      TIMESTAMP NULL
- cancelled_by      BIGINT UNSIGNED FK → users.id NULL
- cancelled_at      TIMESTAMP NULL
- alasan_batal      TEXT NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `consultations` (detail sesi konsultasi)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- booking_id        BIGINT UNSIGNED FK → bookings.id (CASCADE DELETE) UNIQUE
- patient_id        BIGINT UNSIGNED FK → users.id
- doctor_id         BIGINT UNSIGNED FK → users.id
- tanggal           DATE NOT NULL
- mulai_at          DATETIME NULL
- selesai_at        DATETIME NULL
- anamnesis         TEXT NULL              -- keluhan subjektif
- pemeriksaan_fisik TEXT NULL
- tekanan_darah     VARCHAR(20) NULL       -- contoh: 120/80
- berat_badan       DECIMAL(5,2) NULL      -- kg
- tinggi_badan      DECIMAL(5,2) NULL      -- cm
- suhu_tubuh        DECIMAL(4,1) NULL      -- celcius
- saturasi_o2       INT NULL               -- %
- gula_darah        DECIMAL(6,2) NULL      -- mg/dL
- diagnosa          TEXT NULL
- icd_code          VARCHAR(20) NULL       -- kode ICD-10
- rencana_terapi    TEXT NULL
- saran_dokter      TEXT NULL
- tindak_lanjut     ENUM('none','kontrol','rujukan','rawat_inap') DEFAULT 'none'
- tanggal_kontrol   DATE NULL
- status            ENUM('ongoing','completed') DEFAULT 'ongoing'
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `lab_results` (hasil laboratorium)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- patient_id        BIGINT UNSIGNED FK → users.id
- booking_id        BIGINT UNSIGNED FK → bookings.id NULL
- consultation_id   BIGINT UNSIGNED FK → consultations.id NULL
- nama_lab          VARCHAR(150) NOT NULL
- tanggal_lab       DATE NOT NULL
- file_path         VARCHAR(255) NOT NULL   -- path file PDF/JPG
- file_name         VARCHAR(255) NOT NULL
- file_size         INT NULL               -- bytes
- mime_type         VARCHAR(100) NULL
- catatan           TEXT NULL
- is_reviewed       TINYINT(1) DEFAULT 0
- reviewed_by       BIGINT UNSIGNED FK → users.id NULL
- reviewed_at       TIMESTAMP NULL
- catatan_review    TEXT NULL
- uploaded_by       BIGINT UNSIGNED FK → users.id
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `medicines` (master obat)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- kode              VARCHAR(30) UNIQUE NOT NULL
- nama              VARCHAR(200) NOT NULL
- nama_generik      VARCHAR(200) NULL
- kategori          VARCHAR(100) NULL
- satuan            VARCHAR(50) DEFAULT 'Tablet'  -- Tablet, Kapsul, mL, dll
- deskripsi         TEXT NULL
- kontraindikasi    TEXT NULL
- efek_samping      TEXT NULL
- is_active         TINYINT(1) DEFAULT 1
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `prescriptions` (resep digital)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- kode_resep        VARCHAR(20) UNIQUE NOT NULL   -- format: RX-YYYYMMDD-XXXX
- consultation_id   BIGINT UNSIGNED FK → consultations.id
- patient_id        BIGINT UNSIGNED FK → users.id
- doctor_id         BIGINT UNSIGNED FK → users.id
- tanggal_resep     DATE NOT NULL
- catatan_umum      TEXT NULL                     -- contoh: minum setelah makan
- status            ENUM('draft','issued','dispensed','cancelled') DEFAULT 'issued'
- dispensed_by      BIGINT UNSIGNED FK → users.id NULL  -- perawat yang menyiapkan
- dispensed_at      TIMESTAMP NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `prescription_items` (detail item resep)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- prescription_id   BIGINT UNSIGNED FK → prescriptions.id (CASCADE DELETE)
- medicine_id       BIGINT UNSIGNED FK → medicines.id NULL
- nama_obat         VARCHAR(200) NOT NULL          -- bisa manual jika tidak di master
- dosis             VARCHAR(100) NOT NULL           -- contoh: 500mg
- frekuensi         VARCHAR(100) NOT NULL           -- contoh: 3x sehari
- durasi            VARCHAR(100) NULL               -- contoh: 7 hari
- jumlah            INT NOT NULL DEFAULT 1
- instruksi         TEXT NULL                       -- contoh: diminum setelah makan
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `notifications` (notifikasi sistem)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- user_id           BIGINT UNSIGNED FK → users.id
- type              VARCHAR(100) NOT NULL           -- booking.confirmed, resep.issued, dll
- title             VARCHAR(200) NOT NULL
- message           TEXT NOT NULL
- data              JSON NULL                       -- payload tambahan
- is_read           TINYINT(1) DEFAULT 0
- read_at           TIMESTAMP NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `ratings` (penilaian konsultasi oleh pasien)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- consultation_id   BIGINT UNSIGNED FK → consultations.id UNIQUE
- patient_id        BIGINT UNSIGNED FK → users.id
- doctor_id         BIGINT UNSIGNED FK → users.id
- skor              TINYINT NOT NULL               -- 1-5
- ulasan            TEXT NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

#### `activity_logs` (audit trail)
```sql
- id                BIGINT UNSIGNED PK AUTO_INCREMENT
- user_id           BIGINT UNSIGNED FK → users.id NULL
- action            VARCHAR(100) NOT NULL
- model_type        VARCHAR(100) NULL              -- App\Models\Booking
- model_id          BIGINT UNSIGNED NULL
- description       TEXT NULL
- old_values        JSON NULL
- new_values        JSON NULL
- ip_address        VARCHAR(50) NULL
- user_agent        TEXT NULL
- created_at        TIMESTAMP
- updated_at        TIMESTAMP
```

---

### 5.3 Relasi Antar Tabel (Summary)

```
users (1) ──────────── (1) user_profiles
users (1) ──────────── (1) doctor_profiles
users (1) ──────────── (1) nurse_profiles
users (1) ──────────── (M) patient_chronic_conditions
users (1) ──────────── (M) doctor_schedules        [sebagai dokter]
users (1) ──────────── (M) doctor_leave            [sebagai dokter]
users (1) ──────────── (M) bookings                [sebagai pasien]
users (1) ──────────── (M) bookings                [sebagai dokter]
users (1) ──────────── (M) consultations           [sebagai pasien]
users (1) ──────────── (M) consultations           [sebagai dokter]
users (1) ──────────── (M) lab_results             [sebagai pasien]
users (1) ──────────── (M) prescriptions           [sebagai pasien]
users (1) ──────────── (M) prescriptions           [sebagai dokter]
users (1) ──────────── (M) notifications
users (1) ──────────── (M) ratings                 [sebagai pasien atau dokter]

chronic_categories (1) ── (M) patient_chronic_conditions
chronic_categories (1) ── (M) bookings

bookings (1) ──────────── (1) consultations
bookings (1) ──────────── (M) lab_results

consultations (1) ──────── (1) prescriptions
consultations (1) ──────── (M) lab_results
consultations (1) ──────── (1) ratings

prescriptions (1) ──────── (M) prescription_items
medicines (1) ──────────── (M) prescription_items
```

---

## 6. STRUKTUR DIREKTORI LARAVEL

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── UserController.php
│   │   │   ├── DokterController.php
│   │   │   ├── KonsultasiController.php
│   │   │   └── LaporanController.php
│   │   ├── Dokter/
│   │   │   ├── DashboardController.php
│   │   │   ├── KonsultasiController.php
│   │   │   └── ResepController.php
│   │   ├── Perawat/
│   │   │   ├── DashboardController.php
│   │   │   └── BookingController.php
│   │   └── Pasien/
│   │       ├── DashboardController.php
│   │       ├── BookingController.php
│   │       ├── RiwayatController.php
│   │       ├── ResepController.php
│   │       └── ProfilController.php
│   └── Middleware/
│       └── CheckRole.php
├── Models/
│   ├── User.php
│   ├── UserProfile.php
│   ├── DoctorProfile.php
│   ├── NurseProfile.php
│   ├── ChronicCategory.php
│   ├── PatientChronicCondition.php
│   ├── DoctorSchedule.php
│   ├── DoctorLeave.php
│   ├── Booking.php
│   ├── Consultation.php
│   ├── LabResult.php
│   ├── Medicine.php
│   ├── Prescription.php
│   ├── PrescriptionItem.php
│   ├── Notification.php
│   ├── Rating.php
│   └── ActivityLog.php
└── Services/
    ├── BookingService.php
    ├── NotificationService.php
    └── ResepService.php

resources/views/
├── layouts/
│   ├── pasien.blade.php        ← Mobile-app layout
│   ├── admin.blade.php         ← Dashboard admin/dokter/perawat layout
│   └── auth.blade.php          ← Halaman login/register
├── pasien/
│   ├── dashboard.blade.php
│   ├── konsultasi/
│   │   ├── index.blade.php
│   │   ├── booking.blade.php
│   │   └── detail.blade.php
│   ├── riwayat/
│   ├── resep/
│   └── profil/
├── admin/
│   ├── dashboard.blade.php
│   ├── users/
│   ├── dokter/
│   ├── konsultasi/
│   └── laporan/
├── dokter/
│   ├── dashboard.blade.php
│   ├── konsultasi/
│   └── resep/
└── perawat/
    ├── dashboard.blade.php
    └── booking/

public/
└── assets/
    ├── css/
    │   ├── sikronis.css        ← Custom global styles
    │   ├── pasien.css          ← Mobile-app styles
    │   └── admin.css           ← Dashboard styles
    └── js/
        └── sikronis.js
```

---

## 7. ROUTING CONVENTION

```php
// routes/web.php

// Auth routes (login, register, logout)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Pasien routes
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
    Route::get('/dashboard', [Pasien\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('konsultasi', Pasien\BookingController::class);
    Route::get('/riwayat', [Pasien\RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/resep', [Pasien\ResepController::class, 'index'])->name('resep');
    Route::get('/profil', [Pasien\ProfilController::class, 'index'])->name('profil');
    Route::put('/profil', [Pasien\ProfilController::class, 'update'])->name('profil.update');
    Route::post('/lab/upload', [Pasien\LabController::class, 'upload'])->name('lab.upload');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', Admin\UserController::class);
    Route::resource('dokter', Admin\DokterController::class);
    Route::resource('konsultasi', Admin\KonsultasiController::class);
    Route::resource('obat', Admin\ObatController::class);
    Route::get('/laporan', [Admin\LaporanController::class, 'index'])->name('laporan');
});

// Dokter routes
Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->name('dokter.')->group(function () {
    Route::get('/dashboard', [Dokter\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/jadwal', [Dokter\JadwalController::class, 'index'])->name('jadwal');
    Route::get('/konsultasi', [Dokter\KonsultasiController::class, 'index'])->name('konsultasi');
    Route::put('/konsultasi/{id}', [Dokter\KonsultasiController::class, 'update'])->name('konsultasi.update');
    Route::resource('resep', Dokter\ResepController::class);
});

// Perawat routes
Route::middleware(['auth', 'role:perawat'])->prefix('perawat')->name('perawat.')->group(function () {
    Route::get('/dashboard', [Perawat\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/booking', [Perawat\BookingController::class, 'index'])->name('booking');
    Route::put('/booking/{id}/confirm', [Perawat\BookingController::class, 'confirm'])->name('booking.confirm');
    Route::post('/lab/upload', [Perawat\LabController::class, 'upload'])->name('lab.upload');
});

// Redirect setelah login berdasarkan role
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->getRoleNames()->first();
        return match($role) {
            'pasien'  => redirect()->route('pasien.dashboard'),
            'admin'   => redirect()->route('admin.dashboard'),
            'dokter'  => redirect()->route('dokter.dashboard'),
            'perawat' => redirect()->route('perawat.dashboard'),
            default   => redirect()->route('login'),
        };
    }
    return redirect()->route('login');
});
```

---

## 8. CUSTOM CSS GUIDELINES

### 8.1 Color Palette SI-KRONIS

```css
/* resources/views/css/sikronis.css */
:root {
  /* Primary Colors */
  --sk-primary:       #2563eb;   /* Biru utama */
  --sk-primary-dark:  #1d4ed8;
  --sk-primary-light: #dbeafe;

  /* Secondary */
  --sk-secondary:     #10b981;   /* Hijau kesehatan */
  --sk-secondary-dark:#059669;

  /* Danger / Alert */
  --sk-danger:        #ef4444;
  --sk-warning:       #f59e0b;
  --sk-success:       #10b981;
  --sk-info:          #06b6d4;

  /* Neutral */
  --sk-dark:          #1a2035;   /* Sidebar */
  --sk-gray-100:      #f3f4f6;
  --sk-gray-200:      #e5e7eb;
  --sk-gray-500:      #6b7280;
  --sk-gray-900:      #111827;

  /* Penyakit Kronis Colors */
  --sk-diabetes:      #f59e0b;
  --sk-hipertensi:    #ef4444;
  --sk-jantung:       #ec4899;
  --sk-asma:          #06b6d4;
  --sk-ginjal:        #8b5cf6;
}
```

### 8.2 Komponen Mobile (Pasien)

```css
/* pasien.css */
body.pasien-layout {
  background-color: #f0f4f8;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Mobile container */
.sk-mobile-container {
  max-width: 480px;
  margin: 0 auto;
  min-height: 100vh;
  background: #ffffff;
  position: relative;
}

/* Bottom Navigation */
.sk-bottom-nav {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 100%;
  max-width: 480px;
  height: 64px;
  background: #ffffff;
  border-top: 1px solid #e5e7eb;
  box-shadow: 0 -4px 16px rgba(0,0,0,0.08);
  display: flex;
  align-items: center;
  justify-content: space-around;
  z-index: 1000;
}

.sk-bottom-nav .nav-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 3px;
  color: #9ca3af;
  font-size: 10px;
  font-weight: 500;
  text-decoration: none;
  padding: 8px 12px;
  border-radius: 12px;
  transition: all 0.2s;
}

.sk-bottom-nav .nav-item i {
  font-size: 20px;
}

.sk-bottom-nav .nav-item.active {
  color: var(--sk-primary);
}

.sk-bottom-nav .nav-item.active i {
  transform: translateY(-2px);
}

/* Card pasien */
.sk-card {
  border-radius: 16px;
  border: none;
  box-shadow: 0 2px 12px rgba(0,0,0,0.06);
  overflow: hidden;
}

/* Status badge booking */
.badge-pending    { background: #fef3c7; color: #92400e; }
.badge-confirmed  { background: #d1fae5; color: #065f46; }
.badge-completed  { background: #dbeafe; color: #1e40af; }
.badge-cancelled  { background: #fee2e2; color: #991b1b; }
```

### 8.3 Komponen Admin/Dashboard

```css
/* admin.css */

/* Sidebar */
.sk-sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  width: 260px;
  background: var(--sk-dark);
  overflow-y: auto;
  z-index: 1040;
  transition: transform 0.3s ease;
}

.sk-sidebar-brand {
  padding: 20px 24px;
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.sk-sidebar-brand .brand-text {
  color: #ffffff;
  font-size: 18px;
  font-weight: 700;
  letter-spacing: 0.5px;
}

.sk-sidebar-brand .brand-sub {
  color: rgba(255,255,255,0.4);
  font-size: 11px;
}

.sk-sidebar-menu {
  padding: 16px 0;
}

.sk-sidebar-label {
  color: rgba(255,255,255,0.3);
  font-size: 10px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 1.5px;
  padding: 16px 24px 8px;
}

.sk-sidebar-link {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 24px;
  color: rgba(255,255,255,0.6);
  text-decoration: none;
  font-size: 14px;
  transition: all 0.2s;
  border-left: 3px solid transparent;
}

.sk-sidebar-link:hover,
.sk-sidebar-link.active {
  background: rgba(255,255,255,0.08);
  color: #ffffff;
  border-left-color: var(--sk-primary);
}

.sk-sidebar-link i {
  width: 20px;
  text-align: center;
  font-size: 15px;
}

/* Main Content */
.sk-main-content {
  margin-left: 260px;
  min-height: 100vh;
  background: #f8fafc;
}

/* Header */
.sk-header {
  height: 60px;
  background: #ffffff;
  border-bottom: 1px solid #e5e7eb;
  box-shadow: 0 1px 4px rgba(0,0,0,0.04);
  display: flex;
  align-items: center;
  padding: 0 24px;
  position: sticky;
  top: 0;
  z-index: 1030;
}

/* Stats Card */
.sk-stat-card {
  border-radius: 12px;
  border: none;
  padding: 20px;
  position: relative;
  overflow: hidden;
}

.sk-stat-card .stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
}

/* Responsive: collapse sidebar on mobile */
@media (max-width: 991px) {
  .sk-sidebar {
    transform: translateX(-100%);
  }
  .sk-sidebar.show {
    transform: translateX(0);
  }
  .sk-main-content {
    margin-left: 0;
  }
}
```

---

## 9. KONVENSI KODE

### 9.1 Naming Convention

| Komponen | Konvensi | Contoh |
|---|---|---|
| Controller | PascalCase + Controller | `BookingController` |
| Model | PascalCase | `DoctorProfile` |
| Migration | snake_case + timestamp | `create_bookings_table` |
| View | kebab-case | `booking-detail.blade.php` |
| Route name | dot-notation | `pasien.booking.store` |
| CSS class | prefix `sk-` | `sk-card`, `sk-sidebar` |
| Variable PHP | camelCase | `$doctorProfile` |
| DB column | snake_case | `tanggal_konsultasi` |

### 9.2 Blade Layout Usage

```blade
{{-- Layout Pasien --}}
@extends('layouts.pasien')
@section('title', 'Dashboard')
@section('active', 'dashboard')
@section('content')
  {{-- konten --}}
@endsection

{{-- Layout Admin/Dokter/Perawat --}}
@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('content')
  {{-- konten --}}
@endsection
```

### 9.3 Kode Unik Otomatis

```php
// Kode Booking: BK-YYYYMMDD-XXXX
Booking::create([
    'kode_booking' => 'BK-' . now()->format('Ymd') . '-' . str_pad(Booking::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT),
    ...
]);

// Kode Resep: RX-YYYYMMDD-XXXX
```

---

## 10. FITUR UTAMA & ALUR

### 10.1 Booking Konsultasi (Pasien)

```
Pasien pilih dokter → Pilih tanggal & jam (cek slot tersedia)
→ Isi keluhan → Upload hasil lab (opsional)
→ Submit booking [status: pending]
→ Perawat konfirmasi [status: confirmed]
→ Notifikasi ke pasien
→ Sesi konsultasi [status: completed]
→ Dokter input diagnosa & resep
```

### 10.2 Upload Hasil Lab

- Formats: PDF, JPG, PNG, JPEG
- Max size: 5 MB per file
- Multiple file per booking diperbolehkan
- Disimpan di `storage/app/lab-results/{user_id}/`

### 10.3 Resep Digital

- Hanya dokter yang bisa membuat resep
- Terhubung ke sesi konsultasi
- Bisa berisi obat dari master (`medicines`) atau manual
- Status: `issued` → `dispensed` (oleh perawat)
- Pasien bisa lihat & download

---

## 11. SEEDER & INITIAL DATA

```php
// database/seeders/DatabaseSeeder.php
// Urutan seeder:
1. RoleSeeder         → buat roles: admin, dokter, perawat, pasien
2. AdminSeeder        → buat akun admin@sikronis.id
3. ChronicCategorySeeder → Diabetes, Hipertensi, Jantung, Asma, Gagal Ginjal
4. MedicineSeeder     → Data obat-obatan umum
5. DemoUserSeeder     → demo: dokter, perawat, pasien (opsional)
```

### Akun Demo Default:

| Role | Email | Password |
|---|---|---|
| Admin | admin@sikronis.id | Admin@12345 |
| Dokter | dr.dewi@sikronis.id | Dokter@12345 |
| Perawat | perawat1@sikronis.id | Perawat@12345 |
| Pasien | pasien@sikronis.id | Pasien@12345 |

---

## 12. VALIDASI PENTING

```php
// Booking Validation
'tanggal_konsultasi' => 'required|date|after:today',
'doctor_id'          => 'required|exists:users,id',
'keluhan'            => 'required|min:20|max:1000',
'jam_mulai'          => 'required|date_format:H:i',

// Lab Upload
'file'               => 'required|mimes:pdf,jpg,jpeg,png|max:5120',

// Resep
'medicine_id'        => 'nullable|exists:medicines,id',
'nama_obat'          => 'required|max:200',
'dosis'              => 'required|max:100',
'frekuensi'          => 'required|max:100',
'jumlah'             => 'required|integer|min:1',
```

---

## 13. PACKAGE YANG DIREKOMENDASIKAN

```bash
# Wajib
composer require spatie/laravel-permission      # Role & Permission
composer require intervention/image-laravel      # Resize gambar/avatar
composer require barryvdh/laravel-dompdf         # Export PDF resep

# Opsional
composer require maatwebsite/excel               # Export laporan Excel
composer require davejamesmiller/laravel-breadcrumbs # Breadcrumbs admin
```

---

## 14. ENVIRONMENT VARIABLES

```env
APP_NAME="SI-KRONIS"
APP_URL=http://localhost

DB_DATABASE=si_kronis
DB_USERNAME=root
DB_PASSWORD=

# File Upload
FILESYSTEM_DISK=local
MAX_LAB_FILE_SIZE=5120

# Mail (untuk notifikasi)
MAIL_MAILER=smtp
MAIL_FROM_ADDRESS=noreply@sikronis.id
MAIL_FROM_NAME="SI-KRONIS"
```

---

## 15. CHECKLIST PENGEMBANGAN

### Phase 1 — Setup & Auth
- [ ] Install Laravel 12, konfigurasi `.env`
- [ ] Install Spatie Permission
- [ ] Buat semua migration & jalankan seeder
- [ ] Buat layout `pasien.blade.php` (mobile)
- [ ] Buat layout `admin.blade.php` (dashboard)
- [ ] Setup auth (login, register, logout)
- [ ] Middleware role-based redirect

### Phase 2 — Modul Pasien
- [ ] Dashboard pasien (kondisi kronis, jadwal, riwayat)
- [ ] Booking konsultasi + pilih dokter
- [ ] Upload hasil lab
- [ ] Riwayat konsultasi
- [ ] Lihat resep digital
- [ ] Edit profil

### Phase 3 — Modul Tenaga Kesehatan
- [ ] Dashboard dokter (antrian, statistik)
- [ ] Input diagnosa & catatan konsultasi
- [ ] Buat resep digital
- [ ] Kelola jadwal praktik
- [ ] Dashboard perawat
- [ ] Konfirmasi booking

### Phase 4 — Modul Admin
- [ ] Dashboard admin (statistik sistem)
- [ ] CRUD data pengguna (pasien, dokter, perawat)
- [ ] Manajemen konsultasi
- [ ] Master data (obat, kategori penyakit)
- [ ] Laporan & export

### Phase 5 — Fitur Tambahan
- [ ] Sistem notifikasi in-app
- [ ] Rating & ulasan konsultasi
- [ ] Export PDF resep
- [ ] Pencarian dokter berdasarkan spesialisasi
- [ ] Filter riwayat konsultasi
- [ ] Activity log

---

*SI-KRONIS Rule File v1.0.0 — Dibuat sebagai panduan pengembangan sistem*
