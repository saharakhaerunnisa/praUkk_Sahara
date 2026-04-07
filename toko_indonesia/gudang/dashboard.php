<?php
include '../koneksi.php';
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'gudang') {
    header("Location: login.php");
    exit();
}
?>
<h1>Panel Gudang - Stok Barang</h1>
<a href="logout.php">Logout</a>