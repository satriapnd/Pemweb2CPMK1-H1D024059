#  Sistem Manajemen HR & Payroll (HRIS)

Sistem informasi berbasis web untuk mengelola **absensi karyawan**, **penggajian (payroll) otomatis**, dan **manajemen data staf**.  
Dibangun menggunakan **PHP Native (OOP)** dan **MySQL**.

---

## Fitur Utama

### Otomatisasi Absensi
- Penentuan status otomatis:
  - Tepat Waktu
  - Telat
  - Alpa  
- Berdasarkan jam server secara real-time

###  Manajemen Payroll
- Perhitungan gaji otomatis:
  - Bonus Tepat Waktu
  - Potongan Alpa
  - Upah Lembur (Overtime)

###  Dashboard Multi-Role
- Tampilan berbeda untuk:
  - Admin
  - HR
  - Employee

###  Rekapitulasi Matrix
- Visualisasi kehadiran bulanan dalam bentuk tabel grid
- Khusus untuk Admin

###  Bulk Data Management
- Cascade Delete (hapus data otomatis antar relasi)
- Import data absensi via file CSV

### 🔐 Keamanan
- Proteksi halaman berdasarkan role
- Enkripsi password menggunakan:
  ```php
  password_hash()
