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


