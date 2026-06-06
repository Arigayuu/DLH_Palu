# Sistem Pelaporan Pohon & Monitoring Armada DLH Kota Palu

Sistem layanan berbasis web untuk Dinas Lingkungan Hidup Kota Palu yang menyediakan pelaporan kondisi pohon oleh masyarakat, pelacakan status laporan, survei Indeks Kepuasan Masyarakat (IKM), serta monitoring armada sampah secara real-time.

---

## Fitur

### Pelaporan Pohon

* **Laporan Publik** — Masyarakat dapat melaporkan kondisi pohon melalui formulir online.
* **Upload Foto** — Mendukung unggah foto sebagai bukti kondisi pohon.
* **Tiket Otomatis** — Sistem menghasilkan nomor tiket unik untuk setiap laporan.
* **Tracking Status** — Pelapor dapat memantau progres penanganan menggunakan nomor tiket.

### Monitoring Armada

* **Pelacakan Real-Time** — Menampilkan posisi armada sampah yang sedang aktif.
* **Peta Interaktif** — Menggunakan Leaflet untuk visualisasi lokasi armada.
* **GPS Integration** — Data armada tersimpan pada cache GPS kendaraan.

### Survei IKM

* **Indeks Kepuasan Masyarakat** — Survei pelayanan DLH Kota Palu.
* **7 Indikator Penilaian** — Meliputi prosedur, kecepatan pelayanan, biaya, sarana prasarana, kompetensi petugas, penanganan pengaduan, dan hasil layanan.
* **Analisis Statistik** — Dashboard menampilkan distribusi dan tren nilai IKM.
* **Export Data** — Hasil survei dapat diekspor ke Excel.

### Manajemen Admin

* **Dashboard Monitoring** — Ringkasan laporan dan statistik layanan.
* **Manajemen Laporan** — Verifikasi, penolakan, dan penyelesaian laporan masyarakat.
* **Audit & Monitoring** — Pemantauan seluruh aktivitas layanan.
* **Dashboard IKM** — Analisis hasil survei kepuasan masyarakat.

---

## Stack

| Layer            | Technology           |
| ---------------- | -------------------- |
| Backend          | Laravel 13, PHP 8.4+ |
| Admin Panel      | Filament v3            |
| Frontend         | Blade, Livewire v3     |
| CSS              | Tailwind CSS         |
| Database         | MySQL                |
| Mapping          | Leaflet.js           |
| Export Data      | Laravel Excel        |
| PDF              | DomPDF               |
| Image Processing | Intervention Image   |

---

## Instalasi

### Prasyarat

* PHP 8.4+
* Composer
* Node.js 22+
* MySQL

### Setup Cepat

```bash
git clone <repo-url>
cd DLH_Palu

composer setup
composer run dev
```

Buka:

```text
http://localhost:8000
```

---

### Setup Manual

```bash
composer install

cp .env.example .env

php artisan key:generate
```

Sesuaikan konfigurasi database pada file `.env`:

```env
DB_DATABASE=dlh_palu
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi:

```bash
php artisan migrate
```

Install dependency frontend:

```bash
npm install
npm run build
```

Jalankan aplikasi:

```bash
composer run dev
```

---

## Halaman Publik

| URL      | Fungsi                     |
| -------- | -------------------------- |
| /        | Beranda                    |
| /lapor   | Form laporan kondisi pohon |
| /lacak   | Pelacakan status laporan   |
| /survei  | Survei IKM                 |
| /armada  | Monitoring armada sampah   |
| /tentang | Informasi DLH Kota Palu    |

---

## Modul Sistem

### Laporan Pohon

Menyimpan data laporan masyarakat:

* Nomor tiket otomatis
* Nomor telepon pelapor
* Kategori laporan
* Deskripsi laporan
* Lokasi GPS (latitude & longitude)
* Status penanganan
* Bukti foto laporan
* Bukti penyelesaian

Status laporan:

```text
Menunggu Verifikasi
Diproses
Ditolak
Selesai
```

### Survei IKM

Terdiri dari 7 indikator:

1. Prosedur dan Persyaratan
2. Kecepatan Waktu Petugas
3. Biaya dan Tarif
4. Kualitas Sarana dan Prasarana
5. Kompetensi dan Perilaku Petugas
6. Penanganan Pengaduan
7. Hasil Layanan

Sistem menghitung nilai rata-rata secara otomatis untuk setiap respon.

### Tracking Armada

Data armada diperoleh dari tabel:

```text
gps_vehicle_cache
```

Fitur:

* Menampilkan armada aktif
* Posisi GPS terkini
* Integrasi peta Leaflet
* Monitoring operasional armada sampah

---

## Struktur Proyek

```text
app/
├── Console/
│   └── Commands/
│       └── FetchGpsData.php
├── Exports/
│   └── IkmResponseExport.php
├── Filament/
│   ├── Pages/
│   │   ├── Dashboard.php
│   │   ├── DashboardIkm.php
│   │   └── TrackingArmada.php
│   ├── Resources/
│   │   ├── Laporans/
│   │   └── IkmResponses/
│   └── Widgets/
│       ├── IkmBarChart.php
│       ├── IkmDistributionWidget.php
│       ├── IkmStatsOverview.php
│       ├── IkmTrendChart.php
│       └── TrackingMapWidget.php
├── Models/
│   ├── Laporan.php
│   ├── LaporanFoto.php
│   ├── IkmResponse.php
│   ├── GpsVehicleCache.php
│   └── User.php

database/
├── migrations/
├── factories/
└── seeders/

resources/
├── views/
│   ├── public/
│   │   ├── lapor.blade.php
│   │   ├── lacak.blade.php
│   │   ├── survei.blade.php
│   │   ├── armada.blade.php
│   │   └── tentang.blade.php
│   └── layouts/
```

---

## Perintah Penting

### Development

```bash
composer run dev
```

Menjalankan:

* Laravel Server
* Queue Listener
* Laravel Pail
* Vite Dev Server

### Build

```bash
npm run build
```

### Database

```bash
php artisan migrate
```

```bash
php artisan migrate:fresh
```

### Testing

```bash
php artisan test
```

### GPS Armada

```bash
php artisan fetch:gps-data
```

*(sesuaikan dengan nama command jika telah didaftarkan pada aplikasi)*

---

## Dashboard Filament

Panel administrator digunakan untuk:

* Mengelola laporan masyarakat
* Memverifikasi laporan
* Memantau statistik layanan
* Mengelola hasil survei IKM
* Melihat lokasi armada secara real-time
* Mengekspor data survei

---

## Kontribusi

1. Buat branch baru dari branch utama.
2. Lakukan perubahan yang diperlukan.
3. Commit dengan pesan yang jelas.
4. Push ke repository.
5. Buat Pull Request.

---

## Lisensi

Proyek ini dikembangkan untuk kebutuhan layanan Dinas Lingkungan Hidup Kota Palu.

---


## Tim Pengembang (Developers)

Sistem ini dirancang dan diimplementasikan oleh tim mahasiswa Jurusan Teknologi Informasi, Fakultas Teknik, Universitas Tadulako:

*Aditya Zaldy — F55123027
*Sapto Mart Saputra Wicaksono — F2123028 
*Andi Moh. Rafli — F52123029  
*Zaky Putra Safandra — F55123011  
*Fahril Antonio Hande — F55123031  
*I Wayan Arigayu Saputra — F55123044
