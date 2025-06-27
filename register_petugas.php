<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $namapetugas = $koneksi->real_escape_string($_POST['namapetugas']);
    $username = $koneksi->real_escape_string($_POST['username']);
    $pasword = $koneksi->real_escape_string($_POST['pasword']);

    $cek = $koneksi->query("SELECT * FROM petugas WHERE username='$username'");
    if ($cek->num_rows > 0) {
        $error = "Username sudah terdaftar!";
    } else {
        $koneksi->query("INSERT INTO petugas (namapetugas, username, pasword) VALUES ('$namapetugas', '$username', '$pasword')");
        header('Location: login_petugas.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Petugas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Registrasi Petugas</h2>
        <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
        <form method="post">
            Nama Petugas: <input name="namapetugas" required><br>
            Username: <input name="username" required><br>
            Password: <input name="pasword" type="password" required><br>
            <button type="submit">Daftar</button>
        </form>
        <a href="login_petugas.php">Sudah punya akun? Login di sini</a><br>
        <a href="index.php">Kembali ke Beranda</a>
    </div>
</body>
</html>
