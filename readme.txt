# OpenSID Installer

## Persiapan
- Buka dan edit php.ini, ganti "max_execution_time=30" jadi "max_execution_time=0" dan restart xampp
- Jalankan xampp (Aphace dan MySQL)
- Siapkan OpenSID (https://github.com/OpenSID/OpenSID/releases)
- Siapkan OpenSID-Installer (https://github.com/afa28/OpenSID-Installer/releases)

## Database
- Database yang digunakan adalah database opensid versi 20.30-pasca (contoh_data_awal_20200301a) dengan perubahan yakni pengosongan data awal.
- Jika ingin menggunakan database lain silahkan hapus /timpa database default yang ada pada folder : intall/assets/sql kemudian ganti dengan database yang anda inginkan (jangan lupa ganti nama database tersebut menjadi "opensid.sql")

## Cara Penggunaan
- Extract OpenSID
- Extract Intaller-OpenSID (Jika ada file yg sama silahkan tipa)
- Buat database kosong (misal : opensid)
- Buka website anda (contoh http://localhost/opensid/)
- Ikuti arahan yang ada di form, lakukan input data jika dibutuhkan
- Login dan lakukan migrasi database


## Catatan
- Gunakan database yg baru / kosong (tidak ada tabel)
- Pada proses menghubungkan ke database akan sedikit lama tergantung database/data awal yang anda gunakan
- Setelah proses instalasi selesai anda akan di alihkan ke halaman login (siteman) website anda dan folder/file yang berhubungan dengan instalasi akan otomatis terhapus
