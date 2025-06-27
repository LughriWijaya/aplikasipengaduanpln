<?php
include '../config/db.php';
if (!isset($_SESSION['petugas'])) {
    header('Location: login_petugas.php');
    exit;
}
$petugas = $_SESSION['petugas'];
$idpetugas = $petugas['idpetugas'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Hapus tanggapan
    if (isset($_POST['hapus_tanggapan']) && isset($_POST['idtanggapan'])) {
        $idtanggapan = intval($_POST['idtanggapan']);
        $koneksi->query("DELETE FROM tanggapan WHERE idtanggapan=$idtanggapan");
        $success = "Tanggapan berhasil dihapus!";
    }
    // Hapus riwayat pengaduan (beserta tanggapan jika ada)
    elseif (isset($_POST['hapus_pengaduan']) && isset($_POST['idpengaduan'])) {
        $idpengaduan = intval($_POST['idpengaduan']);
        $koneksi->query("DELETE FROM tanggapan WHERE idpengaduan=$idpengaduan");
        $koneksi->query("DELETE FROM pengaduan WHERE idpengaduan=$idpengaduan");
        $success = "Riwayat pengaduan berhasil dihapus!";
    }
    // Simpan/Update tanggapan
    elseif (isset($_POST['idpengaduan'])) {
        $idpengaduan = intval($_POST['idpengaduan']);
        $isitanggapan = $koneksi->real_escape_string($_POST['isitanggapan']);
        $tgl = date('Y-m-d');
        $status = $_POST['statuspengaduan'];
        $cek = $koneksi->query("SELECT * FROM tanggapan WHERE idpengaduan=$idpengaduan");
        if ($cek->num_rows == 0) {
            $koneksi->query("INSERT INTO tanggapan (idpengaduan, idpetugas, tgltanggapan, isitanggapan) VALUES ($idpengaduan, $idpetugas, '$tgl', '$isitanggapan')");
        } else {
            $koneksi->query("UPDATE tanggapan SET isitanggapan='$isitanggapan', tgltanggapan='$tgl', idpetugas=$idpetugas WHERE idpengaduan=$idpengaduan");
        }
        $koneksi->query("UPDATE pengaduan SET statuspengaduan='$status' WHERE idpengaduan=$idpengaduan");
        $success = "Tanggapan berhasil disimpan!";
    }
}

$pengaduan = $koneksi->query("SELECT p.*, pl.nama, pl.no_meteran FROM pengaduan p JOIN pelanggan pl ON p.idpelanggan=pl.idpelanggan ORDER BY p.tglpengaduan DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Petugas</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard Petugas</h2>
        <p>Nama Petugas: <b><?= htmlspecialchars($petugas['namapetugas']) ?></b></p>
        <a href="logout.php">Logout</a>
        <?php if(isset($success)) echo "<div class='success'>$success</div>"; ?>
        <h3>Daftar Pengaduan</h3>
        <table>
        <tr>
            <th>Pelanggan</th>
            <th>No. Meteran</th>
            <th>Tanggal</th>
            <th>Isi Pengaduan</th>
            <th>Status</th>
            <th>Tanggapan</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = $pengaduan->fetch_assoc()): 
            $tanggapan = $koneksi->query("SELECT * FROM tanggapan WHERE idpengaduan=".$row['idpengaduan']);
            $t = $tanggapan->fetch_assoc();
        ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['no_meteran']) ?></td>
            <td><?= $row['tglpengaduan'] ?></td>
            <td><?= htmlspecialchars($row['isipengaduan']) ?></td>
            <td><?= $row['statuspengaduan'] ?></td>
            <td>
                <?= $t ? htmlspecialchars($t['isitanggapan']) : '-' ?>
                <?php if($t): ?>
                    <br>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="idtanggapan" value="<?= $t['idtanggapan'] ?>">
                        <button type="submit" name="hapus_tanggapan" onclick="return confirm('Yakin hapus tanggapan?')">Hapus Tanggapan</button>
                    </form>
                <?php endif; ?>
            </td>
            <td>
                <form method="post" style="margin:0;">
                    <input type="hidden" name="idpengaduan" value="<?= $row['idpengaduan'] ?>">
                    <textarea name="isitanggapan" placeholder="Tanggapan..." required><?= $t ? htmlspecialchars($t['isitanggapan']) : '' ?></textarea>
                    <select name="statuspengaduan">
                        <option value="Pending" <?= $row['statuspengaduan']=='Pending'?'selected':'' ?>>Pending</option>
                        <option value="Proses" <?= $row['statuspengaduan']=='Proses'?'selected':'' ?>>Proses</option>
                        <option value="Selesai" <?= $row['statuspengaduan']=='Selesai'?'selected':'' ?>>Selesai</option>
                    </select>
                    <button type="submit">Simpan</button>
                </form>
                <form method="post" style="margin-top:8px;">
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
