# tugas-akhir-4
Nama : Syahrul Ghufron Al Hamdan 
NPM : 2315061063
Kelas : PPW C


1. Form Tambah Kontak dengan validasi
<img width="1009" height="899" alt="image" src="https://github.com/user-attachments/assets/3aab78e5-2012-46d2-9170-58f3aa2a41c0" />

Bagian ini merupakan codingan untuk pembuatan pengisian form untuk menambahkan kontak, disini user disuruh untuk mengisi nama lengkap, email, dan nomor telpon. Proses ini dimulai dengan pengecekan apakah form telah dikirimkan menggunakan metode POST (if ($_SERVER["REQUEST_METHOD"] == "POST")). Kemudian, skrip menjalankan validasi berurutan untuk setiap field: Nama divalidasi kekosongan dan formatnya (hanya huruf/spasi) menggunakan preg_match(); Email divalidasi kekosongan dan formatnya menggunakan filter_var(); dan Nomor Telepon divalidasi kekosongan dan diperiksa formatnya agar hanya mengandung angka dan karakter telepon yang umum. Jika ada kegagalan validasi, pesan kesalahan disimpan dalam array $errors. Akhirnya, jika $errors kosong (data valid), skrip membuat array $new_kontak dari input yang sudah dibersihkan, menambahkannya ke Session penyimpanan data ($_SESSION['contacts']), dan mempersiapkan redirect kembali ke halaman utama.

2. Tampilan Daftar Kontak
<img width="844" height="576" alt="image" src="https://github.com/user-attachments/assets/32c04e99-6afb-463b-b0e4-f3ff9bea3e2c" />

Bagian selanjutnya disini ada codingan yang membuat tabel untuk menampilkan seluruh data kontak yang telah ditambahkan. Tugasnya adalah mengambil data kontak yang tersimpan di PHP Session dan mengubahnya menjadi tabel yang rapi di browser. Logika intinya berada pada perulangan foreach($_SESSION['contacts'] as $id => $kontak); loop ini berjalan untuk setiap kontak yang pernah diinputkan dan disimpan. Setiap kali perulangan berjalan, codingan ini membuat satu baris baru (<tr>) di tabel. Di dalam baris itu, kita langsung menampilkan data spesifik yang diinputkan pengguna (misalnya Nama, Email, Telepon) ke dalam sel-sel tabel (<td>). Selanjutnya juga terdapat tombol Edit dan Hapus di kolom Aksi dengan menyertakan $id (indeks unik kontak) pada link URL-nya. Ini memastikan semua data yang sudah disimpan (dan tidak hilang karena logout) dimasukkan ke daftar, dan setiap baris memiliki tombol aksi yang spesifik menargetkan kontak tersebut.

3. Fitur Edit
<img width="1183" height="791" alt="image" src="https://github.com/user-attachments/assets/2cb711d8-aa9a-43d7-ba1e-eed387c7f079" />

Selanjutnya terdapat fitur Edit Kontak di sisi server. Pada codingan tersebut terdapat dua logika utama yaitu memuat data lama dan memproses pembaruan. Saat halaman pertama kali dibuka (method GET), codingan mengambil ID kontak dari URL dan menggunakan ID itu untuk menarik data kontak yang sudah ada dari Session penyimpanan ($_SESSION['contacts'][$id_edit]). Data lama ini kemudian digunakan untuk mengisi (pre-fill) form HTML. Kemudian, ketika pengguna menekan tombol submit (method POST), codingan menjalankan validasi yang sama persis seperti pada fitur tambah kontak. Jika validasi sukses, array kontak di dalam Session langsung diperbarui di key ($id_edit) yang sama dengan data baru ($_SESSION['contacts'][$id_edit] = [...]). Setelah pembaruan berhasil, pesan sukses disimpan, dan pengguna diarahkan kembali ke halaman utama.

4. Fitur Hapus
<img width="974" height="427" alt="image" src="https://github.com/user-attachments/assets/be533144-4784-4773-b083-1c63f48b8a82" />

Selanjutnya terdapat fitur hapus kontak. Pertama, di dalam tabel daftar kontak, setiap baris data memiliki tombol Hapus yang merupakan link HTML yang mengirimkan permintaan ke halaman utama (index.php?action=hapus) sambil menyertakan ID unik kontak (&id=<?= $id; ?>) yang diambil dari key array Session. Kedua, di bagian atas kode PHP di index.php, terdapat logika yang mengecek apakah permintaan action=hapus diterima; jika iya, codingan menggunakan ID yang dikirim untuk menghapus elemen tersebut dari array $_SESSION['contacts'] menggunakan fungsi unset(). Setelah penghapusan, array di-re-index menggunakan array_values() untuk memastikan nomor urut tabel tidak rusak, pesan sukses disimpan, dan halaman di-refresh untuk menampilkan daftar yang sudah diperbarui.

5. Session Management
<img width="707" height="120" alt="image" src="https://github.com/user-attachments/assets/4029806f-d94e-4064-bf98-85bb7936369e" />

Selanjtunya terdapat perintah session_start(); yang wajib untuk memulai atau melanjutkan sesi yang sudah ada di server. Setelah sesi aktif, kode menjalankan pemeriksaan keamanan melalui blok if. Kondisi if tersebut mengecek dua hal: apakah variabel sesi $_SESSION['logged_in'] belum diatur (!isset(...)) ATAU apakah nilainya bukan true (!== true). Jika salah satu dari kondisi ini terpenuhi, itu berarti pengguna belum berhasil login atau sesi mereka sudah berakhir, sehingga server akan mengirimkan perintah pengalihan (header("Location: login.php");) yang memaksa browser untuk memuat halaman login. Perintah exit; yang mengikuti redirect sangat penting karena memastikan eksekusi kode pada halaman yang dilindungi (misalnya tabel kontak) dihentikan seketika, mencegah konten rahasia tampil ke pengguna yang tidak berhak.

<img width="676" height="196" alt="image" src="https://github.com/user-attachments/assets/01aa2b85-4f61-4d35-98cb-dd5cf97e2f9b" />

Selanjtunya terdapat perintah yg dieksekusi jika username dan password yang dimasukkan pengguna cocok dengan nilai yang valid (if ($username === $username_valid && $password === $password_valid)). Di dalamnya, pertama-tama server akan menyetel dua flag penting: $_SESSION['logged_in'] = true; (yang menandakan pengguna sah dan memberikan akses ke halaman terproteksi) dan $_SESSION['username'] = $username; (untuk menampilkan nama pengguna di dashboard). Selain itu, terdapat pengecekan if (!isset($_SESSION['contacts'])) yang sangat penting; jika array data kontak di session belum pernah dibuat, maka codingan akan menginisialisasinya menjadi array kosong ([]) agar data kontak dapat ditambahkan di kemudian hari tanpa menimbulkan error. Setelah semua sesi disiapkan, user akan diarahkan ke halaman utama.

<img width="398" height="142" alt="image" src="https://github.com/user-attachments/assets/2f73ad58-9735-4642-b5fc-fc5d46a87ce7" />

Selanjutnya terdapat fitur Logout yang aman dan lengkap, memastikan bahwa sesi pengguna diakhiri secara menyeluruh. Prosesnya dimulai dengan session_start(); untuk mengakses variabel sesi yang sedang aktif. Selanjutnya, $_SESSION = array(); digunakan untuk menghapus semua variabel yang tersimpan dalam sesi saat ini, termasuk flag login (logged_in) dan semua data kontak yang disimpan di $_SESSION['contacts']. Kemudian, fungsi session_destroy(); dipanggil untuk secara fisik menghancurkan session itu sendiri di server. Setelah sesi diakhancurkan, user diarahkan kembali (header("Location: login.php")) ke halaman login, dan perintah exit; memastikan eksekusi skrip dihentikan agar redirect dapat berjalan dengan benar.

