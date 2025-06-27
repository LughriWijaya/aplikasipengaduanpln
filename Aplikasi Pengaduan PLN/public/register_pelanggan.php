<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $no_meteran = $koneksi->real_escape_string($_POST['no_meteran']);
    $alamat = $koneksi->real_escape_string($_POST['alamat']);
    $telepon = $koneksi->real_escape_string($_POST['telepon']);

    $cek = $koneksi->query("SELECT * FROM pelanggan WHERE no_meteran='$no_meteran'");
    if ($cek->num_rows > 0) {
        $error = "No. Meteran sudah terdaftar!";
    } else {
        $koneksi->query("INSERT INTO pelanggan (nama, no_meteran, alamat, telepon) VALUES ('$nama', '$no_meteran', '$alamat', '$telepon')");
        header('Location: login_pelanggan.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Pelanggan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Registrasi Pelanggan</h2>
        <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
        <form method="post">
            Nama: <input name="nama" required><br>
            No. Meteran: <input name="no_meteran" required><br>
            Alamat: <input name="alamat" required><br>
            Telepon: <input name="telepon" required><br>
            <button type="submit">Daftar</button>
        </form>
        <a href="login_pelanggan.php">Sudah punya akun? Login di sini</a><br>
        <a href="index.php">Kembali ke Beranda</a>
    </div>
</body>
</html>
