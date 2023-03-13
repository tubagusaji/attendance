<h1 align="center">User Guide Attendance System.</h1>


##  Langkah 1: Instalasi
- Pastikan Anda memiliki server web (misalnya Apache) dan PHP diinstal pada komputer Anda.
- Buatlah database MySQL dengan nama "attendance".
- Buatlah tabel dengan nama "attendance_records" pada database "attendance". Tabel tersebut harus memiliki kolom sebagai berikut:

``` 
    id INT(11) NOT NULL AUTO_INCREMENT
employee_name VARCHAR(255) NOT NULL
date DATE NOT NULL
time_in TIME NOT NULL
time_out TIME NULL
PRIMARY KEY (id)
```


- Pastikan Anda telah memodifikasi kode PHP untuk menghubungkan ke database MySQL Anda, dengan cara mengubah nilai variabel $servername, $username, dan $password pada script PHP di bagian atas.

## Langkah 2: Menggunakan aplikasi

- Buka browser web dan buka tampilan form aplikasi Attendance dengan mengakses file PHP yang telah dibuat.
- Masukkan nama karyawan ke dalam field "Employee Name".
- Tekan tombol "Attendance" jika ingin mencatat kehadiran karyawan.
- Tekan tombol "Time Out" jika ingin mencatat waktu pulang karyawan dan menampilkan jumlah keterlambatan, jumlah pulang cepat, dan jumlah lembur.
- Hasil perhitungan keterlambatan, pulang cepat, dan lembur akan ditampilkan di bawah tombol "Time Out".
- Demikianlah user guide untuk menggunakan aplikasi Attendance dengan tampilan form yang telah dibuat sebelumnya.