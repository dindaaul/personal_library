1. Rancangan Aplikasi (Topik & Sumber Data) 


Nama Aplikasi: Personal Library Manager.


Tujuan: Memungkinkan pengguna untuk mencari buku secara daring dan mengelola koleksi buku favorit pribadi.


Target Pengguna: Pengguna umum (pembaca buku).


Sumber Data: Menggunakan Open Library Search API (https://openlibrary.org/search.json).

2. Fitur Autentikasi & Keamanan 


Multi-User: Implementasikan sistem Register dan Login menggunakan fitur bawaan Laravel (seperti Laravel Breeze atau Fortify).


Security: Pastikan password di-hash menggunakan algoritma bcrypt (standar Laravel).


Data Isolation: Pastikan koleksi buku yang disimpan oleh User A tidak dapat diakses, diedit, atau dihapus oleh User B. Gunakan Relationship user_id pada setiap entri di database.

3. Integrasi Public API 


HTTP Request: Gunakan Http Client Laravel untuk mengambil data dari Open Library.


Display Data: Tampilkan hasil pencarian buku dalam bentuk Grid atau List yang memuat informasi seperti judul, penulis, dan tahun terbit.


Pencarian: Implementasikan fitur Search Bar untuk memfilter data buku berdasarkan judul atau pengarang langsung ke API eksternal.

4. Implementasi Fitur CRUD Lokal 

Buatlah fitur manipulasi data pada database lokal (MySQL/PostgreSQL) yang terhubung dengan hasil API:
+1


Create (Save to Collection): Tambahkan tombol "Simpan ke Perpustakaan" pada hasil pencarian API untuk memasukkan data buku tersebut ke database lokal pengguna.


Read (My Collection): Buat halaman khusus bagi pengguna untuk melihat daftar buku yang telah mereka simpan sendiri.


Update: Berikan kemampuan bagi pengguna untuk menambahkan "Catatan Pribadi" atau mengubah "Status Membaca" (misal: Belum Dibaca, Sedang Dibaca, Selesai) pada buku yang ada di daftar lokal mereka.


Delete: Sediakan fitur untuk menghapus buku dari daftar koleksi pribadi