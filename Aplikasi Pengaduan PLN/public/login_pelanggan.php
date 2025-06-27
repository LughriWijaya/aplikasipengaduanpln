<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $koneksi->real_escape_string($_POST['nama']);
    $no_meteran = $koneksi->real_escape_string($_POST['no_meteran']);

    $result = $koneksi->query("SELECT * FROM pelanggan WHERE nama='$nama' AND no_meteran='$no_meteran'");
    if ($result->num_rows > 0) {
        $_SESSION['pelanggan'] = $result->fetch_assoc();
        header('Location: pelanggan_dashboard.php');
        exit;
    }
    $error = "Nama atau No. Meteran salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Pelanggan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="header-pln">
        <h1>Aplikasi Pengaduan PLN</h1>
    </div>
    <div class="login-box">
        <h2>Login Pelanggan</h2>
        <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
        <form method="post">
            <input name="nama" type="text" placeholder="Nama" required>
            <input name="no_meteran" type="text" placeholder="No. Meteran" required>
            <button type="submit">Login</button>
        </form>
        <div class="login-links">
            <a href="register_pelanggan.php">Belum punya akun? Daftar di sini</a><br>
            <a href="index.php">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
