# 🌱 Bank Sampah - Waste Management System

![PHP Lint Check](https://github.com/dinisft/BANK-SAMPAH/actions/workflows/php-lint.yml/badge.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)
![Status](https://img.shields.io/badge/status-Active-brightgreen)

Sistem manajemen bank sampah berbasis web untuk mendorong kesadaran lingkungan melalui program daur ulang dan penghargaan poin.

## ✨ Fitur Utama

### Untuk Pengguna
- **Setoran Sampah**: Pengguna dapat menginput setoran sampah dengan berbagai jenis (plastik, kertas, kaca, kaleng, organik)
- **Sistem Poin**: Setiap setoran yang diterima akan mendapatkan poin reward
- **Riwayat Transaksi**: Melihat riwayat lengkap setoran dan penarikan
- **Penarikan Poin**: Dapat menarik poin dalam bentuk tunai atau hadiah
- **Dashboard**: Melihat saldo, poin, dan statistik aktivitas

### Untuk Admin
- **Verifikasi Setoran**: Menerima atau menolak setoran dari pengguna
- **Verifikasi Penarikan**: Mengelola permohonan penarikan poin
- **Manajemen Harga**: Mengatur harga per kilogram untuk setiap jenis sampah
- **Manajemen Jadwal**: Mengatur jadwal pengambilan sampah
- **Dashboard Admin**: Melihat statistik dan aktivitas keseluruhan

## 📋 Struktur Database

### Tabel Utama
- **users**: Data pengguna dan admin (nama, email, password, saldo, poin)
- **setoran**: Informasi setoran sampah dengan status dan poin
- **penarikan**: Permintaan penarikan poin pengguna
- **harga_sampah**: Daftar harga untuk setiap jenis sampah
- **jadwal**: Jadwal pengambilan sampah (jika ada)

### Jenis Sampah yang Didukung
- Plastik
- Kertas
- Kaca
- Kaleng
- Organik

## 🔧 Persyaratan Sistem

- **Server**: Apache/Nginx dengan PHP 7.0+
- **Database**: MySQL 5.7+
- **Browser**: Modern browser dengan JavaScript enabled
- **Penyimpanan**: Folder `/uploads/` untuk menyimpan foto setoran

## ✅ GitHub Actions & CI/CD

Repository ini menggunakan GitHub Actions untuk automated testing dan code quality checks:

- **PHP Lint Check**: Memeriksa syntax PHP di setiap push
- **Multi-version Testing**: Diuji dengan PHP 7.4, 8.0, dan 8.1
- **Code Style**: Validasi menggunakan PHPStan dan PSR-2 standard

Status workflow dapat dilihat pada badge di atas README atau di [Actions tab](https://github.com/dinisft/BANK-SAMPAH/actions).

## 🚀 Instalasi

### 1. Setup Database
```bash
# Import file SQL ke database Anda
mysql -u root -p < bank_sampah.sql
```

### 2. Konfigurasi Database
Edit file `config/database.php` sesuaikan dengan konfigurasi server Anda:
```php
$server = "localhost";
$user = "root";
$password = "";
$database = "bank_sampah";
```

### 3. Deploy ke Server
1. Copy seluruh folder ke direktori web server (contoh: `/xampp/htdocs/bank_sampah/`)
2. Pastikan folder `uploads/` memiliki permission write (755 atau 777)
3. Akses aplikasi melalui browser: `http://localhost/bank_sampah/`

## 📱 Penggunaan

### Login Pengguna
1. Buka halaman utama
2. Login dengan username dan password
3. Akses dashboard untuk memulai

### Melakukan Setoran Sampah
1. Masuk ke menu "Setor"
2. Pilih jenis sampah
3. Masukkan berat sampah (kg)
4. Upload foto sampah (opsional)
5. Submit untuk verifikasi admin

### Menarik Poin
1. Masuk ke menu "Tarik"
2. Pilih metode penarikan (tunai/hadiah)
3. Masukkan jumlah poin yang ingin ditarik
4. Tunggu verifikasi dari admin

### Akses Admin
1. Login sebagai admin
2. Akses halaman admin di `/admin/dashboard.php`
3. Kelola verifikasi setoran, penarikan, harga, dan jadwal

## 📁 Struktur Folder

```
bank_sampah/
├── admin/                    # Area admin
│   ├── admin.php            # Dashboard admin
│   ├── kelola_harga.php     # Manajemen harga sampah
│   ├── kelola_jadwal.php    # Manajemen jadwal
│   ├── verifikasi_setoran.php    # Verifikasi setoran
│   └── verifikasi_penarikan.php  # Verifikasi penarikan
├── config/                   # Konfigurasi
│   ├── database.php         # Koneksi database
│   └── Debug.php            # Debug utilities
├── includes/                 # File yang di-include
│   ├── header.php           # Header template
│   └── footer.php           # Footer template
├── uploads/                  # Folder upload gambar
├── index.php                # Halaman login
├── dashboard.php            # Dashboard pengguna
├── setor.php                # Halaman setoran sampah
├── tarik.php                # Halaman penarikan poin
├── riwayat.php              # Riwayat transaksi
├── info.php                 # Informasi harga
├── logout.php               # Logout
├── includes.php             # File include umum
├── konfig_database.php      # Konfigurasi database backup
├── bank_sampah.sql          # File SQL database
└── README.md                # File ini
```

## 🔐 Keamanan

- Password di-hash menggunakan `password_hash()` dan `password_verify()`
- Session management untuk proteksi akses
- Input validation dan SQL injection prevention
- Separasi role (user vs admin)

## 🎨 Teknologi yang Digunakan

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Session Management**: PHP Session

## 📝 Fitur yang Dapat Dikembangkan

- [ ] Sistem notifikasi email
- [ ] Dashboard analytics yang lebih detail
- [ ] Mobile app/responsive design
- [ ] Payment gateway integration
- [ ] QR code untuk tracking setoran
- [ ] Leaderboard pengguna
- [ ] Export laporan ke PDF
- [ ] Multi-bahasa support

## 🤝 Kontribusi

Untuk berkontribusi pada proyek ini:
1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini tersedia di bawah lisensi yang sesuai. Silakan lihat file LICENSE untuk detail.

## 👤 Penulis

**Dinis Fathurahman Tes**  
GitHub: [@dinisft](https://github.com/dinisft)

## 📞 Kontak & Support

Untuk pertanyaan atau saran, silakan buka issue di repository ini atau hubungi melalui GitHub.

---

**Terakhir diperbarui**: 2026-07-06  
Dibuat dengan ❤️ untuk lingkungan yang lebih baik
