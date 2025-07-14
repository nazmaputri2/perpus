<h1 align="center">PUSTAKALAYA - Sistem Informasi Perpustakaan </h1>

<h2 align="center">Aplikasi web Laravel untuk sistem perpustakaan yang dapat diakses oleh petugas dan siswa.</h2>


## 👥 TEAM 

- Yulia Nabila 3312411081
- Putri Nazma Lutfia 3312401079
- Muhamad Aulia 3312401074
- Rafif Ruhul Haqq 3312411086

## 📌 Fitur Aplikasi

- Login siswa & petugas
- CRUD Siswa, petugas, Buku
- Peminjaman buku oleh petugas dan siswa
- Persetujuan dan pengelolaan peminjaman oleh petugas
- Statistik peminjaman terbanyak siswa
- Riwayat aktivitas

## 🧑‍💻 Akun default
#### Petugas

- username : petugas
- password : petugas123

#### Siswa

- username : siswa
- password : siswa123

## 💻 Cara Instalasi

 **Clone Repository**
   ```bash
    git clone https://github.com/nazmaputri2/perpus.git
    cd perpus
   ```

   ## Buka Terminal Di kode Editor

**Install Dependensi**
  ```bash
    composer install
    composer require maatwebsite/excel
    composer dump-autoload
   ```
**Storage Link**
```bash
  php artisan storage:link
```

**Copy dan Atur Env**
  ```bash
  copy .env.example 
  ubah file menjadi .env
   ```
## Ubah Konfigurasi database
#### sesuaikan database nya menjadi seperti ini
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sisperpus
DB_USERNAME=root
DB_PASSWORD=
```
**Key Generate**
```bash
  php artisan key:generate
```
## Jalankan Web
```bash
  php artisan serve atau
  composer run dev
  ```
  ##
<h4 align="center">Copyright © 2025 Pustakalaya</h4>
