# Sistem Inventaris Barang

Aplikasi web untuk mengelola inventaris barang dengan fitur stock management, barang masuk, dan barang keluar.

## Fitur Utama

- **Manajemen Stock Barang**: Menambah, mengedit, dan menghapus data barang
- **Barang Masuk**: Mencatat barang yang masuk ke inventory
- **Barang Keluar**: Mencatat barang yang keluar dari inventory
- **Sistem Login**: Autentikasi pengguna untuk akses sistem
- **Dashboard Responsif**: Interface yang user-friendly dengan Bootstrap

## Teknologi yang Digunakan

- **Backend**: PHP 7.4+
- **Database**: MySQL
- **Frontend**: HTML5, CSS3, Bootstrap 4
- **JavaScript**: jQuery, Chart.js
- **Icons**: Font Awesome
- **DataTables**: Simple DataTables untuk tampilan tabel

## Struktur Database

### Tabel `stock`
- `idbarang` (Primary Key)
- `namabarang` (VARCHAR)
- `deskripsi` (TEXT)
- `stock` (INT)

### Tabel `masuk`
- `idmasuk` (Primary Key)
- `idbarang` (Foreign Key)
- `tanggal` (DATETIME)
- `keterangan` (VARCHAR)
- `qty` (INT)

### Tabel `keluar`
- `idkeluar` (Primary Key)
- `idbarang` (Foreign Key)
- `tanggal` (DATETIME)
- `penerima` (VARCHAR)
- `qty` (INT)

### Tabel `login`
- `email` (VARCHAR)
- `password` (VARCHAR)

## Instalasi

1. **Persiapan Server**
   - Pastikan PHP 7.4+ dan MySQL sudah terinstall
   - Aktifkan ekstensi mysqli

2. **Database Setup**
   ```sql
   CREATE DATABASE stokbarang;
   ```

3. **Konfigurasi Database**
   - Edit file `function.php` pada bagian koneksi database:
   ```php
   $conn = mysqli_connect("localhost","root","", "stokbarang");
   ```

4. **Buat Tabel Database**
   ```sql
   -- Tabel stock
   CREATE TABLE stock (
       idbarang INT PRIMARY KEY AUTO_INCREMENT,
       namabarang VARCHAR(255) NOT NULL,
       deskripsi TEXT,
       stock INT DEFAULT 0
   );

   -- Tabel masuk
   CREATE TABLE masuk (
       idmasuk INT PRIMARY KEY AUTO_INCREMENT,
       idbarang INT,
       tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
       keterangan VARCHAR(255),
       qty INT,
       FOREIGN KEY (idbarang) REFERENCES stock(idbarang)
   );

   -- Tabel keluar
   CREATE TABLE keluar (
       idkeluar INT PRIMARY KEY AUTO_INCREMENT,
       idbarang INT,
       tanggal DATETIME DEFAULT CURRENT_TIMESTAMP,
       penerima VARCHAR(255),
       qty INT,
       FOREIGN KEY (idbarang) REFERENCES stock(idbarang)
   );

   -- Tabel login
   CREATE TABLE login (
       email VARCHAR(255) PRIMARY KEY,
       password VARCHAR(255) NOT NULL
   );
   ```

5. **Upload File**
   - Upload semua file ke web server (htdocs untuk XAMPP)

6. **Buat Akun Login**
   ```sql
   INSERT INTO login (email, password) VALUES ('admin@example.com', 'password123');
   ```

## Struktur File

```
├── index.php          # Halaman utama - manajemen stock
├── masuk.php          # Halaman barang masuk
├── keluar.php         # Halaman barang keluar
├── login.php          # Halaman login
├── logout.php         # Logout handler
├── function.php       # Fungsi-fungsi PHP dan koneksi database
├── cek.php           # Middleware untuk cek session
└── css/
    └── styles.css    # Custom styling
```

## Penggunaan

1. **Login**
   - Akses `login.php`
   - Masukkan email dan password
   - Setelah berhasil login, akan diarahkan ke dashboard

2. **Manajemen Stock**
   - Tambah barang baru dengan nama, deskripsi, dan stock awal
   - Edit informasi barang yang sudah ada
   - Hapus barang dari inventory

3. **Barang Masuk**
   - Pilih barang dari dropdown
   - Masukkan jumlah yang masuk
   - Tambahkan keterangan
   - Stock akan otomatis bertambah

4. **Barang Keluar**
   - Pilih barang dari dropdown
   - Masukkan jumlah yang keluar
   - Tentukan penerima
   - Stock akan otomatis berkurang

## Fitur Keamanan

- **Session Management**: Sistem login dengan session PHP
- **Access Control**: Halaman terlindungi dengan middleware `cek.php`
- **SQL Injection Protection**: Menggunakan prepared statements (perlu diperbaiki)

## Catatan Penting

⚠️ **Keamanan**: Kode ini masih menggunakan query SQL langsung yang rentan terhadap SQL injection. Untuk production, disarankan menggunakan prepared statements.

⚠️ **Password**: Password disimpan dalam plain text. Untuk production, gunakan hashing seperti `password_hash()`.

## Pengembangan Lebih Lanjut

- [ ] Implementasi prepared statements
- [ ] Hash password dengan bcrypt
- [ ] Validasi input yang lebih ketat
- [ ] Sistem role dan permission
- [ ] Export data ke Excel/PDF
- [ ] Backup dan restore database
- [ ] Notifikasi stock minimum
- [ ] Histori perubahan stock

## Kontribusi

Proyek ini dibuat oleh **Kelompok 1 Tubes Basda**.

## Lisensi

Proyek ini dibuat untuk keperluan tugas dan pembelajaran.
