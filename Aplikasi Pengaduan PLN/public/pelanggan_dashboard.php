<?php
include '../config/db.php';
if (!isset($_SESSION['pelanggan'])) {
    header('Location: login_pelanggan.php');
    exit;
}
$pelanggan = $_SESSION['pelanggan'];
$idpelanggan = $pelanggan['idpelanggan'];

// Hapus tanggapan jika ada permintaan hapus tanggapan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus_tanggapan']) && isset($_POST['idtanggapan'])) {
    $idtanggapan = intval($_POST['idtanggapan']);
    $koneksi->query("DELETE FROM tanggapan WHERE idtanggapan=$idtanggapan");
    $success = "Tanggapan berhasil dihapus!";
}

// Hapus riwayat pengaduan (beserta tanggapan jika ada)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['hapus_pengaduan']) && isset($_POST['idpengaduan'])) {
    $idpengaduan = intval($_POST['idpengaduan']);
    $koneksi->query("DELETE FROM tanggapan WHERE idpengaduan=$idpengaduan");
    $koneksi->query("DELETE FROM pengaduan WHERE idpengaduan=$idpengaduan AND idpelanggan=$idpelanggan");
    $success = "Riwayat pengaduan berhasil dihapus!";
}

// Kirim pengaduan
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['isipengaduan'])) {
    $isi = $koneksi->real_escape_string($_POST['isipengaduan']);
    $tgl = date('Y-m-d');
    $koneksi->query("INSERT INTO pengaduan (idpelanggan, tglpengaduan, isipengaduan) VALUES ($idpelanggan, '$tgl', '$isi')");
    $success = "Pengaduan berhasil dikirim!";
}

$pengaduan = $koneksi->query("SELECT * FROM pengaduan WHERE idpelanggan=$idpelanggan ORDER BY tglpengaduan DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pelanggan</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard Pelanggan</h2>
        <p>Nama: <b><?= htmlspecialchars($pelanggan['nama']) ?></b><br>
        No. Meteran: <b><?= htmlspecialchars($pelanggan['no_meteran']) ?></b><br>
        Alamat: <b><?= htmlspecialchars($pelanggan['alamat']) ?></b><br>
        Telepon: <b><?= htmlspecialchars($pelanggan['telepon']) ?></b></p>
        <a href="logout.php">Logout</a>
        <h3>Kirim Pengaduan</h3>
        <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
        <form method="post">
            <textarea name="isipengaduan" placeholder="Tulis pengaduan Anda..." required></textarea><br>
            <button type="submit">Kirim</button>
        </form>
        <h3>Riwayat Pengaduan</h3>
        <table>
        <tr>
            <th>Tanggal</th>
            <th>Isi Pengaduan</th>
            <th>Status</th>
            <th>Tanggal Tanggapan</th>
            <th>Tanggapan</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = $pengaduan->fetch_assoc()): 
            $tanggapan = $koneksi->query("SELECT * FROM tanggapan WHERE idpengaduan=".$row['idpengaduan']);
            $t = $tanggapan->fetch_assoc();
        ?>
        <tr>
            <td><?= $row['tglpengaduan'] ?></td>
            <td><?= htmlspecialchars($row['isipengaduan']) ?></td>
            <td><?= $row['statuspengaduan'] ?></td>
            <td><?= $t ? htmlspecialchars($t['tgltanggapan']) : '-' ?></td>
            <td><?= $t ? htmlspecialchars($t['isitanggapan']) : '-' ?></td>
            <td>
                <?php if($t): ?>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="idtanggapan" value="<?= $t['idtanggapan'] ?>">
                        <button type="submit" name="hapus_tanggapan" onclick="return confirm('Yakin hapus tanggapan ini?')">Hapus Tanggapan</button>
                    </form>
                <?php endif; ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="idpengaduan" value="<?= $row['idpengaduan'] ?>">
                    <button type="submit" name="hapus_pengaduan" onclick="return confirm('Yakin hapus riwayat pengaduan ini?')">Hapus Riwayat</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
        </table>
        <a href="index.php">Kembali ke Beranda</a>
    </div>
</body>
</html>
