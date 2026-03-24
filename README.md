Sistem Manajemen HR & Payroll (HRIS)
Sistem informasi berbasis web untuk mengelola absensi karyawan, penggajian (payroll) otomatis, dan manajemen data staf. Dibangun menggunakan PHP Native dengan arsitektur OOP dan database MySQL.

✨ Fitur Utama
Otomatisasi Absensi: Penentuan status (Tepat Waktu, Telat, Alpa) berdasarkan jam server secara real-time.

Manajemen Payroll: Kalkulasi gaji otomatis yang menghitung Bonus Tepat Waktu, Potongan Alpa, dan Upah Lembur (Overtime).

Dashboard Multi-Role: Tampilan berbeda untuk Admin, HR, dan Employee.

Rekapitulasi Matrix: Visualisasi kehadiran bulanan seluruh staf dalam satu tabel grid bagi Admin.

Bulk Data Management: Fitur untuk menghapus data secara sinkron (Cascade Delete) dan Import data absensi via file CSV.

Keamanan: Proteksi halaman berdasarkan role dan enkripsi password menggunakan password_hash().

🛠️ Teknologi yang Digunakan
Bahasa Pemrograman: PHP 8.x

Database: MySQL (MariaDB)

Library Koneksi: PDO (PHP Data Objects) untuk keamanan dari SQL Injection.

Frontend: HTML5, CSS3 (Modern UI dengan Shadow & Grid System).

📊 Skema Database
Sistem ini menggunakan relasi antar tabel yang dioptimalkan:

users: Menyimpan data autentikasi (username, email, password, role).

employees: Menyimpan profil detail karyawan (NIK, Jabatan, Gaji Pokok). Terhubung ke tabel users dengan ON DELETE CASCADE.

attendances: Menyimpan log kehadiran harian, jam masuk/keluar, dan jam lembur.

🚀 Cara Instalasi
Clone Repositori

Bash
git clone https://github.com/username/hr-system.git
Konfigurasi Database

Buat database baru bernama hr_db di phpMyAdmin.

Import file database.sql (jika tersedia) atau jalankan query tabel yang ada di dokumentasi.

Sesuaikan konfigurasi koneksi di file Database.php.

Jalankan di Local Server

Pindahkan folder ke C:\xampp\htdocs\.

Buka browser dan akses localhost/hr_system/login.php.

🧪 Simulasi Data
Repositori ini menyertakan sampel data simulasi untuk 13 user dengan berbagai skenario:

Karyawan Teladan: Hadir 30 hari full (Bonus Tepat Waktu).

Karyawan Bermasalah: Sering Alpa & Telat (Potongan Gaji Otomatis).

Karyawan Baru: Data masuk di pertengahan bulan.

Karyawan Lembur: Akumulasi jam kerja di atas jam 17:00.

📄 Lisensi
Proyek ini dibuat untuk tujuan edukasi. Silakan gunakan dan modifikasi sesuai kebutuhan.

Kontak Pengembang:

Nama: [Nama Anda]

NIM: H1D024059
