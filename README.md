# AuraRoutine: System Management Morning & Night Routine Tracker

**AuraRoutine** adalah aplikasi web praktikum berbasis PHP Native OOP yang dirancang untuk membantu pengguna mengelola, memantau, dan membangun rutinitas harian (*Morning Routine* & *Night Routine*). Aplikasi ini dibangun dengan arsitektur Pemrograman Berorientasi Objek (OOP), MySQL, dan Tailwind CSS tanpa dependensi *framework* PHP eksternal.

## Janji

> Saya **\[Nama Lengkap Kamu\]** dengan NIM **\[NIM Kamu\]** mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain Pemrograman Berbasis Objek untuk keberkahan-Nya maka saya tidak melakukan kecurangan seperti yang dispesifikasikan. Aamiin.

## Tema Website

Tema aplikasi adalah **Self-Upgrade & Daily Routine Tracker** yang membagi fokus harian ke dalam dua suasana:

1. **Morning Routine (Nuansa Amber/Warm):** Berisi kegiatan positif awal hari seperti merendam muka dengan air dingin (*Ice Water Face Dip*), olahraga harian yang bervariasi per hari, membaca buku *self-development*, hingga menyiapkan sarapan nutrisi.

2. **Night Routine (Nuansa Indigo/Cool):** Berisi kegiatan refleksi dan relaksasi sebelum tidur seperti *skincare routine*, *journaling & self-reflection*, membaca buku fiksi/filosofi, serta *digital detox*.

**Tampilan & Interface:**

* Menggunakan tema warna ganda modern (*Dual Mood: Amber & Indigo*) pada latar belakang gelap (*Dark Slate Mode*).

* Form tambah dan edit terintegrasi secara dinamis di halaman data.

* Tabel data responsif dan dapat digulir secara horizontal pada layar kecil.

## Teknologi dan Struktur Folder

### Teknologi yang Digunakan

* **PHP 8.0+** (PHP Native berbasis OOP & Prepared Statement).

* **MySQL / MariaDB** (`mysqli` dengan *prepared statement*).

* **HTML5, Tailwind CSS (via CDN), FontAwesome Icons**.

### Struktur Folder Proyek

```
TP7DPBO2526C_DailyRoutine/
│
├── config/
│   └── Database.php       # Class OOP untuk koneksi MySQL dengan Prepared Statement
│
├── classes/
│   ├── Category.php       # Model & Controller Class Entitas Kategori (CRUD)
│   ├── Routine.php        # Model & Controller Class Entitas Rutinitas (CRUD + Relasi FK)
│   └── RoutineLog.php     # Model & Controller Class Entitas Log Aktivitas (CRUD + Relasi FK)
│
├── views/
│   ├── header.php         # Layout Header, Meta Tag, & Navigasi Utama Responsif
│   └── footer.php         # Layout Footer Aplikasi
│
├── db_daily_routine.sql   # Skema struktur tabel database & data awal (dummy data)
├── index.php              # Dashboard Utama (Hero Card & Ringkasan Rutinitas)
├── categories.php         # Halaman Pengelolaan Kategori Utama
├── routines.php           # Halaman Pengelolaan Daftar Rutinitas
├── logs.php               # Halaman Catatan Log & Riwayat Aktivitas Harian
└── README.md              # Dokumentasi Alur Proyek

```

## Database

Database bernama **`db_daily_routine`**. Sistem ini terdiri dari 3 entitas tabel yang berelasi:

| Tabel | Kolom Utama | Keterangan & Relasi | 
| ----- | ----- | ----- | 
| **`categories`** | `id`, `name`, `description`, `theme_color` | Entitas Master Kategori (*Morning Routine* & *Night Routine*). | 
| **`routines`** | `id`, `category_id`, `title`, `description`, `day_of_week`, `target_duration_minutes` | Entitas Master Rutinitas. Memiliki Foreign Key `category_id` yang mengarah ke `categories.id` (`ON DELETE CASCADE`). | 
| **`routine_logs`** | `id`, `routine_id`, `log_date`, `status`, `notes` | Entitas Log Aktivitas Pengerjaan. Memiliki Foreign Key `routine_id` yang mengarah ke `routines.id` (`ON DELETE CASCADE`). | 

## Aturan Bisnis & Validasi Alur Program

1. **Keamanan Query:** Seluruh operasi database (*Create, Read, Update, Delete*) pada class `Category`, `Routine`, dan `RoutineLog` **wajib** menggunakan *Prepared Statement* (`$db->prepare()`) untuk mencegah celah *SQL Injection*.

2. **Kategori & Tema Visual:** Setiap kegiatan terikat pada jenis kategori (*Morning* atau *Night*) yang secara otomatis memengaruhi badge warna visual (`amber` atau `indigo`).

3. **Pilihan Hari Pengerjaan:** Rutinitas dapat dijadwalkan secara fleksibel per hari dalam seminggu (`Monday`–`Sunday`) atau setiap hari (`Everyday`).

4. **Status Eksekusi Log:** Log harian mencatat status aktivitas (`Completed`, `Pending`, atau `Skipped`) beserta catatan refleksi jurnal pengguna.

## Alur Kode Program

1. **Koneksi Database (`config/Database.php`):** Menggunakan kelas `Database` yang mengembalikan instance objek `mysqli` dan memastikan karakter encoding UTF-8.

2. **Pengolahan Objek & Data (`classes/`):**

   * Kelas `Category`, `Routine`, dan `RoutineLog` menerima instance koneksi `mysqli` pada konstruktornya.

   * Metode CRUD memanfaatkan *bind_param* dan *execute* untuk eksekusi query aman.

3. **Navigasi & Routing (`index.php`, `categories.php`, `routines.php`, `logs.php`):**

   * Setiap halaman memuat class yang dibutuhkan, menangani aksi form (`POST` untuk submit data, `GET` untuk hapus/edit), lalu merender tampilan yang sesuai.

   * Menggunakan alur *Post/Redirect/Get* (PRG) setelah pengiriman form untuk mencegah duplikasi pengiriman data saat halaman di-*refresh*.

## Langkah Menjalankan Aplikasi

### Kebutuhan Sistem

* PHP 8.0 atau versi yang lebih baru.

* Web Server (XAMPP / Laragon / Nginx / Apache).

* Database MySQL atau MariaDB.

### Langkah-Langkah Operasional

1. **Pindahkan Folder Proyek:**
   Simpan proyek di dalam folder web server lokal, misalnya:

   * `C:\xampp\htdocs\TP7DPBO2526C_DailyRoutine` (pada XAMPP)

   * `C:\laragon\www\TP7DPBO2526C_DailyRoutine` (pada Laragon)

2. **Import Database:**

   * Buka **phpMyAdmin** (`http://localhost/phpmyadmin/`).

   * Buat database baru bernama `db_daily_routine`.

   * Pilih menu **Import**, lalu upload dan jalankan file `db_daily_routine.sql` yang berada di root folder proyek.

3. **Konfigurasi Database (Jika Ada Perubahan Credential):**

   * Buka file `config/Database.php`.

   * Sesuaikan `host`, `user`, `pass`, dan `dbname` jika server lokalmu menggunakan credential berbeda (default: `localhost`, `root`, tanpa password).

4. **Menjalankan Web:**

   * Buka browser favoritmu, lalu akses URL:

     ```
     http://localhost/TP7DPBO2526C_DailyRoutine/
     
     ```

   * Atau jika menggunakan PHP Built-in Server, buka terminal di folder proyek dan jalankan:

     ```
     php -S 127.0.0.1:8000
     
     ```

     Lalu akses `http://127.0.0.1:8000` di browser.
