# YukiAuction - Sistem Lelang Ikan Online 🐟

Selamat datang di proyek **YukiAuction**. Dokumen ini dirancang untuk membimbing Anda menjalankan proyek ini di komputer lokal Anda, bahkan jika Anda baru pertama kali menggunakan Laravel.

Proyek ini dibangun menggunakan **Laravel 11+**, **Livewire**, dan **Filament PHP** sebagai admin panel.

---

## 📋 Persyaratan Sistem

Sebelum memulai, pastikan komputer Anda sudah terinstall aplikasi berikut:

1.  **Laragon** (Rekomendasi untuk Windows) atau XAMPP.
    - _Catatan Penting_: Proyek ini menggunakan **PostgreSQL** sebagai database, bukan MySQL. Pastikan Laragon Anda sudah mengaktifkan PostgreSQL (Menu -> Tools -> Quick Add -> postgresql).
2.  **Node.js** (Versi LTS terbaru). Download di [nodejs.org](https://nodejs.org/).
3.  **Git** (Untuk mengambil source code).
4.  **Composer** (Biasanya sudah termasuk di Laragon).

---

## 🚀 Langkah Instalasi

Ikuti langkah-langkah berikut secara berurutan:

### 1. Persiapan Folder

Buka terminal (Command Prompt atau PowerShell) dan masuk ke folder `www` Laragon Anda:

```bash
cd C:\laragon\www
# Atau sesuaikan dengan lokasi instalasi Laragon Anda, misal D:\App\laragon\www
```

### 2. Clone Repository (Jika belum ada)

Jika Anda belum memiliki folder proyek ini, jalankan perintah:

```bash
git clone https://github.com/username/yukiauction.git
cd yukiauction
```

_Jika Anda sudah memiliki foldernya, cukup masuk ke foldernya saja (`cd yukiauction`)._

### 3. Install Dependensi PHP

Jalankan perintah ini untuk menginstall semua library PHP yang dibutuhkan:

```bash
composer install
```

### 4. Install Dependensi Frontend

Jalankan perintah ini untuk menginstall library JavaScript:

```bash
npm install
```

### 5. Atur Konfigurasi Environment (.env)

Copy file `.env.example` menjadi `.env`:

- **Cara Manual:** Copy-paste file `.env.example`, lalu rename hasil copy menjadi `.env`.
- **Cara Terminal:**
    ```bash
    copy .env.example .env
    ```

Buka file `.env` dengan teks editor (Notepad, VS Code, dll). **Cari dan ubah bagian Database** agar sesuai dengan PostgreSQL Anda:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=yukiauction
DB_USERNAME=postgres
DB_PASSWORD=root
```

_(Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan settingan PostgreSQL di Laragon Anda. Default Laragon biasanya user: `postgres`, password: `root` atau kosong)._

### 6. Generate Application Key

Jalankan perintah ini agar Laravel membuat kunci enkripsi aplikasi:

```bash
php artisan key:generate
```

### 7. Buat Database

1. Buka **HeidiSQL** (bawaan Laragon) atau **pgAdmin**.
2. Buat database baru dengan nama: `yukiauction`.
    - Pastikan pilih tipe koneksi **PostgreSQL**, bukan MySQL/MariaDB.

### 8. Jalankan Migrasi & Seeding

Ini akan membuat tabel-tabel di database dan mengisi data awal (dummy data):

```bash
php artisan migrate --seed
```

---

## 🏃‍♂️ Menjalankan Aplikasi

Setelah instalasi selesai, Anda perlu menjalankan **dua terminal** secara bersamaan:

### Terminal 1: Menjalankan Server Laravel

```bash
php artisan serve
```

Aplikasi akan bisa diakses di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Terminal 2: Menjalankan Compiling Aset (Vite)

Biarkan terminal ini berjalan agar tampilan website (CSS/JS) muncul dengan benar:

```bash
npm run dev
```

---

## 🔐 Akun Login (Dummy)

Berikut adalah akun yang bisa Anda gunakan untuk mencoba aplikasi:

| Role      | Email                    | Password   |
| :-------- | :----------------------- | :--------- |
| **Admin** | `admin@yukiauction.test` | `12345678` |
| **Buyer** | `buyer@yukiauction.test` | `12345678` |

---

## 🛠 Troubleshooting (Masalah Umum)

- **Masalah: "could not find driver" saat migrate**
    - _Solusi:_ Pastikan ekstensi `pdo_pgsql` dan `pgsql` aktif di `php.ini`.
    - Di Laragon: Klik Kanan -> PHP -> Extensions -> centang `pdo_pgsql` dan `pgsql`.

- **Masalah: Tampilan berantakan / CSS tidak muncul**
    - _Solusi:_ Pastikan perintah `npm run dev` sedang berjalan di terminal terpisah.

- **Masalah: "The application uses the `pgcrypto` extension"**
    - _Solusi:_ Pastikan user database Anda memiliki hak akses `superuser` untuk mengaktifkan ekstensi PostgreSQL ini. User `postgres` bawaan biasanya sudah punya hak ini.

---

Selamat mencoba! Jika ada kendala, silakan hubungi pengembang.
