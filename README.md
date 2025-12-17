# Pengingat Gaji Berkala

Aplikasi Laravel untuk mengelola periode gaji berkala pegawai dengan fitur lengkap.

## 🚀 Fitur

- **Manajemen Periode** - CRUD operations untuk data periode gaji
- **Status Indikator** - Proses (> 4 bulan), Segera (4 bulan), Deadline (≤ 2 bulan)
- **Excel Import/Export** - Import dan export data menggunakan Laravel Excel
- **Soft Delete** - Sembunyikan data tanpa menghapus permanen
- **Advanced Filtering** - Filter berdasarkan nama dan tanggal
- **Dark Mode** - Tema gelap/terang dengan Flux Laravel
- **Responsive Design** - Tampilan mobile-friendly dengan Tailwind CSS
- **User Authentication** - Login/register dengan Laravel Fortify

## 📋 Persyaratan

- PHP 8.2+
- Composer
- SQLite/MySQL Database
- Node.js & NPM (untuk assets)

## 🛠️ Instalasi

1. **Clone repository**
```bash
git clone https://github.com/xFqmT/Pengingat-Gaji-Berkala.git
cd Pengingat-Gaji-Berkala
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Setup database**
```bash
php artisan migrate
```

5. **Build assets**
```bash
npm run build
```

6. **Start server**
```bash
php artisan serve
```

## ⚙️ Konfigurasi

### Database
Edit file `.env` untuk setup database: 

```env
DB_CONNECTION=sqlite
# Atau gunakan MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=pengingat_gaji_berkala
# DB_USERNAME=root
# DB_PASSWORD=
```

### Aplikasi
```env
APP_NAME="Pengingat Gaji Berkala"
APP_URL=http://localhost:8000
```

## 📊 Penggunaan

### Menambah Data
1. Klik tombol "Tambah Data"
2. Isi nama pegawai dan tanggal awal periode
3. Tanggal akhir akan dihitung otomatis (+2 tahun)

### Import Excel
1. Klik "Import Excel"
2. Download template yang tersedia
3. Isi data sesuai format
4. Upload file Excel

### Status Periode
- 🟢 **Proses** - Lebih dari 4 bulan sebelum deadline
- 🟡 **Segera** - 4 bulan sebelum deadline  
- 🔴 **Deadline** - 2 bulan atau kurang sebelum deadline

### Filter Data
Gunakan filter di bagian atas untuk:
- Pencarian berdasarkan nama
- Filter berdasarkan tanggal awal
- Filter berdasarkan tanggal akhir

## 🗂️ Struktur File

```
├── app/
│   ├── Http/Controllers/
│   │   └── PeriodController.php
│   └── Models/
│       ├── Period.php
│       └── User.php
├── resources/views/
│   ├── dashboard.blade.php
│   └── periods/
│       ├── create.blade.php
│       ├── edit.blade.php
│       └── import.blade.php
└── database/
    ├── migrations/
    └── factories/
```

## 🔄 Status Logic

Sistem menggunakan logika berikut untuk status periode:

```php
$monthsLeft = intdiv($daysLeft, 30);

if ($monthsLeft > 4) {
    $status = 'Proses';      // Hijau
} elseif ($monthsLeft > 2) {
    $status = 'Segera';     // Kuning  
} else {
    $status = 'Deadline';   // Merah
}
```

## 🛡️ Keamanan

- Password hashing dengan Bcrypt
- CSRF protection
- Input validation
- SQL injection prevention
- Soft delete untuk data protection

## 🎨 Tema

Aplikasi menggunakan:
- **Flux Laravel Theme** - Modern dan clean
- **Tailwind CSS** - Utility-first CSS framework  
- **Zinc Color Palette** - Konsisten untuk dark/light mode
- **Dark Mode Support** - Otomatis mengikuti sistem

## 📝 License

Project ini untuk keperluan internal Bapperida.

## 🤝 Kontributor

Tim Pengembang Bapperida

---

**Note:** File `.env` tidak diinclude di repository untuk alasan keamanan. Gunakan `.env.example` sebagai template.
