# Project 1 Aplikasi Gudang dengan Laravel 11 by TIM IT Clarice

📌 Sudah Clone Proyek, dengan perintah :
```sh
git clone https://github.com/ClariceIT/app-gudang.git
```
kemudian
```sh
cd app-gudang
```

##1️⃣ **Install Laravel Dependencis**
Untuk menginstal semua paket Laravel yang diperlukan. 
```sh
composer install
```
##2️⃣ **Buat dan Atur File** `.env`Laravel 
```sh
cp .env.example .env
```
Lalu generate aplikasi key
```sh 
php artisan key:generate
```

##3️⃣Setup database :
<br>**✅Import dengan TablePlus (XAMPP juga hampir sama) **
1. Buka TablePlus → Pilih gudang_db.
2. Klik File → Import.
3. Pilih db_gudangg.sql dari proyek.
4. Klik Open untuk mulai import.

##4️⃣edit file .env untuk konfigurasi Database <br>
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_gudangg
DB_USERNAME=root
DB_PASSWORD=
```
**Pastikan database sudah terkoneksi dengan MySQL Laragon**

##5️⃣Jalankan Perintah
```sh
php artisan migrate --seed
```
**🚀Ini akan memperbarui tabel database sesuai skema Laravel.**

UserLogin :
<br>user : admin
<br>password : arjuna123

##Setelah melakukan perubahan pada apa yang dikerjakan
→ Tambahkan perubahan
```sh
git add .
```
→ Simpan perubahan
***WAJIB ISI COMMIT dengan keterangan !!!***
```sh
git commit -m "Deskripsi perubahan"
```
Lakukan ini jika ada konflig
<br>```git pull origin main --rebase``` → Ambil update terbaru sebelum push
<br>→ Kirim perubahan ke GitHub
```sh
git push origin main
```
<br>
##Mengupdate dari apa yang dikerjakan rekan tim

<br>→ Tarik update terbaru
```sh
git pull origin main
```
<br>→ Jika ada perubahan dependensi
```
composer install & npm install
```
<br>→ Jika ada update database
```
php artisan migrate
``` 
#Konfigurasi branch 


1️⃣ cek Branch yang ada

```sh
git branch -a
```


2️⃣ Jika tidak ada Branch yang dituju

```sh
git checkout -b namaBranch origin/namaBranch
```

Jika tidak bisa, remote branch
```sh
git fetch --all
```


3️⃣ Pindah ke branch yang mau dituju
``sh
git checkout namaBranch
``


4️⃣pull dari brach yang dipilih
```sh
git pull origin namaBranch
```





##SEMANGAT🔥❤️‍🔥
