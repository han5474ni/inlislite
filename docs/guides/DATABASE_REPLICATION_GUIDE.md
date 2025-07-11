# Panduan Replikasi Database INLISLite

## Daftar Isi
- [Pendahuluan](#pendahuluan)
- [Keuntungan Replikasi Database](#keuntungan-replikasi-database)
- [Arsitektur Replikasi](#arsitektur-replikasi)
- [Persyaratan Sistem](#persyaratan-sistem)
- [Konfigurasi Replikasi](#konfigurasi-replikasi)
  - [Konfigurasi Aplikasi](#konfigurasi-aplikasi)
  - [Konfigurasi Server MySQL](#konfigurasi-server-mysql)
- [Pengaturan Master Server](#pengaturan-master-server)
- [Pengaturan Slave Server](#pengaturan-slave-server)
- [Verifikasi Replikasi](#verifikasi-replikasi)
- [Pemantauan dan Pemeliharaan](#pemantauan-dan-pemeliharaan)
- [Pemecahan Masalah](#pemecahan-masalah)
- [FAQ](#faq)

## Pendahuluan

Replikasi database adalah proses menyalin dan memelihara objek database, seperti tabel, di beberapa database yang membentuk sistem database terdistribusi. Dalam konteks INLISLite, replikasi database memungkinkan Anda untuk memiliki salinan data yang sama di beberapa server, yang dapat meningkatkan ketersediaan, keandalan, dan kinerja aplikasi.

Dokumen ini memberikan panduan langkah demi langkah untuk mengatur replikasi MySQL di aplikasi INLISLite.

## Keuntungan Replikasi Database

1. **Ketersediaan Tinggi (High Availability)**: Jika server utama (master) mengalami kegagalan, server sekunder (slave) dapat mengambil alih untuk meminimalkan waktu henti.

2. **Peningkatan Kinerja**: Beban kueri dapat didistribusikan di beberapa server, dengan kueri baca diarahkan ke server slave dan kueri tulis ke server master.

3. **Backup Data**: Server slave dapat digunakan untuk melakukan backup tanpa mengganggu operasi pada server master.

4. **Distribusi Geografis**: Data dapat direplikasi ke server di lokasi geografis yang berbeda untuk mengurangi latensi akses bagi pengguna di berbagai lokasi.

5. **Sinkronisasi Antar Perangkat**: Memungkinkan perpustakaan dengan beberapa perangkat untuk menyinkronkan data secara real-time.

## Arsitektur Replikasi

INLISLite mendukung dua mode replikasi MySQL:

1. **Master-Slave Replication**:
   - Satu server master (untuk operasi tulis)
   - Satu atau lebih server slave (untuk operasi baca)
   - Perubahan data hanya dilakukan pada master dan direplikasi ke slave
   - Cocok untuk sebagian besar perpustakaan dengan beban kerja baca yang tinggi

2. **Master-Master Replication**:
   - Dua atau lebih server yang dapat menerima operasi tulis
   - Setiap server mereplikasi perubahan ke server lainnya
   - Cocok untuk perpustakaan dengan beberapa lokasi yang memerlukan kemampuan tulis di setiap lokasi

## Persyaratan Sistem

- MySQL 5.6 atau lebih tinggi (MySQL 8.0+ direkomendasikan)
- Binary logging diaktifkan pada server master
- Server ID unik untuk setiap server dalam konfigurasi replikasi
- Koneksi jaringan yang stabil antara server master dan slave
- Akun pengguna MySQL dengan hak istimewa replikasi

## Konfigurasi Replikasi

### Konfigurasi Aplikasi

1. **Aktifkan Replikasi di Aplikasi**:

   Buka halaman admin INLISLite dan navigasikan ke:
   ```
   Admin > Database Replication > Settings
   ```

   Aktifkan replikasi dan pilih mode yang sesuai (master-slave atau master-master).

2. **Konfigurasi File**:

   Secara manual, Anda dapat mengedit file konfigurasi replikasi di:
   ```
   app/Config/Replication.php
   ```

   Pastikan untuk mengatur parameter berikut:
   - `enabled`: true untuk mengaktifkan replikasi
   - `mode`: 'master-slave' atau 'master-master'
   - `master`: Konfigurasi server master
   - `slaves`: Array konfigurasi server slave
   - `tables`: Tabel yang akan direplikasi (kosongkan untuk semua tabel)
   - `excludeTables`: Tabel yang dikecualikan dari replikasi

### Konfigurasi Server MySQL

#### Persiapan Server Master

1. Edit file konfigurasi MySQL (`my.cnf` atau `my.ini`) pada server master:

   ```ini
   [mysqld]
   # Unique server ID
   server-id=1
   
   # Binary logging
   log-bin=mysql-bin
   binlog-format=ROW
   
   # Database to replicate
   binlog-do-db=inlislite
   
   # Optional: Ignore specific tables
   # binlog-ignore-table=inlislite.sessions
   # binlog-ignore-table=inlislite.logs
   ```

2. Restart server MySQL:

   ```bash
   sudo systemctl restart mysql   # For Linux with systemd
   # OR
   sudo service mysql restart     # For Linux with init.d
   # OR
   net stop mysql && net start mysql   # For Windows
   ```

#### Persiapan Server Slave

1. Edit file konfigurasi MySQL (`my.cnf` atau `my.ini`) pada server slave:

   ```ini
   [mysqld]
   # Unique server ID (different from master)
   server-id=2
   
   # Relay log
   relay-log=slave-relay-bin
   relay-log-index=slave-relay-bin.index
   
   # Read-only mode (recommended for slaves)
   read-only=1
   
   # Database to replicate
   replicate-do-db=inlislite
   
   # Optional: Ignore specific tables
   # replicate-ignore-table=inlislite.sessions
   # replicate-ignore-table=inlislite.logs
   ```

2. Restart server MySQL pada slave.

## Pengaturan Master Server

Untuk mengatur server master, gunakan skrip setup yang disediakan:

1. Jalankan skrip setup di server master:

   ```bash
   cd /path/to/inlislite
   php tools/database/setup_replication.php
   ```

2. Pilih opsi "1. Master Server" ketika diminta.

3. Skrip akan melakukan hal berikut:
   - Memeriksa versi MySQL
   - Memverifikasi konfigurasi server ID dan binary logging
   - Membuat pengguna replikasi dengan hak istimewa yang diperlukan
   - Menampilkan informasi status master yang diperlukan untuk mengatur slave
   - Menyimpan informasi master ke file `master_info.json`

4. Catat informasi master yang ditampilkan, termasuk:
   - Master Log File
   - Master Log Position
   - Kredensial pengguna replikasi

## Pengaturan Slave Server

1. Salin file `master_info.json` dari server master ke server slave di direktori yang sama.

2. Jalankan skrip setup di server slave:

   ```bash
   cd /path/to/inlislite
   php tools/database/setup_replication.php
   ```

3. Pilih opsi "2. Slave Server" ketika diminta.

4. Skrip akan melakukan hal berikut:
   - Memeriksa versi MySQL
   - Memverifikasi konfigurasi server ID
   - Mengonfigurasi slave untuk terhubung ke master menggunakan informasi dari `master_info.json`
   - Memulai proses replikasi
   - Memverifikasi status replikasi

## Verifikasi Replikasi

Untuk memverifikasi bahwa replikasi berfungsi dengan benar:

1. Buka halaman admin INLISLite dan navigasikan ke:
   ```
   Admin > Database Replication
   ```

2. Panel status akan menampilkan:
   - Status koneksi master dan slave
   - Status thread IO dan SQL pada slave
   - Posisi log master dan slave
   - Lag replikasi (keterlambatan antara master dan slave)
   - Error replikasi (jika ada)

3. Anda juga dapat memeriksa status replikasi secara manual di MySQL:

   Pada server master:
   ```sql
   SHOW MASTER STATUS;
   ```

   Pada server slave:
   ```sql
   SHOW SLAVE STATUS\G
   ```

## Pemantauan dan Pemeliharaan

### Pemantauan Rutin

1. **Periksa Status Replikasi**: Periksa dashboard replikasi secara berkala untuk memastikan replikasi berjalan dengan baik.

2. **Pantau Lag Replikasi**: Lag yang tinggi dapat mengindikasikan masalah kinerja atau bottleneck jaringan.

3. **Periksa Error**: Periksa log error MySQL untuk masalah terkait replikasi.

### Pemeliharaan

1. **Backup**: Lakukan backup reguler pada server master dan slave.

2. **Pembaruan Skema**: Saat mengubah skema database (misalnya, menambahkan tabel atau kolom), pastikan perubahan diterapkan secara konsisten di semua server.

3. **Pembaruan MySQL**: Saat memperbarui MySQL, perbarui semua server dalam konfigurasi replikasi untuk menghindari masalah kompatibilitas.

## Pemecahan Masalah

### Masalah Umum dan Solusi

1. **Replikasi Berhenti**:

   Periksa status slave:
   ```sql
   SHOW SLAVE STATUS\G
   ```

   Jika ada error, catat pesan error dan posisi log. Untuk memulai ulang replikasi:
   ```sql
   STOP SLAVE;
   START SLAVE;
   ```

2. **Lag Replikasi Tinggi**:

   - Periksa beban server slave
   - Optimalkan kueri yang berjalan lama
   - Pertimbangkan untuk meningkatkan spesifikasi hardware slave
   - Distribusikan beban baca ke beberapa slave

3. **Inkonsistensi Data**:

   Jika data antara master dan slave tidak konsisten, Anda mungkin perlu menyinkronkan ulang slave:
   ```sql
   STOP SLAVE;
   RESET SLAVE;
   ```

   Kemudian ikuti langkah-langkah pengaturan slave dari awal.

4. **Error Duplikasi Kunci**:

   Jika terjadi error duplikasi kunci, Anda dapat menggunakan opsi `sql_slave_skip_counter` untuk melewati pernyataan yang bermasalah:
   ```sql
   STOP SLAVE;
   SET GLOBAL sql_slave_skip_counter = 1;
   START SLAVE;
   ```

## FAQ

### Pertanyaan Umum

1. **Berapa banyak slave yang dapat saya miliki?**

   Secara teoritis, tidak ada batasan jumlah slave. Namun, setiap slave tambahan akan meningkatkan beban pada server master. Untuk sebagian besar perpustakaan, 1-3 slave sudah cukup.

2. **Apakah saya perlu menggunakan replikasi?**

   Replikasi berguna jika Anda memiliki:
   - Beban kerja baca yang tinggi yang dapat didistribusikan
   - Kebutuhan untuk ketersediaan tinggi
   - Beberapa lokasi yang perlu mengakses data yang sama
   - Kebutuhan untuk backup tanpa mengganggu operasi utama

3. **Bagaimana cara menangani pemadaman listrik atau restart server?**

   Replikasi MySQL dirancang untuk melanjutkan secara otomatis setelah restart. Namun, selalu periksa status replikasi setelah pemadaman listrik atau restart yang tidak direncanakan.

4. **Apakah replikasi memengaruhi kinerja aplikasi?**

   Replikasi dapat meningkatkan kinerja aplikasi dengan mendistribusikan beban kueri. Namun, ada overhead kecil pada server master untuk menulis ke binary log. Dalam sebagian besar kasus, manfaat distribusi beban jauh melebihi overhead ini.

5. **Bagaimana cara mengubah konfigurasi replikasi yang sudah berjalan?**

   Perubahan pada konfigurasi replikasi di `app/Config/Replication.php` akan berlaku setelah aplikasi dimulai ulang. Untuk perubahan pada konfigurasi MySQL, Anda perlu mengedit file konfigurasi MySQL dan me-restart layanan MySQL.

---

Untuk bantuan lebih lanjut, silakan hubungi tim dukungan INLISLite atau konsultasikan dengan administrator database Anda.