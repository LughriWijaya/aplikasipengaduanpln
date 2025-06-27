<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "aplikasi_pengaduan_pln";

$koneksi = new mysqli($host, $user, $pass, $db);
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
