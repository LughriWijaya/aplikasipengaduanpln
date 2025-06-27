<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $koneksi->real_escape_string($_POST['username']);
    $password = $koneksi->real_escape_string($_POST['password']);

    $result = $koneksi->query("SELECT * FROM petugas WHERE username='$username' AND pasword='$password'");
    if ($result->num_rows > 0) {
        $_SESSION['petugas'] = $result->fetch_assoc();
        header('Location: petugas_dashboard.php');
        exit;
    }
    $error = "Username atau Password salah!";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Petugas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="header-pln">
        <h1>Aplikasi Pengaduan PLN</h1>
    </div>
    <div class="login-box">
        <h2>Login Petugas</h2>
        <?php if(isset($error)) echo "<div class='alert'>$error</div>"; ?>
        <form method="post">
            <input name="username" type="text" placeholder="Username" required>
            <input name="password" type="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="login-links">
            <a href="register_petugas.php">Belum punya akun? Daftar sebagai petugas</a><br>
            <a href="index.php">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
