<div align="center">

# 📚 Sistem Informasi Perpustakaan

### Tugas Pelatihan Sertifikasi Kampus

Sistem informasi perpustakaan berbasis **Laravel 11** yang mendukung pengelolaan buku, peminjaman, pengembalian, presensi mahasiswa, serta dashboard analitik untuk administrator.

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap_5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?style=for-the-badge&logo=chartdotjs&logoColor=white)

</div>

---

# 📖 Tentang Project

Project ini merupakan **tugas pelatihan sertifikasi** yang menjadi salah satu **syarat kelulusan di kampus**.

Aplikasi dikembangkan menggunakan **Laravel 11** dengan konsep **Role Based Access Control (RBAC)** sehingga terdapat dua jenis pengguna, yaitu **Admin** dan **Mahasiswa**.

Selain mengelola koleksi buku dan transaksi peminjaman, sistem ini juga menyediakan fitur **presensi kunjungan mahasiswa**, dashboard analitik menggunakan **Chart.js**, laporan cetak, hingga peminjaman buku secara mandiri melalui katalog online.

Project ini menjadi media pembelajaran yang memperdalam pemahaman mengenai:

- Laravel 11
- Authentication & Authorization
- Middleware
- CRUD Management
- Relasi Database
- Dashboard Analytics
- Upload File & Webcam Capture
- Reporting System
- Role Based Access Control (RBAC)

---
## 🖥️Tampilan 

<img width="1920" height="1080" alt="Screenshot 2026-08-07 091015" src="https://github.com/user-attachments/assets/4e860018-3db4-4c35-8292-78deabc22658" />

<img width="1920" height="1080" alt="Screenshot 2026-08-07 090848" src="https://github.com/user-attachments/assets/5212ee96-7bbc-47aa-9f1f-c435aa67b830" />


# ✨ Fitur Utama

## 👨‍💼 Panel Admin

- Dashboard Statistik
- CRUD Data Buku
- CRUD Data User
- Manajemen Peminjaman
- Pengembalian Buku
- Perhitungan Denda Otomatis
- Monitoring Presensi Mahasiswa
- Cetak Laporan
- Grafik Peminjaman
- Grafik Kunjungan
- Ranking Buku Terpopuler

---

## 🎓 Panel Mahasiswa

- Dashboard Mahasiswa
- Katalog Buku
- Pencarian Buku
- Peminjaman Buku Mandiri
- Riwayat Peminjaman
- Riwayat Presensi
- Check In Kunjungan
- Check Out Kunjungan
- Upload Foto Presensi
- Live Webcam Capture

---

# 🔐 Sistem Role

### Admin

- Mengelola seluruh sistem
- Mengelola pengguna
- Mengelola buku
- Mengelola peminjaman
- Melihat laporan
- Dashboard statistik

### Mahasiswa

- Registrasi akun
- Login
- Melihat katalog
- Meminjam buku
- Presensi kunjungan
- Melihat riwayat

---

# 📊 Dashboard

Dashboard Admin menampilkan informasi seperti:

- Total Mahasiswa
- Total Buku
- Buku Tersedia
- Peminjaman Aktif
- Grafik Kunjungan 7 Hari
- Grafik Peminjaman 6 Bulan
- Top 5 Buku Terpopuler
- Mahasiswa yang Sedang Berkunjung

---

# 📷 Presensi Mahasiswa

Sistem presensi mendukung dua metode dokumentasi:

- 📸 Upload Foto
- 🎥 Live Webcam Capture menggunakan HTML5 Camera API

---

# 📚 Manajemen Buku

Fitur yang tersedia:

- Tambah Buku
- Edit Buku
- Hapus Buku
- Cetak Katalog
- Monitoring Stok
- Kategori Buku

---

# 🔄 Manajemen Peminjaman

- Peminjaman Buku
- Pengembalian Buku
- Update Stok Otomatis
- Denda Keterlambatan
- Riwayat Transaksi
- Cetak Laporan

---

# 🖨️ Reporting

Laporan yang dapat dicetak:

- Laporan Buku
- Laporan Peminjaman
- Laporan Pengembalian
- Laporan Presensi Mahasiswa

---

# 🛠️ Teknologi

- Laravel 11
- PHP 8.2+
- MySQL / MariaDB
- Bootstrap 5
- Blade Template
- Chart.js
- Font Awesome
- Plus Jakarta Sans

---

# 🚀 Instalasi

Clone repository

```bash
git clone https://github.com/username/perpustakaan-app.git
```

Masuk folder project

```bash
cd perpustakaan-app
```

Install dependency

```bash
composer install
```

Copy file environment

```bash
cp .env.example .env
```

Generate key

```bash
php artisan key:generate
```

Atur konfigurasi database pada file `.env`

```env
DB_DATABASE=perpustakaan_db
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migrasi

```bash
php artisan migrate --seed
```

Jalankan server

```bash
php artisan serve
```

---

# 📂 Struktur Modul

```
Admin
├── Dashboard
├── User
├── Buku
├── Peminjaman
├── Kunjungan
└── Laporan

Mahasiswa
├── Dashboard
├── Katalog Buku
├── Peminjaman
├── Presensi
└── Riwayat
```

---

# 🎯 Pengembangan Selanjutnya

Beberapa fitur yang direncanakan:

- QR Code Kartu Anggota
- QR Code Scanner Buku
- WhatsApp Reminder
- Email Notification
- Export Excel
- Export PDF
- Payment Gateway QRIS
- Digital Library (E-Book)
- Approval Workflow
- Progressive Web App (PWA)
- Laravel Reverb (Realtime)
- Redis Cache
- AI Book Recommendation
- Cloud Storage (Amazon S3 / Supabase)

---

# 📚 Yang Saya Pelajari

Melalui project ini saya mempelajari banyak konsep penting dalam pengembangan aplikasi menggunakan Laravel, seperti:

- Arsitektur MVC
- Middleware
- Authentication
- Authorization
- RBAC
- CRUD Kompleks
- Query Builder & Eloquent ORM
- File Upload
- Webcam Integration
- Reporting
- Dashboard Analytics
- Relasi Database
- Validasi Form
- Pengelolaan Stok Buku
- Perhitungan Denda

Project ini menjadi salah satu pengalaman yang sangat berharga karena dikerjakan sebagai bagian dari **pelatihan sertifikasi** sekaligus **persiapan menuju kelulusan di kampus**.

---

# 👨‍💻 Author

**Daffa Rahman Saputra**

GitHub

https://github.com/daffarsp

---

⭐ Jika repository ini bermanfaat, jangan lupa berikan **Star**.
