<?php
include '../koneksi.php';

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gerai') {
    header("Location: login.php");
    exit();
}
?>
<h1>Panel Gerai - Laporan Penjualan</h1>
<a href="logout.php">Logout</a>