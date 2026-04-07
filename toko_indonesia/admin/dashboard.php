<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<h1>Selamat Datang Admin, <?php echo $_SESSION['username']; ?></h1>
<a href="tambah_gerai.php">Tambah Gerai Baru</a>
<a href="logout.php">Logout</a>