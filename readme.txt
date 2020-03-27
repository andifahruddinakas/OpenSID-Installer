# OpenSID Installer

## Persiapan
- Siapkan OpenSID (https://github.com/OpenSID/OpenSID)
- Siapkan OpenSID-Installer (https://github.com/afa28/OpenSID-Installer)

## Database
Database yang digunakan :
1. Database Kosong (database hasil export contoh_data_awal_20200301a dengan pengosongan data awal melalui system opensid).
2. Database contoh data awal yg diikut sertakan pada setiap rilis dengan perubahan struktur hasil export phpmyadmin (agar menyesuaikan dengan instller).

Menggunakan database lain :
1. Siapkan database yang akan digunakan (database merupakan hasil export dari phpmyadmin).
2. Ganti nama file database menjadi "opensid.sql".
3. Salin file database ke dalam folder "intall/assets/sql" (Jika muncul peringatan timpa file, silahkan setujui).

## Cara Penggunaan
1. Extract OpenSID pada folder :
- localhost : folder project (../htdoc/nama_project)
- hosting : public_html
2. Extract Intaller-OpenSID (Jika muncul peringatan timpa file, silahkan setujui).
3. Buat database.
4. Buka website anda (contoh http://localhost/opensid/).
5. Ikuti arahan yang ada di form instalasi, lakukan input data jika dibutuhkan.
6. Setelah proses instalasi selesai, anda akan di arahkan ke halaman login admin. Silahkan login dan lakukan migrasi database (pengaturan>database>migrasi).


## Catatan
- Gunakan database yg baru/kosong (tidak ada tabel).
- Proses menghubungkan ke database include dengan porses import database, sehingga proses akan memakan waktu agak lama tergantung database yg digunakan dan kecepatan hsoting anda.
- Semua proses yg dibutuhkan opensid (sperti pembuatan folder desa) sudah include pada installer.
- Setelah proses instalasi selesai semua file.folder yang berhubungan dengan instalasi akan otomatis terhapus.